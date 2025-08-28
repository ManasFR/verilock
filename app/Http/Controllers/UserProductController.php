<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserProductController extends Controller
{
    public function userindex()
{
    $products = Product::where('user_id', auth()->id())->get();
    return view('users.product.index', compact('products'));
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
        'user_id' => auth()->id(), // Store the authenticated user's ID
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
