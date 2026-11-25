<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products   = auth()->user()->products()
            ->with('category')
            ->latest()
            ->paginate(20);

        $categories = auth()->user()->categories()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = auth()->user()->categories()->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'is_active'   => 'required|in:0,1',
        ]);

        // Verify category belongs to this user (prevent IDOR)
        $category = auth()->user()->categories()->findOrFail($validated['category_id']);

        auth()->user()->products()->create([
            'name'        => $validated['name'],
            'category_id' => $category->id,
            'price'       => $validated['price'],
            'description' => $validated['description'] ?? null,
            'is_active'   => (bool) $validated['is_active'],
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = auth()->user()->categories()->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'is_active'   => 'required|in:0,1',
        ]);

        // Verify category belongs to this user (prevent IDOR)
        $category = auth()->user()->categories()->findOrFail($validated['category_id']);

        $product->update([
            'name'        => $validated['name'],
            'category_id' => $category->id,
            'price'       => $validated['price'],
            'description' => $validated['description'] ?? null,
            'is_active'   => (bool) $validated['is_active'],
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
