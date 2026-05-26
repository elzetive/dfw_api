<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi input dari Flutter
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // 2. Cek apakah email atau username sudah dipakai
            $cekUser = DB::table('users')
                ->where('email', $request->email)
                ->orWhere('username', $request->username)
                ->first();

            if ($cekUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau Username sudah terdaftar!'
                ], 400);
            }

            // 3. Masukkan data ke tabel users
            DB::table('users')->insert([
                'name'       => $request->name,
                'email'      => $request->email,
                'username'   => $request->username,
                'password'   => Hash::make($request->password), // Enkripsi password
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan masuk.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan ke database',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // ==================== FITUR LOGIN (DITAMBAHKAN) ====================
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_input' => 'required|string',
            'password'    => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Username/Email dan password wajib diisi'
            ], 422);
        }

        try {
            // Mencari user berdasarkan username ATAU email
            $user = DB::table('users')
                ->where('username', $request->login_input)
                ->orWhere('email', $request->login_input)
                ->first();

            // Verifikasi kecocokan akun dan password ber-hash
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username/Email atau password salah!'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login sukses!',
                'data' => [
                    'id'       => $user->id,
                    'name'     => $user->name,
                    'username' => $user->username,
                    'email'    => $user->email,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem login.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
