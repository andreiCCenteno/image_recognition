<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Ensure you have a User model
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.registration'); // This should point to resources/views/auth/registration.blade.php
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'userName' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted'
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->username = $request->userName;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful, please log in.');
    }
}
