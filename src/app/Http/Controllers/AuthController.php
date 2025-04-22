<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
    return view('items/index');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        // ユーザー登録処理
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // ここでログインさせる
        Auth::login($user);

        return redirect('/mypage/profile');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        return view('items/index');
    }
}
