<?php

namespace App\Http\Controllers;

use App\Models\GameState;
use App\Models\User; // Make sure to import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EasyController extends Controller
{
    public function easy()
    {
        $userId = auth()->id(); // Get the logged-in user's ID
        $gameState = GameState::where('id', $userId)->first(); // Get the game state

        $gameStateData = $gameState ? json_decode($gameState->state, true) : []; // Decode JSON to array

        return view('easy', compact('gameStateData'));
    }

    public function updateGameState(Request $request)
    {
        $gameState = $request->input('gameState'); // Assume this is an array/object with game data
        session(['gameState' => $gameState]); // Store the game state in the session

        return response()->json(['success' => true]);
    }

    public function updateScore(Request $request, $userId)
{
    // Validate the request, including optional fields
    $request->validate([
        'score' => 'sometimes|required|integer',
        'easy_post_test_performance' => 'sometimes|required|numeric', // Changed to the new field name
        'increment_total_games_played' => 'sometimes|required|boolean', // New parameter to control total games played increment
    ]);

    $user = User::find($userId);

    if ($user) {
        // Increment total games played if the parameter is set to true
        if ($request->increment_total_games_played) {
            $user->total_games_played += 1;
        }

        // If 'score' is provided, update the total score
        if ($request->score) {
            $user->score += $request->score;
        }

        // If 'easy_post_test_performance' is provided, check for passing criteria
        if ($request->easy_post_test_performance !== null) {
            if ($request->easy_post_test_performance >= 80) {
                $user->total_wins += 1; // Increment total wins
            }
        
            // Update post-test performance with the latest score
            $user->easy_post_test_performance = $request->easy_post_test_performance;
        }

        // Calculate success rate as a percentage
        $user->success_rate = ($user->total_games_played > 0) 
            ? ($user->total_wins / $user->total_games_played) * 100 
            : 0;

        $user->save();

        return response()->json(['message' => 'Game stats updated successfully']);
    }

    return response()->json(['message' => 'User not found'], 404);
}

public function getCurrentPerformance($userId) {
    $user = User::find($userId);
    if ($user) {
        return response()->json([
            'post_test_performance' => $user->easy_post_test_performance // Return the new field name
        ]);
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
}

    public function saveGameState(Request $request)
    {
        $gameState = $request->input('gameState'); // Get the game state from the request
        $userId = auth()->id(); // Get the logged-in user's ID

        GameState::updateOrCreate(
            ['id' => $userId], // Find or create by user ID
            ['state' => json_encode($gameState)] // Store the state as JSON
        );

        return response()->json(['success' => true]);
    }

    public function updateEasyFinish(Request $request, $userId)
{
    $request->validate([
        'easy_finish' => 'required|boolean',
    ]);

    $user = User::find($userId);
    
    if ($user) {
        // Update the user's easy_finish status
        $user->easy_finish = $request->easy_finish; // Make sure this column exists in the users table
        $user->save();

        return response()->json(['message' => 'easy_finish updated successfully']);
    }

    return response()->json(['message' => 'User not found'], 404);
}


}


