<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Retail;
use App\Models\SalesOrder;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use function Symfony\Component\String\s;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'Transaksi';

        if ($request->ajax()) {
            $transactions = Transaction::with([
                'salesOrder.retail',
                'salesOrder.user',
                'salesOrder.salesOrderDetails.product',
            ])->get();

            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('no_order', function ($transaction) {
                    return $transaction->salesOrder->no_order;
                })
                ->addColumn('nama_toko', function ($transaction) {
                    return $transaction->salesOrder->retail->nama;
                })
                ->addColumn('sales', function ($transaction) {
                    return $transaction->salesOrder->user->name;
                })
                ->addColumn('note_sales', function ($transaction) {
                    return $transaction->salesOrder->note_sales;
                })
                ->addColumn('status', function ($transaction) {
                    $status = $transaction->status_order;

                    if ($status === 'pending') {
                        return '<span class="badge bg-warning text-capitalize">Pending</span>';
                    } elseif ($status === 'approved') {
                        return '<span class="badge bg-success text-capitalize">Approved</span>';
                    } elseif ($status === 'rejected') {
                        return '<span class="badge bg-danger text-capitalize">Rejected</span>';
                    }

                    return '<span class="badge bg-secondary">Belum ada data</span>';
                })
                ->addColumn('action', function ($transaction) {
                    $editUrl = route('transaction.edit', $transaction->id);

                    return '
                                <div class="text-center">
                                    <a class="btn btn-sm btn-warning btnEditTransaction" href="' . $editUrl . '" data-id="' . $transaction->id . '">
                                        <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                                    </a>
                                </div>
                            ';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('sales.transaction.index', compact('title'));
    }

    public function edit($id)
    {
        $title = 'Transaksi - Edit';
        $transaction = Transaction::with([
            'salesOrder.user',
            'salesOrder.retail',
            'salesOrder.salesOrderDetails.product'
        ])->findOrFail($id);

        $products = Product::all();
        $retails = Retail::all();

        return view('sales.transaction.edit', compact('transaction', 'title', 'products', 'retails'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'retail_id' => 'required|exists:retails,id',
            'top' => 'required|integer',
            'status_order' => 'required|in:approved,rejected,pending',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'discount' => 'required|array',
            'discount.*' => 'numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $user = auth()->user();
            if (!in_array($user->role, ['ssadmin', 'admin'])) {
                return response()->json(['message' => 'Hanya SS Admin atau Admin yang bisa meng-approve transaksi.'], 403);
            }

            $transaction = Transaction::findOrFail($id);
            $transaction->update([
                'status_order' => $request->status_order,
                'note_ssadmin' => $request->note_ssadmin,
                'approved_by' => $user->id,
            ]);

            $salesOrder = $transaction->salesOrder;
            $salesOrder->update([
                'retail_id' => $request->retail_id,
                'top' => $request->top,
            ]);

            $existingDetails = $salesOrder->salesOrderDetails()->get()->keyBy('product_id');

            $formProductIds = collect($request->product_id);
            $inputQty = collect($request->qty);
            $inputDiscount = collect($request->discount);

            $processedProductIds = [];

            foreach ($formProductIds as $index => $productId) {
                $qty = $inputQty[$index];
                $discount = $inputDiscount[$index] ?? 0;

                if ($existingDetails->has($productId)) {
                    // update jika sudah ada
                    $detail = $existingDetails[$productId];
                    $detail->update([
                        'qty' => $qty,
                        'discount' => $discount,
                    ]);
                } else {
                    // insert baru
                    $salesOrder->salesOrderDetails()->create([
                        'product_id' => $productId,
                        'qty' => $qty,
                        'discount' => $discount,
                    ]);
                }

                $processedProductIds[] = $productId;
            }

            // delete jika di DB tapi tidak dikirim dari form
            $idsToDelete = $existingDetails->keys()->diff($processedProductIds);
            if ($idsToDelete->isNotEmpty()) {
                $salesOrder->salesOrderDetails()
                    ->whereIn('product_id', $idsToDelete)
                    ->delete();
            }

            DB::commit();

            return response()->json(['message' => 'Transaksi berhasil diperbarui.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan.', 'error' => $e->getMessage()], 500);
        }
    }
}
