<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

class TrackSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('track_sales.index');
    }
}
