<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->apiResponse(null,401,'Данная пара email|пароль не действительна');
        }

        return $this->apiResponse([
            'token' => auth()->user()->createToken('auth-token',['admin-actions'])->plainTextToken
        ], 200);
    }

    public function checkToken()
    {
        return $this->apiResponse([],200);
    }
}
