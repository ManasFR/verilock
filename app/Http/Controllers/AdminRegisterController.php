<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminRegisterController extends Controller
{
    public function showLoginForm()
    {
        // Return the view for login (create login view if needed)
        return view('admin.login');
    }

    public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Get the first user in the database (assumed to be admin)
    $admin = User::orderBy('id')->first();

    // Check if the provided email matches the first user's email
    if ($admin && $request->email === $admin->email && Hash::check($request->password, $admin->password)) {
        Auth::login($admin);
        return redirect()->route('dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
}

    public function destroy(Request $request)
    {
        // Log out the authenticated user
        Auth::logout();

        // Invalidate the session to ensure the user cannot reuse their session ID
        $request->session()->invalidate();

        // Regenerate the CSRF token for security
        $request->session()->regenerateToken();

        // Redirect the user to the home page or any other page you choose
        return redirect('/');
    }
}
