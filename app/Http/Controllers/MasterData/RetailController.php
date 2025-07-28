<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\AreaRetail;
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
        $areas = Area::all();

        if ($request->ajax()) {
            $retails = Retail::with('areas')->get();

            return DataTables::of($retails)
                ->addIndexColumn()
                ->addColumn('kode_area', function ($retail) {
                    if ($retail->areas->isEmpty()) {
                        return 'Area belum ditentukan';
                    }
                    return $retail->areas->pluck('kode_area')->implode(',');
                })
                ->addColumn('action', function ($retail) {
                    $areaIds = $retail->areas->pluck('id')->implode(',');

                    return '
                            <div class="text-center">
                                <button class="btn btn-sm btn-warning btnEditRetail"
                                    data-id="'. e($retail->id) .'"
                                    data-nama="'. e($retail->nama) .'"
                                    data-kode_bp = "'. e($retail->kode_bp) .'"
                                    data-kecamatan = "'. e($retail->kecamatan) .'"
                                    data-area = "'. e($areaIds) .'">
                                    <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                                </button>
                                <a href="#" class="btn btn-sm btn-danger btnDeleteRetail"
                                    data-id="'. $retail->id .'">
                                    <iconify-icon icon="solar:trash-bin-trash-bold" class="me-1"></iconify-icon>Delete
                                </a>
                            </div>
                        ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('retail.index', compact('title', 'areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode_bp' => 'required|unique:retails,kode_bp',
            'kecamatan' => 'required',
            'area_id' => 'required|array',
            'area_id.*' => 'required|exists:areas,id',
        ]);

        $retail = Retail::create([
            'nama' => $request->nama,
            'kode_bp' => $request->kode_bp,
            'kecamatan' => $request->kecamatan,
        ]);

        $retail->areas()->attach($request->area_id);

        return response()->json([
            'status' => true,
            'message' => 'Toko berhasil ditambahkan'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kode_bp' => 'required|unique:retails,kode_bp,' . $id,
            'kecamatan' => 'required',
            'area_id' => 'required|array',
            'area_id.*' => 'required|exists:areas,id',
        ]);

        $retail = Retail::findOrFail($id);

        $retail->update([
            'nama' => $request->nama,
            'kode_bp' => $request->kode_bp,
            'kecamatan' => $request->kecamatan,
        ]);

        $retail->areas()->sync($request->area_id);

        return response()->json([
            'status' => true,
            'message' => 'Toko berhasil diperbaharui'
        ]);
    }

    public function destroy($id)
    {
        $retail = Retail::findOrFail($id);

        $retail->areas()->detach();

        $retail->delete();

        return response()->json([
            'status' => true,
            'message' => 'Toko berhasil dihapus'
        ]);
    }
}
