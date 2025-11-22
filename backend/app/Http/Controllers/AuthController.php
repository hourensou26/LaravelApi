<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $me = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // 登録後に自動的にトークンを発行してログイン状態にする
        $token = $me->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'ユーザー登録が完了しました',
            'user' => [
                'name' => $me->name,
                'email' => $me->email,
            ],
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)){
            $me = $request->user();
            $token = $me->createToken('AccessToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => '認証に失敗しました'], 401);
        }
    }

    //認証情報の取得
    public function me(Request $request)
    {
        return response()->json([
            'name' => $request->user()->name,
            'email' => $request->user()->email,
        ]);
    }

    //ログアウト処理
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'ログアウトしました'], 200);
    }
}
