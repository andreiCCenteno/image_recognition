<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreprocessingController extends Controller
{
    public function stage1()
    {
        return view('stage1');
    }

    public function stage2()
    {
        return view('stage2');
    }

    public function stage3()
    {
        return view('stage3');
    }

    public function stage4()
    {
        return view('stage4');
    }

    public function preprocessingquiz()
    {
        return view('preprocessingquiz');
    }

    // In your controller method
    public function getGameState(Request $request)
    {
        // Assuming you have an authenticated user
        $user = auth()->user();

        // Return the player's gender (you can adjust this based on your database structure)
        return response()->json([
            'playerGender' => $user->gender // Make sure 'gender' exists in your user model or modify as necessary
        ]);
    }

}
