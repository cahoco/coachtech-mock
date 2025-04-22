<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddressRequest;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function mypage()
    {
        return view('users.mypage');
    }

    public function edit()
    {
        return view('users.edit');
    }

    public function update(AddressRequest $request)
    {
        $validated = $request->validated();
        return redirect()->route('items.index');
    }
}
