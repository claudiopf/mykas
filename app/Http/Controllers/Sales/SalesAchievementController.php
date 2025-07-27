<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalesAchievementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'Pencapaian Sales';

        if ($request->ajax()) {
            $salesAchievements = User::all()
            ->where('role', 'sales');

            return DataTables::of($salesAchievements)
                ->addIndexColumn()
                ->addColumn('capaian', function ($salesAchieve) {
                    return 'Belum ada data';
                })
                ->addColumn('jmlToko', function ($salesAchieve) {
                    return 'Belum ada data';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sales_achievement.index', compact('title'));
    }
}
