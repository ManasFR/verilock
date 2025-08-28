<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    public function redeemindex()
    {
        $Redeemuser = User::all();
        return view('admin.usermanage.index', compact('Redeemuser'));
    }

    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    // Create the user
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'roles' => 'customer',
    ]);

    return redirect()->route('dashboard')->with('success', 'User registration successful!');
}

public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.management')->with('success', 'User deleted successfully!');
    }

    public function editUser($id)
{
    $user = User::findOrFail($id);  // Fetch the user by ID
    return view('admin.usermanage.edit', compact('user'));
}



public function updateUser(Request $request, $id)
{
    $request->validate([
        'email' => 'required|email|unique:users,email,' . $id, // Ensuring no duplicate email
        'password' => 'nullable|string|min:6', // If a password is provided, validate it
    ]);

    $user = User::findOrFail($id);
    
    // Update the email and password (only if password is provided)
    $user->email = $request->email;
    
    if ($request->password) {
        $user->password = bcrypt($request->password); // Hash the new password
    }

    $user->save();

    return redirect()->route('user.management')->with('success', 'User updated successfully!');
}

}