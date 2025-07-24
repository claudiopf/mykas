<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserAccessController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userAccess = User::with('areas')
                ->where('users.role', 'sales')->get();

            return DataTables::of($userAccess)
                ->addIndexColumn()
                ->addColumn('sales', function ($ua) {
                    return $ua->role === 'sales' ? $ua->name : null;
                })
                ->addColumn('ss', function ($ua) {
                    return $ua->ss?->name ?? 'Belum ada SS';
                })
                ->addColumn('area', function ($ua) {
                    return optional($ua->areas->first())->kode_area ?? 'Belum Ada Area';
                })
                ->addColumn('action', function ($ua) {
                    return '
                            <div class="text-center">
                                <button class="btn btn-sm btn-warning btnEditHakAkses"
                                    data-id="'. $ua->id .'"
                                    data-name="'. $ua->name .'">
                                    <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                                </button>
                                <a href="#" class="btn btn-sm btn-danger btnDeleteUser"
                                    data-id="'. $ua->id .'">
                                    <iconify-icon icon="solar:trash-bin-trash-bold" class="me-1"></iconify-icon>Delete
                                </a>
                            </div>
                        ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user_access.index');
    }
}
