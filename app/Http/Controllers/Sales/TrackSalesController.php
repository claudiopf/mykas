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
        $title = 'Track Sales';

        return view('sales.track_sales.index', compact('title'));
    }
}
