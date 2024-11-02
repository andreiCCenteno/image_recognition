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
    // Validate the request, including optional fields
    $request->validate([
        'score' => 'sometimes|required|integer',
        'medium_post_test_performance' => 'sometimes|required|numeric', // Expecting percentage value
        'increment_total_games_played' => 'sometimes|required|boolean', // New parameter to control total games played increment
    ]);

    // Find the user by ID
    $user = User::find($userId);

    if ($user) {
        // Increment total games played if the parameter is set to true
        if ($request->increment_total_games_played) {
            $user->total_games_played += 1;
        }

        // If 'score' is provided, update the total score
        if ($request->score !== null) {
            $user->score += $request->score;
        }

        // Check if 'medium_post_test_performance' is provided and update
        if ($request->medium_post_test_performance !== null) {
            // Update post-test performance with the latest score
            $user->medium_post_test_performance = $request->medium_post_test_performance;

            // Increment total wins if performance meets criteria
            if ($request->medium_post_test_performance >= 80) {
                $user->total_wins += 1; // Increment total wins
            }
        }

        // Calculate success rate as a percentage
        $user->success_rate = ($user->total_games_played > 0) 
            ? ($user->total_wins / $user->total_games_played) * 100 
            : 0;

        // Save updated user data
        $user->save();

        return response()->json(['message' => 'Game stats updated successfully']);
    }

    return response()->json(['message' => 'User not found'], 404);
}

public function getCurrentPerformance($userId)
{
    // Find the user by ID
    $user = User::find($userId);

    if ($user) {
        return response()->json([
            'medium_post_test_performance' => $user->medium_post_test_performance // Ensure this matches what you save
        ]);
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
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
