<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Retail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'Master Data - Retail';

        if ($request->ajax()) {
            $retails = Retail::all();

            return DataTables::of($retails)
                ->addIndexColumn()
                ->addColumn('sales', function ($retail) {
                    return 'Verstappen';
                })
                ->addColumn('kode_area', function ($retail) {
                    return 'TR01';
                })
                ->addColumn('action', function ($retail) {
                    return '
                            <div class="text-center">
                                <button class="btn btn-sm btn-warning btnEditBrand"
                                    data-id="'. $retail->id .'"
                                    data-nama="'. $retail->nama .'">
                                    <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                                </button>
                                <a href="#" class="btn btn-sm btn-danger btnDeleteBrand"
                                    data-id="'. $retail->id .'">
                                    <iconify-icon icon="solar:trash-bin-trash-bold" class="me-1"></iconify-icon>Delete
                                </a>
                            </div>
                        ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('retail.index', compact('title'));
    }
}
