<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class leaderboardController extends Controller
{
    public function index()
{
    $current_user = session('username'); // Get the current user's username from the session

    // Retrieve the top players sorted by score, excluding the user named 'admin'
    $topUsers = User::where('username', '!=', 'admin')
                    ->orderBy('score', 'desc')
                    ->take(5)
                    ->get();

    $currentUser = User::where('username', $current_user)->first();

    // Combine top users with the current user, avoiding duplicates
    $users = $topUsers->map(function ($user) {
        return [
            'username' => $user->username,
            'score' => $user->score,
        ];
    })->toArray();

    if ($currentUser) {
        // Add current user to the list if not already included
        $users[$currentUser->username] = [
            'username' => $currentUser->username,
            'score' => $currentUser->score,
        ];
    }

    return view('leaderboard', compact('users', 'current_user'));
}

}
