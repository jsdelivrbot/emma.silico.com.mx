<?php

namespace EMMA5\Http\Controllers;

use Illuminate\Http\Request;

use EMMA5\Http\Requests;

class PagesController extends Controller
{
    public function home()
    {
        $cats = ['Panza', 'Jero', 'Kuru', 'Juana'];
        return view('welcome', compact('cats'));
    }
}
