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
}
