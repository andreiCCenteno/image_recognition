<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line

class mainmenuController extends Controller // Updated to PascalCase
{
    public function mainmenu()
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user(); // Get the authenticated user
            if ($user->is_admin) {
                // User is an admin, you can add further logic if needed
                // dd($user->is_admin); // Uncomment if you need to debug
            }
        } else {
            // User is not logged in
            return redirect('/login'); // Redirect to login if not authenticated
        }

        return view('mainmenu'); // Ensure you have a mainmenu.blade.php file in resources/views
    }
}
