<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'User Management';

        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'role']);

            return DataTables::of($users)
                ->addColumn('action', function ($user) {
                    return '
                            <div class="text-center">
                                <button class="btn btn-sm btn-warning btnEditUser"
                                    data-id="'. $user->id .'"
                                    data-name="'. $user->name .'"
                                    data-email="'. $user->email .'"
                                    data-role="'. $user->role .'">
                                    <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>Edit
                                </button>
                                <a href="#" class="btn btn-sm btn-danger btnDeleteUser"
                                    data-id="'. $user->id .'">
                                    <iconify-icon icon="solar:trash-bin-trash-bold" class="me-1"></iconify-icon>Delete
                                </a>
                            </div>
                        ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user_management.index', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,ssadmin,sales',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'User ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,ssadmin,sales',
        ]);

        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Password baru tidak boleh sama dengan password lama!'
                ], 422);
            }

            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        return response()->json(['message' => 'User berhasil diupdate']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }

}
