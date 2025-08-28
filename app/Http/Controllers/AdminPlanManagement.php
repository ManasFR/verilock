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
        ]);

        AdminPlan::create($request->all());

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully.');
    }
}
