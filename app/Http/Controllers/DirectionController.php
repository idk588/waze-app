<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DirectionController extends Controller
{
    public function index()
    {
        return view('directions.index');
    }
}
