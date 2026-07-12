<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $picture = null;
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'picture' => $picture,
        ]);

        return redirect()->route('categories')
            ->with('success', 'Category berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:100',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        if ($request->hasFile('picture')) {

            if ($category->picture) {
                Storage::disk('public')->delete($category->picture);
            }

            $data['picture'] = $request->file('picture')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories')
            ->with('success', 'Category berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        if ($category->picture) {
            Storage::disk('public')->delete($category->picture);
        }

        $category->delete();
        return back()->with('success', 'Category berhasil dihapus');
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->firstOrFail();

        $products = $category->products()
            ->with('primaryImage')
            ->where('is_active', 1)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
