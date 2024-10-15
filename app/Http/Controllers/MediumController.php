<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model

class MediumController extends Controller
{
    // Show the medium view
    public function medium()
    {
        return view('medium'); // Ensure you have a medium.blade.php file in resources/views
    }

    // Update the user's score
    public function updateScore(Request $request, $userId)
    {
        // Validate the incoming request
        $request->validate([
            'score' => 'required|integer',
        ]);

        // Find the user by ID
        $user = User::find($userId);

        if ($user) {
            // Add to the user's current score
            $user->score += $request->score; 
            $user->save();

            return response()->json(['message' => 'Score updated successfully']);
        }

        // Return an error if the user is not found
        return response()->json(['message' => 'User not found'], 404);
    }

    // Update the user's medium_finish status
    public function updateMediumFinish(Request $request, $userId)
    {
        // Validate the incoming request
        $request->validate([
            'medium_finish' => 'required|boolean',
        ]);

        // Find the user by ID
        $user = User::find($userId);

        if ($user) {
            // Update the medium_finish column
            $user->medium_finish = $request->medium_finish; // Ensure this column exists in the users table
            $user->save();

            return response()->json(['message' => 'medium_finish updated successfully']);
        }

        // Return an error if the user is not found
        return response()->json(['message' => 'User not found'], 404);
    }
}
