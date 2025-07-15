<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Area;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Master Data - Area';

        $areas = Area::all();

        return view('area.index', compact('title', 'areas'));
    }
}
