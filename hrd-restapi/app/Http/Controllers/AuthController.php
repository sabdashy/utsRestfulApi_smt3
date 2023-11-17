<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Membuat fitur Register
    public function register(Request $request)
    {
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = User::create($input);

        $data = [
            'message' => 'User is created succesfully'
        ];

        // Mengirim response JSON
        return response()->json($data, 200);
    }

    // Membuat fitur login
    public function login(Request $request)
    {
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Melakukan autentikasi
        if (Auth::attempt($input)) {
            // membuat token
            $token = Auth::user()->createToken('auth_token');
            $data = [
                'message' => 'Login succesfully',
                'token' => $token->plainTextToken
            ];

            // Mengembalikan response JSON
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Username or Password is wrong'
            ];

            return response()->json($data, 40);
        }
    }
}
