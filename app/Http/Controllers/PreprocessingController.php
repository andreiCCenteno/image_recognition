<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function preprocessingquiz()
    {
        return view('preprocessingquiz');
    }
}
