<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\SalesVisit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalesVisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'Kunjungan Sales';

        if ($request->ajax()) {
            $salesVisits = SalesVisit::all();

            return DataTables::of($salesVisits)
                ->addIndexColumn()
                ->addColumn('nama', function ($salesVisit) {
                    return $salesVisit->nama ?? 'Belum ada data';
                })
                ->addColumn('tanggal', function ($salesVisit) {
                    return $salesVisit->tanggal ?? 'Belum ada data';
                })
                ->addColumn('retail', function ($salesVisit) {
                    return $salesVisit->retail ?? 'Belum ada data';
                })
                ->make(true);
        }
        return view('sales_visit.index', compact('title'));
    }
}
