<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
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
        $title = 'Sales - Transaction';

        if ($request->ajax()) {
            $transactions = Transaction::all();

            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('action', function ($transaction) {
                    return '
                            <div class="text-center">
                                <button class="btn btn-sm btn-warning btnEditTransaction"
                                    data-id="' . $transaction->id . '
                                    ">
                                    <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                                </button>
                            </div>
                        ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sales.transaction.index', compact('title'));
    }
}
