<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ValidLicense;

class LicenseActivationController extends Controller
{
    public function userdash()
{
    $authUser = auth()->user();

    // Get licenses associated with the logged-in user
    $licenseShow = ValidLicense::where('user_id', $authUser->id)->get();

    return view('users.licenses.activations', compact('licenseShow'));
}
}
