<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function showPlayPage(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Initialize the variable to check if the tutorial is shown
        $tutorialShown = false;

        // Check if the tutorial has been shown before
        if ($user->is_tutorial == 0) {
            // Show the tutorial modal
            $tutorialShown = true;

            // Update the user's tutorial status to 1
            $user->is_tutorial = 1;
            $user->save();
        }

        // Retrieve the game completion status for difficulty levels
        $easy_finish = $user->easy_finish;
        $medium_finish = $user->medium_finish;
        $hard_finish = $user->hard_finish;

        // Pass the tutorial status and difficulty completion to the view
        return view('play', compact('tutorialShown', 'easy_finish', 'medium_finish', 'hard_finish'));
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
