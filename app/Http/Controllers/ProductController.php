<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // List
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Show create form
    public function create()
    {
        return view('products.create');
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'price' => 'nullable|numeric'
        ]);
        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Product Added');
    }

    // Show edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'price' => 'nullable|numeric'
        ]);
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product Added');
    }

    // Delete
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('products.index')->with('success', 'Product Added');
    }
}