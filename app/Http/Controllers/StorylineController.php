<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorylineController extends Controller
{
    public function storylinestage1()
    {
        return view('storyline1');
    }

    public function storylinestage2()
    {
        return view('storyline2');
    }

    public function storylinestage3()
    {
        return view('storyline3');
    }

    public function storylinestage4()
    {
        return view('storyline4');
    }

    public function updateGender(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'gender' => 'required|in:male,female',
        ]);

        // Update the player's gender in the database
        $user = Auth::user(); // Get the authenticated user
        $user->gender = $request->gender; // Assume 'gender' column exists in the users table
        $user->save();

        return response()->json(['success' => true, 'message' => 'Gender updated successfully!']);
    }

    public function savePlayerName(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->player_name = $request->input('player_name');
        $user->save();

        return response()->json(['message' => 'Player name saved successfully!']);
    }

    public function isPlayerNameExist()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 200,
            'isPlayerNameExist' => empty($user->player_name)
        ]);
    }

    public function isPlayerGenderExist()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 200,
            'isPlayerGenderExist' => empty($user->gender)
        ]);
    }
}
