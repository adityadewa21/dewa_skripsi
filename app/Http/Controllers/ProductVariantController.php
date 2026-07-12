<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:ready,preorder',
            'po_estimation_days' => 'nullable|integer|min:1'
        ]);

        ProductVariant::create($request->all());

        return back()->with('success', 'Varian berhasil ditambahkan');
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'color_name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:ready,preorder',
            'po_estimation_days' => 'nullable|integer|min:1'
        ]);

        $variant->update($request->all());

        return back()->with('success', 'Varian berhasil diperbarui');
    }

    public function destroy(ProductVariant $variant)
    {
        $variant->delete();

        return back()->with('success', 'Varian berhasil dihapus');
    }
}
