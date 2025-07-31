<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Retail;
use App\Models\SalesOrder;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
                    return '<span class="badge bg-danger text-capitalize">' . $transaction->status_order . '</span>';
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

    }

}
