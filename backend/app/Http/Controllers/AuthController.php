<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * ログインAPI
     *
     * ユーザーのメールアドレスとパスワードでログインし、トークンを発行します。
     *
     * @group 認証
     *
     * @bodyParam email string required メールアドレス Example: test@example.com
     * @bodyParam password string required パスワード Example: password123
     *
     * @response 200 {
     *   "token": "1|xxxxxx",
     *   "token_type": "Bearer"
     * }
     * @response 401 {
     *   "message": "認証に失敗しました。"
     * }
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)){
            $user = $request->user();
            $token = $user->createToken('AccessToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => '認証に失敗しました'], 401);
        }
    }

    //認証情報の取得
    public function user(Request $request)
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
