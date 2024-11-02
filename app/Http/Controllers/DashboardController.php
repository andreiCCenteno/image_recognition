<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User; // Adjust if necessary
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // If there's no games relationship, just use the user's attributes
        $totalWins = $user->total_wins; // Assume this column exists in users table
        $successRate = $this->calculateSuccessRate($user);
        $score = $user->score;
        $easyPostTestPerformance = $this->getEasyPostTestPerformance($user);
        $mediumPostTestPerformance = $this->getMediumPostTestPerformance($user);
        $hardPostTestPerformance = $this->getHardPostTestPerformance($user);
        $ranking = $this->getUserRanking($user);

        return view('dashboard', compact('totalWins', 'successRate', 'score', 'easyPostTestPerformance','mediumPostTestPerformance','hardPostTestPerformance', 'ranking'));
    }

    private function calculateSuccessRate($user)
    {
        // Assuming there's a success rate attribute in the users table
        return $user->success_rate; // Adjust logic as necessary
    }

    private function getHighestScores($user)
    {
        // If you have a column for highest score in the users table
        return $user->highest_score; // Adjust logic as necessary
    }

    private function getEasyPostTestPerformance($user)
    {
        // If you have a column for post-test performance in the users table
        return $user->easy_post_test_performance; // Adjust logic as necessary
    }

    private function getMediumPostTestPerformance($user)
    {
        // If you have a column for post-test performance in the users table
        return $user->medium_post_test_performance; // Adjust logic as necessary
    }

    private function getHardPostTestPerformance($user)
    {
        // If you have a column for post-test performance in the users table
        return $user->hard_post_test_performance; // Adjust logic as necessary
    }

    private function getUserRanking($user)
    {
        // Assuming you have ranking information stored in the users table
        return $user->ranking; // Adjust logic as necessary
    }
}
