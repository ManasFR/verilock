<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ValidLicense;
use Symfony\Component\HttpFoundation\StreamedResponse;


class DashboardController extends Controller
{
   public function index()
{
    // Count total products in the database
    $productCount = Product::count();
    $licenseShow = ValidLicense::all();

    // Get all months (Jan - Dec) with activation counts
    $licenseData = ValidLicense::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    // Format data for the chart
    $months = [
        "January", "February", "March", "April", "May", "June", 
        "July", "August", "September", "October", "November", "December"
    ];

    $licenseCounts = array_fill(0, 12, 0); // Initialize counts for all 12 months

    foreach ($licenseData as $data) {
        $licenseCounts[$data->month - 1] = $data->count; // Assign count to the correct month
    }

    return view('admin.dashboard', compact('productCount', 'licenseShow', 'months', 'licenseCounts'));
}

public function exportLicenses()
{
    $licenses = ValidLicense::all();

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=licenses.csv",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['id', 'user_email', 'user_license', 'product_id', 'domain', 'active', 'created_at', 'updated_at'];

    $callback = function() use ($licenses, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($licenses as $license) {
            fputcsv($file, [
                $license->id,
                $license->user_email,
                $license->user_license,
                $license->product_id,
                $license->domain,
                $license->active,
                $license->created_at,
                $license->updated_at,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

    public function userdash()
{
    $authUser = auth()->user();

    // Count total products associated with the logged-in user
    $productCount = Product::where('user_id', $authUser->id)->count();

    // Get licenses associated with the logged-in user
    $licenseShow = ValidLicense::where('user_id', $authUser->id)
    ->orderBy('created_at', 'desc')
    ->get();
    $productShow = Product::where('user_id', $authUser->id)
    ->orderBy('created_at', 'desc') // Order by newest first
    ->get();


    // Get all months (Jan - Dec) with activation counts
    $licenseData = ValidLicense::where('user_id', $authUser->id)
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    // Format data for chart
    $months = [
        "January", "February", "March", "April", "May", "June", 
        "July", "August", "September", "October", "November", "December"
    ];

    $licenseCounts = array_fill(0, 12, 0); // Initialize counts for all 12 months

    foreach ($licenseData as $data) {
        $licenseCounts[$data->month - 1] = $data->count; // Assign count to the correct month
    }

    return view('users.dashboard', compact('productCount','productShow', 'licenseShow', 'months', 'licenseCounts'));
}
public function exportUserLicenses()
{
    $authUser = auth()->user();
    $licenses = ValidLicense::where('user_id', $authUser->id)->get();

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=user_licenses.csv",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['id', 'user_email', 'user_license', 'product_id', 'domain', 'active', 'created_at', 'updated_at'];

    $callback = function() use ($licenses, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($licenses as $license) {
            fputcsv($file, [
                $license->id,
                $license->user_email,
                $license->user_license,
                $license->product_id,
                $license->domain,
                $license->active,
                $license->created_at,
                $license->updated_at,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
    
}
