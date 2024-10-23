<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class settingsController extends Controller
{
    public function settings()
    {
        return view('settings');
    }
    public function toggleSound(Request $request)
{
    $user = Auth::user();

    // Save the new volume levels from the request
    $user->music_volume = $request->input('music_volume');
    $user->sfx_volume = $request->input('sfx_volume');
    $user->save();

    return response()->json(['success' => true]);
}
}
