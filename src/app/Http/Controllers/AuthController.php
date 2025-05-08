<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
    return view('items/index');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Auth::login($user);

        // メール認証イベント発火（これがないとメール送られない）
        event(new Registered($user));

        // プロフィール登録フラグは保持したまま
        Session::put('needs_profile_setup', true);

        // ✅ Fortifyが自動で /email/verify を表示してくれる
        return redirect()->route('verification.notice');
    }

    public function login(LoginRequest $request)
    {
        // LoginRequest内でバリデーション & 認証失敗時のメッセージ処理
        $request->authenticate();

        // 認証成功時
        return redirect()->route('items.index');
    }

}
