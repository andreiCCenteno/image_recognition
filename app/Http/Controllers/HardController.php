<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HardController extends Controller
{
    public function hard()
    {
        return view('hard'); // Ensure you have a play.blade.php file in resources/views
    }

    public function updateScore(Request $request, $userId)
{
    // Validate the request, including optional fields
    $request->validate([
        'score' => 'sometimes|required|integer',
        'hard_post_test_performance' => 'sometimes|required|numeric', // Expecting percentage value
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
        if ($request->hard_post_test_performance !== null) {
            // Update post-test performance with the latest score
            $user->hard_post_test_performance = $request->hard_post_test_performance;

            // Increment total wins if performance meets criteria
            if ($request->hard_post_test_performance >= 80) {
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
            'hard_post_test_performance' => $user->hard_post_test_performance // Ensure this matches what you save
        ]);
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
}
public function updateHardFinish(Request $request, $userId)
    {
        // Validate the incoming request
        $request->validate([
            'hard_finish' => 'required|boolean',
        ]);

        // Find the user by ID
        $user = User::find($userId);

        if ($user) {
            // Update the medium_finish column
            $user->hard_finish = $request->hard_finish; // Ensure this column exists in the users table
            $user->save();

            return response()->json(['message' => 'hard_finish updated successfully']);
        }

        // Return an error if the user is not found
        return response()->json(['message' => 'User not found'], 404);
    }
public function displayCertificate()
{
    $user = Auth::user(); // Get the authenticated user

    $fullName = $user->firstname . ' ' . ($user->middlename ? $user->middlename . ' ' : '') . $user->lastname;

    return response()->json([
        'name' => $fullName,
        'score' => $user->score, // Assuming you store the score in the users table
        'date' => now()->toDateString(),
    ]);
}
}
