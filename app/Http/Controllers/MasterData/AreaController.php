<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'Master Data - Area';

        if ($request->ajax()) {
            $areas = Area::all();

            return DataTables::of($areas)
                ->addIndexColumn()
                ->editColumn('nama', function ($area) {
                    if ($area->nama == 'tr') {
                        return '<span class="text-uppercase">'. e($area->nama) .'</span>';
                    } else {
                        return '<span class="text-capitalize">'. e($area->nama) .'</span>';
                    }
                })
                ->addColumn('action', function ($area) {
                    return '
                            <div class="text-center">
                                <button class="btn btn-sm btn-warning btnEditArea"
                                    data-id="'. $area->id .'"
                                    data-nama="'. $area->nama .'"
                                    data-kode_area="'. $area->kode_area .'">
                                    <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                                </button>
                                <a href="#" class="btn btn-sm btn-danger btnDeleteArea"
                                    data-id="'. $area->id .'">
                                    <iconify-icon icon="solar:trash-bin-trash-bold" class="me-1"></iconify-icon>Delete
                                </a>
                            </div>
                        ';
                })
                ->rawColumns(['action','nama'])
                ->make(true);
        }

        return view('area.index', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode_area' => 'required|string|max:255',
        ]);

        Area::create([
            'nama' => $request->nama,
            'kode_area' => $request->kode_area,
        ]);

        return response()->json(['message' => 'Area ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $area = Area::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kode_area' => 'required|string|max:255',
        ]);

        $data = [
            'nama' => $request->nama,
            'kode_area' => $request->kode_area,
        ];

        $area->update($data);

        return response()->json(['message' => 'Area berhasil diupdate']);
    }

    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        $area->delete();

        return response()->json(['message' => 'Area berhasil dihapus']);
    }
}
