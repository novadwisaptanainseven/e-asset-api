<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Registrasi User
    public function register(Request $request)
    {
        // Validation
        $messages = [
            'required'     => ':attribute harus diisi!',
            'unique'       => ':attribute sudah ada yang punya'
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:users',
                'password' => 'required',
                'level'    => 'required',
                'name'     => 'required',
            ],
            $messages
        );
        // Jika Validasi Gagal
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->level = $request->level;
        $user->save();

        return response()->json([
            "message" => "Register User Berhasil",
            "input_data"    => $user
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        // Request Validation
        $messages = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "username" => "required",
                "password" => "required"
            ],
            $messages
        );
        // Validation Check
        if ($validator->fails()) {
            // Jika validasi gagal
            return response()->json([
                "errors" => $validator->errors()
            ], 404);
        }

        // Jika validasi berhasil
        $user = User::where("username", $request->username)->first();

        // Cek apakah username benar
        if (!$user) {
            return response()->json([
                "message" => "Username salah / tidak ditemukan"
            ], 400);
        }
        // Cek apakah password benar
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "message" => "Password salah"
            ], 400);
        }

        // Jika semua validasi terlewati
        // Buat token
        $token = $user->createToken($user->username)->plainTextToken;

        $response = [
            "user" => $user,
            "token" => $token
        ];

        return response($response, 201);
    }

    // Cek user saat ini
    public function me()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                "message" => "Authenticated",
                "user"    => $user
            ], 200);
        } else {
            return response()->json([
                "message" => "User belum login"
            ], 200);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Logout Success",
            "user"    => $request->user()
        ]);
    }
}
