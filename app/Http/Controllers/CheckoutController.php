<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;
use DB;

class CheckoutController extends Controller
{
    public function index(Request $request, $slug)
    {
        $product = Product::with('variants')
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->firstOrFail();

        $variant = $product->variants
            ->where('id', $request->variant_id)
            ->firstOrFail();

        $qty = max(1, (int) $request->qty);
        $user = auth()->user();

        return view('checkout.index', [
            'product' => $product,
            'variant' => $variant,
            'qty'     => $qty,
            'customer' => [
                'name'    => old('customer_name', $user->name ?? ''),
                'email'   => old('email', $user->email ?? ''),
                'phone'   => old('customer_phone', $user->phone ?? ''),
                'address' => old('customer_address', $user->address ?? ''),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity'   => 'required|integer|min:1',

            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string',
        ]);

        return DB::transaction(function () use ($request) {

            $variant = ProductVariant::lockForUpdate()->findOrFail($request->variant_id);
            $product = Product::findOrFail($request->product_id);

            /* ===============================
            * CEK STOK
            * =============================== */
            if ($variant->stock < $request->quantity) {
                return back()->withErrors([
                    'quantity' => 'Stok tidak mencukupi. Sisa stok: '.$variant->stock
                ])->withInput();
            }

            $total = $variant->price * $request->quantity;

            /* ===============================
            * SIMPAN ORDER
            * =============================== */
            $orderCode = 'ORD-' . strtoupper(Str::random(8));
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => $orderCode,

                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone,
                'customer_address' => $request->customer_address,

                'total_price' => $total,
                'status' => 'menunggu konfirmasi',

                'whatsapp_message' => $this->generateWhatsappMessage(
                    $orderCode,
                    $product,
                    $variant,
                    $request->quantity,
                    $total
                ),
            ]);

            /* ===============================
            * SIMPAN ITEM
            * =============================== */
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'product_name' => $product->name,
                'color_name' => $variant->color_name,
                'price' => $variant->price,
                'quantity' => $request->quantity,
            ]);

            /* ===============================
            * KURANGI STOK
            * =============================== */
            $variant->decrement('stock', $request->quantity);

            return redirect()->route('checkout.success', $order->id);
        });
    }

    private function generateWhatsappMessage($orderCode, $product, $variant, $qty, $total)
    {
        return urlencode(
            "Halo Admin,\n\n" .
            "Order ID : {$orderCode}\n" .
            "Produk : {$product->name}\n" .
            "Varian : {$variant->color_name}\n" .
            "Qty    : {$qty}\n" .
            "Total  : Rp " . number_format($total, 0, ',', '.') . "\n\n" .
            "Mohon info pembayaran 🙏"
        );
    }

    public function success(Order $order)
    {
        $order->load('orderItems');
        return view('checkout.success', compact('order'));
    }

    public function cart()
    {
        $cart = \App\Models\Cart::with('items.variant.product')
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart kosong');
        }

        $user = auth()->user();

        return view('checkout.cart', [
            'cart' => $cart,
            'customer' => [
                'name'    => old('customer_name', $user->name ?? ''),
                'phone'   => old('customer_phone', $user->phone ?? ''),
                'address' => old('customer_address', $user->address ?? ''),
            ]
        ]);
    }
    public function storeCart(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string',
        ]);

        return DB::transaction(function () use ($request) {

            $cart = \App\Models\Cart::with('items.variant.product')
                ->where('user_id', auth()->id())
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return back()->with('error', 'Cart kosong');
            }

            $total = 0;
            $itemsData = [];

            /* ===============================
            * VALIDASI & HITUNG TOTAL
            * =============================== */
            foreach ($cart->items as $item) {

                $variant = ProductVariant::lockForUpdate()->find($item->product_variant_id);

                if ($variant->stock < $item->quantity) {
                    return back()->withErrors([
                        'stock' => "Stok {$variant->color_name} tidak cukup"
                    ]);
                }

                $subtotal = $variant->price * $item->quantity;
                $total += $subtotal;

                $itemsData[] = [
                    'product' => $item->variant->product,
                    'variant' => $variant,
                    'qty' => $item->quantity,
                    'price' => $variant->price,
                ];
            }

            /* ===============================
            * SIMPAN ORDER
            * =============================== */
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),

                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone,
                'customer_address' => $request->customer_address,

                'total_price' => $total,
                'status' => 'menunggu konfirmasi',

                'whatsapp_message' => $this->generateWhatsappMessageCart($itemsData, $total)
            ]);

            /* ===============================
            * SIMPAN ITEMS + KURANGI STOK
            * =============================== */
            foreach ($itemsData as $data) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $data['product']->id,
                    'product_variant_id' => $data['variant']->id,
                    'product_name' => $data['product']->name,
                    'color_name' => $data['variant']->color_name,
                    'price' => $data['price'],
                    'quantity' => $data['qty'],
                ]);

                // kurangi stok
                $data['variant']->decrement('stock', $data['qty']);
            }

            /* ===============================
            * KOSONGKAN CART
            * =============================== */
            $cart->items()->delete();

            return redirect()->route('checkout.success', $order->id);
        });
    }
    private function generateWhatsappMessageCart($items, $total)
    {
        $message = "Halo Admin,\n\nOrder Baru:\n\n";

        foreach ($items as $item) {
            $message .=
                "Produk : {$item['product']->name}\n" .
                "Varian : {$item['variant']->color_name}\n" .
                "Qty    : {$item['qty']}\n\n";
        }

        $message .=
            "Total : Rp " . number_format($total, 0, ',', '.') . "\n\n" .
            "Mohon info pembayaran 🙏";

        return urlencode($message);
    }
}
