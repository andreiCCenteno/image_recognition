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
    $request->validate([
        'score' => 'required|integer',
    ]);

    $user = User::find($userId);
    
    if ($user) {
        // Update the user's score
        $user->score += $request->score; // You may want to add to the score instead
        $user->save();

        return response()->json(['message' => 'Score updated successfully']);
    }

    return response()->json(['message' => 'User not found'], 404);
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


