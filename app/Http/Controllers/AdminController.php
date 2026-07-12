<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\User;
use App\Models\MonthlyProductSale;
use Carbon\Carbon;
use DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalProduct' => Product::count(),
            'totalOrder'   => Order::count(),
            'totalUser'    => User::where('role', 'customer')->count(),
            'pendingOrder' => Order::where('status', 'menunggu konfirmasi')->count(),
        ]);
    }
    public function order()
    {
        $orders = Order::latest()->paginate(10);

        return view('admin.order', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems');

        return view('admin.order-show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // UPDATE STATUS ORDER
        $order->update([
            'status' => $newStatus
        ]);

        /**
         * 🔥 TAMBAH MONTHLY SALES
         * HANYA JIKA MASUK KE STATUS "processed"
         */
        if ($oldStatus !== 'diproses' && $newStatus === 'diproses') {

            $order->load('orderItems');

            foreach ($order->orderItems as $item) {

                $month = now()->format('Y-m');

                $monthly = MonthlyProductSale::firstOrCreate(
                    [
                        'product_id' => $item->product_id,
                        'month' => $month,
                    ],
                    [
                        'total_sold' => 0,
                    ]
                );

                $monthly->increment('total_sold', $item->quantity);
            }
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function index()
    {
        $customers = User::where('role', 'customer')
        ->latest()
        ->get();

        return view('admin.customer', compact('customers'));
    }
    public function detailCustomer(User $user)
    {
        abort_if($user->role !== 'customer', 404);

        return view('admin.detail-customer', compact('user'));
    }

    public function monthlySales()
    {
        $currentMonth = now()->format('Y-m');

        /* ===============================
        * PRODUK TERLARIS BULAN INI
        * =============================== */
        $topProducts = MonthlyProductSale::with('product')
            ->where('month', $currentMonth)
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        /* ===============================
        * GRAFIK MONTHLY SALES
        * =============================== */
        $salesRaw = MonthlyProductSale::with('product')
            ->select('product_id', 'month', DB::raw('SUM(total_sold) as total'))
            ->groupBy('product_id', 'month')
            ->orderBy('month')
            ->get();

        $labels = $salesRaw->pluck('month')->unique()->values();

        $salesChart = [
            'labels' => $labels,
            'datasets' => []
        ];

        foreach ($salesRaw->groupBy('product.name') as $productName => $rows) {
            $salesChart['datasets'][] = [
                'label' => $productName,
                'data' => $labels->map(
                    fn ($month) => $rows->firstWhere('month', $month)->total ?? 0
                ),
                'borderWidth' => 2,
                'tension' => 0.3
            ];
        }

        /* ===============================
        * GRAFIK PRODUCT VIEWS
        * =============================== */
        $viewRaw = ProductView::select(
                'product_id',
                DB::raw('COUNT(*) as total_view')
            )
            ->whereMonth('viewed_at', now()->month)
            ->whereYear('viewed_at', now()->year)
            ->groupBy('product_id')
            ->with('product')
            ->get();

        $viewChart = [
            'labels' => $viewRaw->pluck('product.name'),
            'data'   => $viewRaw->pluck('total_view'),
        ];

        /* ===============================
        * PRODUK PALING BANYAK DILIHAT
        * =============================== */
        $topViewedProducts = Product::withCount('views')
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();

        /* ===============================
        * RINGKASAN
        * =============================== */
        $totalProducts = Product::count();
        $totalViews    = ProductView::count();
        $totalOrders   = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.analytics', compact(
            'currentMonth',
            'topProducts',
            'salesChart',
            'viewChart',
            'topViewedProducts',
            'totalProducts',
            'totalViews',
            'totalOrders'
        ));
    }

    // DETAIL PER PRODUK
    public function detailMonthlySales(Product $product)
    {
        $product->load('monthlySales');

        // total view
        $totalViews = $product->views()->count();

        return view('admin.analytics-show', compact(
            'product',
            'totalViews'
        ));
    }
}
