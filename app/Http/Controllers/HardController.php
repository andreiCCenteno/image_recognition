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
