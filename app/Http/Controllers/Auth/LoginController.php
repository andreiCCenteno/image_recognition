<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Add this for database queries
use Illuminate\Support\Facades\Auth; // For authentication
use Illuminate\Support\Facades\Hash; // For password hashing
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // Import Log facade for logging

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // This will point to your login view
    }

    public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string', // Change 'pass' to 'password'
    ]);

    // Fetch user data from database
    $user = DB::table('users')->where('username', $request->username)->first();

    if (!$user) {
        // If user not found, log it and throw a validation error
        \Log::debug('User not found:', ['username' => $request->username]);
        throw ValidationException::withMessages([
            'username' => ['User not found!'],
        ]);
    }

    if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        // User is authenticated
        return redirect('mainmenu')->with(['message' => 'WELCOME USER! Redirecting to the main menu...', 'user_id' => $user->id]);
    }

    // If password does not match
    \Log::debug('Incorrect password attempt:', ['username' => $request->username]);
    throw ValidationException::withMessages([
        'username' => ['Incorrect username or password!'],
    ]);
}
public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
