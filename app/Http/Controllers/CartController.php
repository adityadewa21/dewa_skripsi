<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'qty' => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::findOrFail($request->variant_id);

        // 🔥 CEK STOK
        if ($request->qty > $variant->stock) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // 🔥 AMBIL / BUAT CART
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        // 🔥 CEK ITEM SUDAH ADA
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($item) {
            $newQty = $item->quantity + $request->qty;

            if ($newQty > $variant->stock) {
                return back()->with('error', 'Stok tidak mencukupi');
            }

            $item->update([
                'quantity' => $newQty
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $variant->id,
                'quantity' => $request->qty,
                'price' => $variant->price
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }
    public function index()
    {
        $cart = Cart::with('items.variant.product.primaryImage')
            ->where('user_id', auth()->id())
            ->first();

        $items = $cart?->items ?? collect();

        $total = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('cart.index', compact('items', 'total'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::findOrFail($id);
        $variant = $item->variant;

        if ($request->quantity > $variant->stock) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $item->update([
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Qty berhasil diupdate');
    }
    public function delete($id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Item dihapus dari keranjang');
    }
}
