<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\LostPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 
use App\Models\User;

class AuthController extends Controller
{
    public function showLostPasswordForm()
    {
        return view('users.lost-password'); // Ensure this file exists
    }

    public function sendResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            Mail::to($user->email)->send(new LostPasswordMail($user->id));
            return back()->with('success', 'Password reset email sent successfully!');
        }

        return back()->with('error', 'No user found with this email address.');
    }

    public function showResetForm(Request $request)
    {
        return view('users.reset-password', ['user_id' => $request->query('user_id')]);
    }
    
    public function update(Request $request)
{
    // Get the user's email from the request
    $userEmail = $request->input('email');
    $userData = [];
    $plainTextPassword = $request->input('password');

    // Only update password if provided (not empty)
    if ($request->filled('password')) {
        // Hash the password for secure storage in the `users` table
        $userData['password'] = Hash::make($plainTextPassword);
    }

    // Only proceed if there's something to update
    if (count($userData) > 0) {
        try {
            // Update the password in the default `users` table based on email
            DB::table('users')->where('email', $userEmail)->update($userData);

            return redirect()->route('user')->with('success', 'Password updated successfully!');

        } catch (\Exception $e) {
            // Handle errors if the update fails
            return redirect()->back()->withErrors(['error' => 'Failed to update: ' . $e->getMessage()]);
        }
    } else {
        return redirect()->back()->withErrors(['No changes were made.']);
    }
}
}
