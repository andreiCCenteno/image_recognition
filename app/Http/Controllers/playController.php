<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class playController extends Controller
{
    public function showPlayPage(Request $request)
{
    // Get the authenticated user
    $user = $request->user();

    if (!$user) {
        // Redirect to login page or return an error
        return redirect()->route('login')->with('error', 'You need to log in first.');
    }
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

    // Retrieve the notification statuses
    $medium_notif = $user->medium_notif ?? 0; // Default to 0 if not set
    $hard_notif = $user->hard_notif ?? 0; // Default to 0 if not set

    // Pass the tutorial status, difficulty completion, and notification statuses to the view
    return view('play', compact('tutorialShown', 'easy_finish', 'medium_finish', 'hard_finish', 'medium_notif', 'hard_notif'));
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

    public function completeEasyGame(Request $request)
{
    $user = auth()->user();

    // Unlock difficulty levels and set notifications
    $user->easy_finish = true;
    $user->medium_notif = 1; // Set to 1 when Easy game is completed
    $user->hard_notif = 0; // Initially set to 0 for Hard
    $user->save();

    return response()->json(['success' => true]);
}
    public function updateMediumNotif(Request $request) {
        // Validate the incoming request
        $request->validate([
            'medium_notif' => 'required|integer',
        ]);
    
        // Assuming you have a User model or a similar one to track user data
        $user = auth()->user(); // Get the currently authenticated user
    
        // Update the medium_notif field in the user's record
        $user->medium_notif = $request->medium_notif;
        $user->save();
    
        return response()->json(['success' => true]);
    }
    
    public function updateHardNotif(Request $request) {
        // Validate the incoming request
        $request->validate([
            'hard_notif' => 'required|integer',
        ]);
    
        // Assuming you have a User model or a similar one to track user data
        $user = auth()->user(); // Get the currently authenticated user
    
        // Update the hard_notif field in the user's record
        $user->hard_notif = $request->hard_notif;
        $user->save();
    
        return response()->json(['success' => true]);
    }

}
