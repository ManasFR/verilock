<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\License;
use App\Models\ValidLicense;
use Illuminate\Http\Request;

class ValidateLicenseController extends Controller
{
    public function showForm(Request $request)
{
    // Extract the main domain from the current URL
    $currentDomain = $_SERVER['HTTP_HOST'];

    // Fetch licenses for the domain from the valid_licenses table
    $validLicenses = ValidLicense::where('domain', $currentDomain)->get();

    return view('admin.valid_license', compact('validLicenses', 'currentDomain'));
}
public function validateLicense(Request $request)
{
    // Validate the input
    $request->validate([
        'user_email' => 'required|email',
        'product_name' => 'required|string',
        'user_license' => 'required|string',
        'domain' => 'required|string',
    ]);

    // Fetch product by product name
    $product = Product::where('product_name', $request->product_name)->first();

    if (!$product) {
        return response()->json([
            'status' => 'error',
            'message' => 'Product not found.'
        ]);
    }

    // Check if the license code exists for this product
    $license = License::where('product_id', $product->id)
                      ->where('license_codes', 'like', "%{$request->user_license}%")
                      ->first();

    if (!$license) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid license code for this product.'
        ]);
    }

    // Check license expiration
    if ($license->license_expiration_date && $license->license_expiration_date < now()) {
        return response()->json([
            'status' => 'error',
            'message' => 'This license code has expired.'
        ]);
    }

    // Check license use limit, excluding inactive licenses
        $licenseUsageCount = ValidLicense::where('user_license', $request->user_license)
            ->where('product_id', $product->id)
            ->where('active', 1)
            ->count();

        // If license_use_limit is not -1, check the usage limit
        if ($license->license_use_limit != -1 && $licenseUsageCount >= $license->license_use_limit) {
            return response()->json([
                'status' => 'error',
                'message' => 'This license code usage limit is over.'
            ]);
        }

    // Check if the license code is already active and in use by another user
    $existingLicense = ValidLicense::where('user_license', $request->user_license)
                                   ->where('active', 1) // Ensure it is active
                                   ->first();

    if ($existingLicense) {
        if ($license->license_use_limit == 1) {
            if ($existingLicense->user_email === $request->user_email) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You already use this license code. Please deactivate it to use again.'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'This license code is used by another user.'
            ]);
        }
    }

    // Check if the license is already activated for the same email but inactive
    $existingEmailLicense = ValidLicense::where('user_email', $request->user_email)
                                        ->where('user_license', $request->user_license)
                                        ->where('active', 0) // Ensure it is inactive
                                        ->first();

    if ($existingEmailLicense) {
        $existingEmailLicense->update([
            'active' => 1, // Reactivate the license
            'domain' => $request->domain, // Assign the new domain to the license
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Your license has been reactivated successfully!'
        ]);
    }

    // If no existing record, create a new license activation
    ValidLicense::create([
        'user_email' => $request->user_email,
        'user_license' => $request->user_license,
        'domain' => $request->domain,
        'product_id' => $product->id, // Store the product_id here
        'user_id' => $license->user_id, // Store the user_id from the licenses table
        'active' => 1, // License is activated
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Your license has been activated successfully!'
    ]);
}


public function deactivate(Request $request)
{
    $license = ValidLicense::find($request->license_id);

    if ($license && $license->active) {
        $license->update(['active' => 0]);
        return redirect()->back()->with('success', 'License deactivated successfully.');
    }

    return redirect()->back()->with('error', 'Failed to deactivate the license.');
}

public function activate(Request $request)
{
    $license = ValidLicense::find($request->license_id);

    if ($license && !$license->active) {  // Check if license is inactive
        $license->update(['active' => 1]);
        return redirect()->back()->with('success', 'License activated successfully.');
    }

    return redirect()->back()->with('success', 'Failed to activate the license or it is already active.');
}


public function getLicenseForm()
{
    // Return the form view
    return view('admin.valid_license');
}

}
