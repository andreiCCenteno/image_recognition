<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function showPlayPage(Request $request)
    {
        // Assuming you have the authenticated user
        $user = $request->user();

        // Initialize the variable
        $tutorialShown = false;

        // Check if the tutorial has been shown before
        if ($user->is_tutorial == 0) {
            // Show the tutorial modal
            $tutorialShown = true;

            // Update the user's tutorial status to 1
            $user->is_tutorial = 1;
            $user->save();
        }

        return view('play', compact('tutorialShown'));
    }

    public function startTutorial(Request $request)
{
    $user = auth()->user(); // Assuming the user is authenticated
    $user->is_tutorial = 1; // Update the is_tutorial column
    $user->save(); // Save the change to the database

    return response()->json(['success' => true]);
}

    public function play(Request $request)
    {
        // Logic for starting the game can go here
        return view('game'); // Assuming you have a game view
    }
}