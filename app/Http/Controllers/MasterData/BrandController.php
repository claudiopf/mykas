<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'Master Data - Brand';

        if ($request->ajax()) {
            $brands = Brand::select(['id', 'nama']);

            return DataTables::of($brands)
                ->addColumn('action', function ($brand) {
                    return '
                            <div class="text-center">
                                <button class="btn btn-sm btn-warning btnEditUser"
                                    data-id="'. $brand->id .'"
                                    data-name="'. $brand->nama .'">
                                    <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                                </button>
                                <a href="#" class="btn btn-sm btn-danger btnDeleteUser"
                                    data-id="'. $brand->id .'">
                                    <iconify-icon icon="solar:trash-bin-trash-bold" class="me-1"></iconify-icon>Delete
                                </a>
                            </div>
                        ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('brand.index', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Brand::create([
            'nama' => $request->nama,
        ]);

        return response()->json(['message' => 'Brand ditambahkan']);
    }
}
