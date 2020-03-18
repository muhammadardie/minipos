<?php

namespace App\Http\Controllers;

use Route;

class DashboardController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard');
    }
}
