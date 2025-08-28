<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|unique:products',
            'product_name' => 'required',
        ]);

        Product::create([
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product-show')->with('success', 'Product deleted successfully!');
    }
}
