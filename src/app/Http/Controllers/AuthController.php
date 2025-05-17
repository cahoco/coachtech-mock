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
        event(new Registered($user));
        Session::put('needs_profile_setup', true);
        return redirect()->route('verification.notice');
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();
        return redirect()->route('items.index');
    }

}
