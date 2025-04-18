<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

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
}
