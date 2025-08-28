<?php

namespace App\Http\Controllers;

use App\Models\RedeemCode;
use App\Models\User;
use Illuminate\Http\Request;

class RedeemCodeController extends Controller
{
    public function save(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'redeem_codes' => 'required|string',
        ]);

        RedeemCode::create([
            'company_name' => $request->company_name,
            'redeem_codes' => $request->redeem_codes,
        ]);

        return back()->with('success', 'Redeem Codes successfully saved!');
    }

    public function index()
{
    $redeemCodes = RedeemCode::all();
    $userCodes = User::all();
    return view('admin.redeemcodes.index', compact('redeemCodes', 'userCodes'));
}

}
