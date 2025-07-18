<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'Master Data - Product';
        $brands = Brand::all();

        if ($request->ajax()) {
            $products = Product::select(['id', 'no_idem', 'brand_id', 'nama' ,'harga', 'deskripsi', 'status_aktif'])
                ->with('brand')
                ->get();

            return DataTables::of($products)
                ->addColumn('brand', function ($product) {
                    return $product->brand->nama ?? '-';
                })
                ->editColumn('harga', function ($product) {
                    $regexHarga = preg_replace('/[^0-9]/', '', $product->harga);

                    return 'Rp ' . number_format((int) $regexHarga, 0, ',', '.');
                })
                ->addColumn('status', function ($product) {
                    if ($product->status_aktif == 'aktif') {
                        return '<span class="badge bg-success">Aktif</span>';
                    } else {
                        return '<span class="badge bg-danger">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function ($product) {
                    return '
                <div class="text-center">
                    <button class="btn btn-sm btn-warning btnEditProduct"
                        data-id="'. $product->id .'"
                        data-no_idem="'. $product->no_idem .'"
                        data-nama="'. $product->nama .'"
                        data-harga="'. number_format((int) $product->harga, 0, ',', '.') .'"
                        data-deskripsi="'. $product->deskripsi .'"
                        data-brand_id="'. $product->brand_id .'"
                        data-status_aktif="'. $product->status_aktif .'">
                        <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                    </button>
                    <a href="#" class="btn btn-sm btn-danger btnDeleteProduct"
                        data-id="'. $product->id .'">
                        <iconify-icon icon="solar:trash-bin-trash-bold" class="me-1"></iconify-icon>Delete
                    </a>
                </div>
                ';
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }

        return view('product.index', compact('title', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_idem' => 'required|unique:products',
            'nama' => 'required|string|max:255',
            'harga' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'status_aktif' => 'required|in:aktif,tidak aktif',
        ]);

        Product::create([
            'no_idem' => $request->no_idem,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'brand_id' => $request->brand_id,
            'status_aktif' => $request->status_aktif
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $rules = [
            'nama' => 'required|string|max:255',
            'harga' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'status_aktif' => 'required|in:aktif,tidak aktif',
        ];

        if ($request->no_idem !== $product->no_idem) {
            $rules['no_idem'] = 'required|unique:products,no_idem';
        } else {
            $rules['no_idem'] = 'required';
        }

        $validated = $request->validate($rules);

        $product->update($validated);

        return response()->json(['message' => 'Product berhasil diupdate']);
    }

    public function destroy ($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product berhasil dihapus']);
    }
}
