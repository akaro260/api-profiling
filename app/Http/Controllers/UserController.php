<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tambah user baru oleh Admin / Guru

    public function index()
    {
        $users = User::query()
                ->latest()
                ->paginate(10);
        return response()->json([
            'message' => 'Berhasil mengambil data user',
            'data' => $users
        ]);
    }
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,guru,siswa', // Menentukan role user
        ]);

        // 2. Simpan User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // 3. Return response (Tanpa generate token, karena user baru belum login)
        return response()->json([
            'message' => 'Berhasil membuat akun user baru',
            'data' => $user
        ], 201);
    }
    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'role' => 'sometimes|required|in:admin,guru,siswa', // Menentukan role user
        ]);

        // 2. Cari User berdasarkan ID
        $user = User::findOrFail($id);

        // 3. Update User
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->has('role')) {
            $user->role = $request->role;
        }
        $user->save();

        // 4. Return response
        return response()->json([
            'message' => 'Berhasil memperbarui akun user',
            'data' => $user
        ]);
    }
    public function destroy($id)
    {
        // 1. Cari User berdasarkan ID
        $user = User::findOrFail($id);

        // 2. Hapus User
        $user->delete();

        // 3. Return response
        return response()->json([
            'message' => 'Berhasil menghapus akun user'
        ]);
    }

    public function updateProfile(Request $request)
    {
        // Ambil user yang sedang login
        $user = $request->user();

        // Validasi input
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        // Update nama jika dikirim
        if (isset($validated['name'])) {
            $user->name = $validated['name'];
        }

        // Update email jika dikirim
        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }

        // Update password jika dikirim
        if (isset($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'data' => $user->only(['id', 'name', 'email', 'role']),
        ]);
    }

}