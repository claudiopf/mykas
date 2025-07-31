<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Retail;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SalesOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Sales Order';
        $user = auth()->user();

        $salesOrders = SalesOrder::with(['retail', 'salesOrderDetails.product']);

        if ($user->role === 'sales') {
            $salesOrders->where('user_id', $user->id);
        } elseif ($user->role === 'ss_admin') {
            $salesIds = User::whereHas('areas', function ($q) use ($user) {
                $q->whereIn('area_id', $user->areas->pluck('id'));
            })->pluck('id');

            $salesOrders->whereIn('user_id', $salesIds);
        }

        if (request()->ajax()) {
            $salesOrders = $salesOrders->get();

            return datatables()->of($salesOrders)
                ->addIndexColumn()
                ->addColumn('no_order', function ($salesOrder) {
                    return '<span class="text-center text-nowrap">' . $salesOrder->no_order . '</span>';
                })
                ->addColumn('tgl_order', function ($salesOrder) {
                    return Carbon::parse($salesOrder->order_time)->format('d/m/Y');
                })
                ->addColumn('toko', function ($salesOrder) {
                    $namaToko = $salesOrder->retail->nama ?? 'Belum ada data';
                    return '<span class="text-center text-nowrap">' . $namaToko . '</span>';
                })
                ->addColumn('product', function ($salesOrder) {
                    $sortedDetails = $salesOrder->salesOrderDetails->sortBy(function ($detail) {
                        return $detail->product->nama ?? '';
                    });

                    $rows = '';

                    if ($sortedDetails->isEmpty()) {
                        $rows .= "<tr><td colspan='4' class='text-center'>Tidak ada produk</td></tr>";
                    } else {
                        foreach ($sortedDetails as $detail) {
                            $namaProduct = $detail->product->nama ?? '-';
                            $rows .= "<tr>
                        <td>{$namaProduct}</td>
                        <td class='text-center'>{$detail->qty}</td>
                        <td class='text-center'>{$salesOrder->top}</td>
                        <td class='text-center '>{$detail->discount}%</td>
                    </tr>";
                        }
                    }

                    return "<table class='table table-bordered border-dark-subtle table-sm table-nested-product mb-0'>
                                <thead class='bg-primary'>
                                    <tr>
                                        <th class='text-white text-center'>Nama Produk</th>
                                        <th class='text-white text-center'>Qty</th>
                                        <th class='text-white text-center'>TOP</th>
                                        <th class='text-white text-center'>Diskon</th>
                                    </tr>
                                </thead>
                                <tbody>{$rows}</tbody>
                            </table>";
                })

                ->addColumn('total_penjualan', function ($salesOrder) {
                    $total = 0;
                    foreach ($salesOrder->salesOrderDetails as $detail) {
                        $harga = $detail->product->harga ?? 0;
                        $diskon = $detail->discount ?? 0;
                        $subtotal = $harga * $detail->qty * (1 - $diskon / 100);
                        $total += $subtotal;
                    }
                    return '<span class="text-center text-nowrap">Rp ' . number_format($total, 0, ',', '.') . '</span>';
                })
                ->rawColumns(['no_order','toko', 'product', 'total_penjualan'])
                ->make(true);
        }

        return view('sales.sales_order.index', compact('title'));
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

        return view('sales.sales_order.create', compact('title', 'products', 'retails'));
    }


    public function store(Request $request)
    {
        $validData = $request->validate([
            'retail_id' => 'required|exists:retails,id',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'exists:products,id',
            'qty' => 'required|array|min:1',
            'qty.*' => 'integer|min:1',
            'discount' => 'required|array|min:1',
            'discount.*' => 'numeric|min:0',
        ]);

        try {
            $sales = auth()->user()->id;
            $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $datePart = Carbon::now('Asia/Jakarta')->format('dmy');

            $lastOrder = SalesOrder::whereDate('order_time', $today)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastOrder && preg_match('/KSO-\d{6}-(\d{4})/', $lastOrder->no_order, $matches)) {
                $lastNumber = (int) $matches[1];
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $noOrder = 'KSO-' . $datePart . '-' . $newNumber;

            $salesOrder = SalesOrder::create([
                'retail_id' => $validData['retail_id'],
                'user_id' => $sales,
                'top' => $request->top,
                'note_sales' => $request->note_sales,
                'order_time' => now('Asia/Jakarta'),
                'no_order' => $noOrder,
            ]);

            Transaction::create([
                'sales_order_id' => $salesOrder->id,
            ]);

            $details = [];
            foreach ($validData['product_id'] as $i => $productId) {
                $details[] = new SalesOrderDetail([
                    'product_id' => $productId,
                    'qty' => $validData['qty'][$i],
                    'discount' => $validData['discount'][$i],
                ]);
            }

            $salesOrder->salesOrderDetails()->saveMany($details);

            return response()->json(['message' => 'Sales order berhasil disimpan.']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menyimpan data.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
