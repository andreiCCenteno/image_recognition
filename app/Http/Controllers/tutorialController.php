<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class tutorialController extends Controller
{
    // This returns the tutorial view
    public function tutorial()
    {
        return view('tutorial'); // This references the tutorial.blade.php view
    }
}
