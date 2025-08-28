<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\License;

class LicenseController extends Controller
{

    public function index()
    {
        $licenses = License::all(); // Fetch all licenses
        return view('admin.licenses.index', compact('licenses'));
    }
    
    public function showForm()
    {
        $products = Product::all();
        return view('admin.licenses.create', compact('products'));
    }

    public function generateLicenses(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::find($request->product_id);

    $licenses = [];
for ($i = 1; $i <= $request->quantity; $i++) {
    $randomPrefix = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, rand(3, 6))); // Random 3-6 letter prefix
    $licenses[] = "{$randomPrefix}{$i}-" . strtoupper(uniqid());
}

    return response()->json([
        'success' => true,
        'licenses' => $licenses,
        'product_id' => $product->id,
        'product_name' => $product->product_name,
    ]);
}

public function saveLicenses(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'product_name' => 'required|string',
        'license_codes' => 'required|string',
        'license_use_limit' => 'nullable|integer|min:1',
        'license_expiration_date' => 'nullable|date',
    ]);

    License::create([
        'product_id' => $request->product_id,
        'product_name' => $request->product_name,
        'license_codes' => $request->license_codes,
        'license_use_limit' => $request->license_use_limit ?? -1, // Store -1 if empty
        'license_expiration_date' => $request->license_expiration_date ?? null, // Store NULL if empty
    ]);

    return redirect()->back()->with('success', 'Licenses saved successfully!');
}

public function edit($id)
{
    $license = License::findOrFail($id);
    $products = Product::all(); // Fetch products for dropdown
    return view('admin.licenses.edit', compact('license', 'products'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'product_name' => 'required|string',
        'license_codes' => 'required|string',
        'license_use_limit' => 'nullable|integer|min:1',
        'license_expiration_date' => 'nullable|date',
    ]);

    $license = License::findOrFail($id);
    $license->update([
        'product_id' => $request->product_id,
        'product_name' => $request->product_name,
        'license_codes' => $request->license_codes,
        'license_use_limit' => $request->license_use_limit ?? -1, // If empty, set to -1
        'license_expiration_date' => $request->license_expiration_date ?? null, // Allow null
    ]);

    return redirect()->route('licenses.index')->with('success', 'License updated successfully!');
}

    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $license->delete();

        return redirect()->route('licenses.index')->with('success', 'License deleted successfully!');
    }
}
