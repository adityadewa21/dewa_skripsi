<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\MonthlyProductSale;
use Illuminate\Support\Facades\DB;
use App\Models\ProductView;

class IndexController extends Controller
{
    public function index()
    {
        $topProduct = Product::with(['primaryImage', 'category'])
        ->joinSub(
            DB::table('monthly_product_sales')
                ->select('product_id', DB::raw('SUM(total_sold) as total_sold'))
                ->groupBy('product_id'),
            'sales',
            function ($join) {
                $join->on('products.id', '=', 'sales.product_id');
            }
        )
        ->where('products.is_active', 1)
        ->orderByDesc('sales.total_sold')
        ->select('products.*') // penting
        ->first();

        return view('index', [
            'categories'  => $this->categories(),
            'newArrivals' => $this->newArrivals(),
            'bestSellers' => $this->bestSellers(),
            'recommended' => $this->recommendedProducts(),
            'topProduct' => $topProduct,
        ]);
    }

    /* ===============================
     * CATEGORY (YANG ADA PRODUK AKTIF)
     * =============================== */
    private function categories()
    {
        return Category::whereHas('products', function ($q) {
                $q->where('is_active', 1);
            })
            ->withCount([
                'products as active_products_count' => function ($q) {
                    $q->where('is_active', 1);
                }
            ])
            ->orderBy('name')
            ->get();
    }

    /* ===============================
     * NEW ARRIVALS (TERBARU)
     * =============================== */
    private function newArrivals()
    {
        return Product::with(['category', 'primaryImage'])
            ->where('is_active', 1)
            ->latest()
            ->limit(8)
            ->get();
    }

    /* ===============================
     * BEST SELLER (TOP PENJUALAN)
     * =============================== */
    private function bestSellers()
    {
        $sales = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id');

        return Product::with(['category', 'primaryImage'])
            ->joinSub($sales, 'sales', function ($join) {
                $join->on('products.id', '=', 'sales.product_id');
            })
            ->where('products.is_active', 1)
            ->orderByDesc('sales.total_sold')
            ->limit(8)
            ->get();
    }

    private function recommendedProducts()
    {
        $topViewed = Product::with(['category', 'primaryImage'])
            ->where('is_active', 1)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->limit(8)
            ->get();

        // fallback kalau belum ada data view
        if ($topViewed->count() === 0) {
            return Product::with(['category', 'primaryImage'])
                ->where('is_active', 1)
                ->inRandomOrder()
                ->limit(8)
                ->get();
        }

        return $topViewed;
    }

    /* ===============================
     * CONTACT PAGE
     * =============================== */
    public function contact()
    {
        return view('contact');
    }
}
