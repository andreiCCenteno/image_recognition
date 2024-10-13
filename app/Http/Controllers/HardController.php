<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HardController extends Controller
{
    public function hard()
    {
        return view('hard'); // Ensure you have a play.blade.php file in resources/views
    }

    public function submitScore(Request $request)
    {
        $userId = $request->input('user_id');
        $score = $request->input('score');

        // Update the score in the database for the current user
        DB::table('users')
            ->where('id', $userId)
            ->update(['score' => $score]);

        return response()->json(['success' => true]);
    }
}
