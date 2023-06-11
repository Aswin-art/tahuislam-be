<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function GetUserProfile(Request $request)
    {
        $user = User::query()->with(['questions', 'answers'])->where('id', auth('sanctum')->user()->id)->first();

        if($user){
            return response()->json([
                'message' => 'success',
                'data' => $user
            ]);
        }

        return response()->json([
            'message' => 'failed',
            'data' => []
        ]);
    }

    public function UpdateProfile(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'phone' => 'sometimes',
            'photo_url' => 'sometimes',
        ]);

        if($request->file('photo_url')){
            $data['photo_url'] = $request->file('photo_url')->store('users');
        }

        $update_user = User::where('id', auth('sanctum')->user()->id)->update([
            'username' => $data['username'],
            'phone' => $data['phone'],
            'photo_url' => $data['photo_url'],
        ]);

        if($update_user){
            return response()->json([
                'message' => 'success',
                'data' => $update_user
            ]);
        }

        return response()->json([
            'message' => 'failed',
            'data' => []
        ], 500);
    }
}
