<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::query()->where('email', $data['email'])->first();

        if($user){
            if(Hash::check($data['password'], $user->password)){
                $token = $user->createToken($user->password)->plainTextToken;

                return response()->json([
                    'message' => 'success',
                    'data' => [
                        'user' => $user,
                        'token' => $token
                    ]
                ]);
            }
        }

        return response()->json([
            'data' => [],
            'message' => 'Email / password salah'
        ], 400);
    }

    public function Register(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'phone' => 'required'
        ]);

        $data['password'] = Hash::make($data['password']);

        $make_user = User::create($data);

        if($make_user){
            $token = $make_user->createToken($request->password)->plainTextToken;

            return response()->json([
                'message' => 'success',
                'data' => [
                    'user' => $make_user,
                    'token' => $token
                ]
            ]);
        }

        return response()->json([
            'message' => 'failed',
            'data' => []
        ]);
    }
}
