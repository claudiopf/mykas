<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Retail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RetailAchievementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'Pencapaian Toko';

        if ($request->ajax()) {
            $retailAchievements = Retail::all()
                ->where('role', 'sales');

            return DataTables::of($retailAchievements)
                ->addIndexColumn()
                ->addColumn('capaian', function ($retailAchieve) {
                    return 'Belum ada data';
                })
                ->addColumn('jmlToko', function ($retailAchieve) {
                    return 'Belum ada data';
                })
                ->make(true);
        }

        return view('sales.retail_achievement.index', compact('title'));
    }
}
