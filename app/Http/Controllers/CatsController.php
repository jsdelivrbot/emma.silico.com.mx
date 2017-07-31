<?php

namespace EMMA5\Http\Controllers;

use EMMA5\Cat;
use Illuminate\Http\Request;
use EMMA5\Http\Requests;
use Illuminate\Support\Facades\DB;

class CatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index()
    {
        //$cats = DB::table('cats')->get();
        //        $cats = Cat::all();
        $cats = Cat::paginate(2, ['*'], 'page');
        return view('cats.index', compact('cats'));
    }

    public function show(Cat $cat)
    {
        $cat->load('quotes.user')->paginate(3);
        return view('cats.show', compact('cat'));
    }
}
