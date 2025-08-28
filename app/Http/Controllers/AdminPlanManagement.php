<?php

namespace App\Http\Controllers;
use App\Models\AdminPlan;
use Illuminate\Http\Request;

class AdminPlanManagement extends Controller
{
    public function index()
    {
        $plans = AdminPlan::all();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'license_code' => 'required',
        'product_limit' => 'required|integer',
        'license_limit' => 'required|integer',
        'price' => 'nullable|numeric',
        'limit' => 'boolean', // 👈 add validation for 0/1
    ]);

    AdminPlan::create([
        'name' => $request->name,
        'license_code' => $request->license_code,
        'product_limit' => $request->product_limit,
        'license_limit' => $request->license_limit,
        'price' => $request->price,
        'limit' => $request->limit ?? 0, // 👈 default 0 if unchecked
    ]);

    return redirect()->route('admin.plans')
                     ->with('success', 'Plan created successfully.');
}

}
