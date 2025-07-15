<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Retail;

class RetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Master Data - Retail';

        $retails = Retail::all();

        return view('retail.index', compact('title', 'retails'));
    }
}
