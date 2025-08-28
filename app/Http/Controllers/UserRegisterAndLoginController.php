<?php

namespace App\Http\Controllers;

use App\Models\RedeemCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserRegisterAndLoginController extends Controller
{
    // Show the login and register form
    public function showForm()
    {
        return view('users.login');
    }

    // Handle the registration logic
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'redeem_code' => 'required|string',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Check redeem code
    $redeemCode = RedeemCode::where('redeem_codes', 'like', '%' . $request->redeem_code . '%')->first();

    if (!$redeemCode) {
        return back()->with('error', 'Invalid Redeem Code');
    }


    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'redeem_code' => $request->redeem_code,
    ]);

    // Log the user in
    Auth::login($user);

    return redirect()->route('userdashboard')->with('success', 'Registration successful!');
}


    // Handle the login logic
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('userdashboard')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid login credentials');
    }

    public function destroy(Request $request)
{
    // Log the user out
    Auth::logout();

    // Invalidate the session
    $request->session()->invalidate();

    // Regenerate the session token to prevent session fixation attacks
    $request->session()->regenerateToken();

    // Redirect to the login page or wherever you want after logout
    return redirect()->route('user')->with('success', 'You have successfully logged out.');
}

}
