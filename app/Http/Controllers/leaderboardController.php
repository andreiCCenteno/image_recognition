<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class leaderboardController extends Controller
{
    public function index()
{
    $currentUser = Auth::user(); // Get the currently authenticated user
    $current_user_id = $currentUser->id; // Get the current user's ID

    // Retrieve the top players sorted by score, excluding the user named 'admin'
    $topUsers = User::where('username', '!=', 'admin')
                    ->orderBy('score', 'desc')
                    ->take(5)
                    ->get();

    // Combine top users with the current user, avoiding duplicates
    $users = $topUsers->map(function ($user) {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'score' => $user->score,
            'easy_finish' => $user->easy_finish,
            'medium_finish' => $user->medium_finish,
            'hard_finish' => $user->hard_finish,
        ];
    })->toArray();

    // Add the current user to the list if they are not already included
    if ($currentUser) {
        $isCurrentUserInList = collect($users)->contains('id', $current_user_id);
        if (!$isCurrentUserInList) {
            $users[] = [
                'id' => $currentUser->id,
                'username' => $currentUser->username,
                'score' => $currentUser->score,
                'easy_finish' => $currentUser->easy_finish,
                'medium_finish' => $currentUser->medium_finish,
                'hard_finish' => $currentUser->hard_finish,
            ];
        }
    }

    return view('leaderboard', compact('users', 'current_user_id')); // Pass user ID to the view
}

}
