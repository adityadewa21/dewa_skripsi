<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');

            ProductImage::create([
                'product_id' => $request->product_id,
                'image_path' => $path,
                'is_primary' => false
            ]);
        }

        return back()->with('success','Gambar berhasil diupload');
    }

    public function setPrimary(ProductImage $image)
    {
        // reset semua image produk
        ProductImage::where('product_id', $image->product_id)
            ->update(['is_primary' => false]);

        // set primary
        $image->update(['is_primary' => true]);

        return back()->with('success','Gambar utama diperbarui');
    }

    public function destroy(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success','Gambar berhasil dihapus');
    }
}
