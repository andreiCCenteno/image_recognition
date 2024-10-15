<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HardController extends Controller
{
    public function hard()
    {
        return view('hard'); // Ensure you have a play.blade.php file in resources/views
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
}
