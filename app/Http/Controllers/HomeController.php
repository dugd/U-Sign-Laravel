<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function custom(Request $request)
    {
        $welcome_text = $request->route('welcome');
        return view('home', ['welcome' => $welcome_text]);
    }
}
