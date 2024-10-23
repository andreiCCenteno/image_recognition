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
        // Validate the input fields
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255', // Optional field
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'userName' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted'
        ]);

        // Create a new user and save the validated data
        $user = new User();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename; // Can be null
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->username = $request->userName;
        $user->password = Hash::make($request->password); // Hash the password before saving
        $user->save();

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'Registration successful, please log in.');
    }
}
