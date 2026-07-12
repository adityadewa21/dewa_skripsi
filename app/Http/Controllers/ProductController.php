<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductView;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price'  => 'required|numeric|min:0',
            'is_active'   => 'required|boolean'
        ]);

        Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'base_price'  => $request->base_price,
            'is_active'   => $request->is_active,
            'total_view'  => 0
        ]);

        return redirect()->route('products')
            ->with('success', 'Product berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $products = Product::where('is_active', 1)->get();
        $categories = Category::all();
        // VARIANT & IMAGE NANTI, SEKARANG BIARIN DULU
        return view('products.edit', compact('product','products','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price'  => 'required|numeric|min:0',
            'is_active'   => 'required|boolean'
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'base_price'  => $request->base_price,
            'is_active'   => $request->is_active,
        ]);

        return redirect()->route('products.edit', $product)
            ->with('success', 'Product berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products')
            ->with('success', 'Product berhasil dihapus');
    }
    public function show(Request $request, $slug)
    {
        $product = Product::with([
                'category',
                'variants',
                'images',
                'primaryImage'
            ])
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->firstOrFail();

        // 🔥 CATAT VIEW
        $this->storeProductView($product, $request);

        return view('products.show', compact('product'));
    }

    private function storeProductView(Product $product, Request $request)
    {
        $ip = $request->ip();
        $today = Carbon::today();

        // Cegah double view dari IP yang sama di hari yang sama
        $alreadyViewed = ProductView::where('product_id', $product->id)
            ->where('ip_address', $ip)
            ->whereDate('viewed_at', $today)
            ->exists();

        if (!$alreadyViewed) {
            ProductView::create([
                'product_id' => $product->id,
                'ip_address' => $ip,
                'viewed_at'  => now(),
            ]);

            // optional: simpan total view di product
            $product->increment('total_view');
        }
    }

    public function all()
    {
        $newArrivals = Product::with(['category', 'primaryImage'])
            ->where('is_active', 1)
            ->latest()
            ->get();

        return view('products.all', compact('newArrivals'));
    }
}
