<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function index()
    {
    return view('items/index');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        return redirect('/mypage/profile');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        // 認証処理（例: Auth::attempt など）
    }
}
