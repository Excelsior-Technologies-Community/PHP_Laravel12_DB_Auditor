<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Product List + Search + Pagination
    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%");
        })
        ->oldest()
        ->paginate(5);

        return view('products.index', compact('products'));
    }

    // Create Form
    public function create()
    {
        return view('products.create');
    }

    // Store Product
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'price' => 'nullable|numeric'
        ]);

        Product::create($request->all());

        return redirect()
            ->route('products.index')
            ->with('success', 'Product Added Successfully');
    }

    // Edit Form
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    // Update Product
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'price' => 'nullable|numeric'
        ]);

        $product = Product::findOrFail($id);

        $product->update($request->all());

        return redirect()
            ->route('products.index')
            ->with('success', 'Product Updated Successfully');
    }

    // Soft Delete
    public function destroy($id)
    {
        Product::destroy($id);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product Deleted Successfully');
    }

    // Trash List
    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(5);

        return view('products.trash', compact('products'));
    }

    // Restore Product
    public function restore($id)
    {
        Product::onlyTrashed()->where('p_id', $id)->restore();

        return redirect()
            ->route('products.trash')
            ->with('success', 'Product Restored Successfully');
    }
}