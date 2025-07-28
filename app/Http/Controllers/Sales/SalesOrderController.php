<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Retail;
use App\Models\SalesOrder;

class SalesOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = 'Sales Order';

        if (request()->ajax()) {
            $salesOrders = SalesOrder::all();

            return datatables()->of($salesOrders)
                ->addIndexColumn()
                ->addColumn('tgl_order', function ($salesOrder) {
                    return '25/07/2025';
                })
                ->addColumn('toko', function ($salesOrder) {
                    return 'Red Bull Racing';
                })
                ->addColumn('product', function ($salesOrder) {
                    return 'Lampu Philips';
                })
                ->addColumn('total_penjualan', function ($salesOrder) {
                    return 'Rp ' . number_format(1000000, 0, ',', '.');
                })
                ->make(true);
        }

        return view('sales_order.index', compact('title'));
    }

    public function create()
    {
        $title = 'Sales Order';
        $user = auth()->user();
        $products = collect();
        $retails = collect();

        if ($user->role === 'sales') {
            $areas = $user->areas;
            $areaNames = $areas->pluck('nama')->map(fn($n) => strtolower($n));

            if ($areaNames->contains('tr')) {
                $products = Product::whereHas('brand', function ($q) {
                    $q->where('nama', 'Philips');
                })->get();

                $retails = Retail::whereHas('areas', function ($q) use ($areaNames) {
                    $q->whereIn('areas.nama', $areaNames);
                })->get();

            } elseif ($areaNames->contains('multi')) {
                $products = Product::whereHas('brand', function ($q) {
                    $q->where('nama', '!=', 'Philips');
                })->get();

                $retails = Retail::whereHas('areas', function ($q) use ($areaNames) {
                    $q->whereIn('areas.nama', $areaNames);
                })->get();

            } elseif ($areaNames->contains('horecin')) {
                $products = Product::all();

                $retails = Retail::whereHas('areas', function ($q) use ($areaNames) {
                    $q->whereIn('areas.nama', $areaNames);
                })->get();
            }
        } else {
            $products = Product::all();
            $retails = Retail::all();
        }

        return view('sales_order.create', compact('title', 'products', 'retails'));
    }
}
