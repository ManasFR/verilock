<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Illuminate\Support\Facades\Hash;

class ProfileUpdateController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Pass the user details to the view
        return view('users.user-update.profile', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function update(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Update name and email
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if provided
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password); // Hash the new password
        }

        // Save the user
        $user->save();

        // Redirect back with a success message
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
