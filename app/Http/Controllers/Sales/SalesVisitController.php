<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Retail;
use App\Models\SalesVisit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
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
        $retails = Retail::all();
        $sales = User::where('role', 'sales')->get();

        if ($request->ajax()) {
            $salesVisits = SalesVisit::with('user','retail')->get();

            return DataTables::of($salesVisits)
                ->addIndexColumn()
                ->addColumn('nama', function ($salesVisit) {
                    return '<span class="text-nowrap"> ' . $salesVisit->user->name . '</span>';
                })
                ->addColumn('tanggal', function ($salesVisit) {
                    return '<span class="text-nowrap">' . Carbon::parse($salesVisit->tgl_visit)->format('d-m-Y H:i:s') . '</span>';
                })
                ->addColumn('catatan', function ($salesVisit) {
                    return $salesVisit->catatan ?? 'Belum ada data';
                })
                ->addColumn('retail', function ($salesVisit) {
                    return '<span class="text-nowrap">' . $salesVisit->retail->nama ?? 'Belum ada data';
                })
                ->addColumn('image', function ($salesVisit) {
                    if ($salesVisit->image != null) {
                        $imageUrl = asset($salesVisit->image);
                        return '<img class="img-fluid rounded" src="' . $imageUrl . '" alt="Gambar Kategori" width="100" height="100" />';
                    }
                    return '<span class="text-capitalize">Belum ada gambar</span>';
                })
                ->rawColumns(['nama','image','tanggal','retail'])
                ->make(true);
        }
        return view('sales.sales_visit.index', compact('title','retails', 'sales'));
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'retail_id'  => 'required|exists:retails,id',
            'catatan'    => 'nullable|string',
            'visit_by'   => 'required|string',
            'image'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (auth()->user()->role === 'sales'){
            $tglVisit = now('Asia/Jakarta')->format('Y-m-d H:i:s');
            $validData['tgl_visit'] = $tglVisit;
        } else {
            $validData['tgl_visit'] = $request->tgl_visit;
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());

            $imgPath = public_path('bukti_kunjungan');
            if (!is_dir($imgPath)) {
                mkdir($imgPath, 0755, true);
            }

            $image->move($imgPath, $imageName);
            $validData['image'] = 'bukti_kunjungan/' . $imageName;
        }


        SalesVisit::create($validData);

        return response()->json([
            'status' => true,
            'message' => 'Data kunjungan berhasil disimpan!'
        ]);
    }

}
