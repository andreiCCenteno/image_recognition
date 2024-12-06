<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
