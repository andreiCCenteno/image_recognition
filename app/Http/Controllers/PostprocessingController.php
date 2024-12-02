<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostprocessingController extends Controller
{
    public function stage1()
    {
        return view('poststage1');
    }

    public function stage2()
    {
        return view('poststage2');
    }

    public function stage3()
    {
        return view('poststage3');
    }
}
