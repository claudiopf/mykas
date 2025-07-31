<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserAccessController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::all();
        $roleSs = User::with('areas')
            ->where('users.role', 'ssadmin')->get();

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
                    return $ua->areas->pluck('kode_area')->implode(', ');
                })
                ->addColumn('action', function ($ua) {
                    $areaIds = $ua->areas->pluck('id')->implode(',');
                    $ss = $ua->ss_id ?? 'Belum Ada SS';

                    return '
                            <div class="text-center">
                                <button class="btn btn-sm btn-warning btnEditHakAkses"
                                    data-id="'. e($ua->id) .'"
                                    data-sales="'. e($ua->name) .'"
                                    data-area="'. e($areaIds) .'"
                                    data-ss="'. e($ss) .'">
                                    <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                                </button>
                            </div>
                        ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user.user_access.index', compact('roleSs', 'areas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ss_id' => 'required|exists:users,id',
            'area_id' => 'required|array',
            'area_id.*' => 'exists:areas,id',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'ss_id' => $request->ss_id,
        ]);

        $user->areas()->sync($request->area_id);

        return response()->json([
            'status' => true,
            'message' => 'Hak akses berhasil diperbarui.',
        ]);
    }
}
