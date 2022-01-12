<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|exists:users',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->apiResponse(null,401,'Данная пара email|пароль не действительна');
        }

        return $this->apiResponse(['token' => auth()->user()->tokens()->first()], 200);
    }

    public function checkToken()
    {
        return $this->apiResponse([],200);
    }

    public function register(CreateUserRequest $request)
    {
        $user = $request->user;
        $user = User::updateOrCreate(
            ['email' => $user['email']],
            $user
        );

        $user->createToken('auth-token',['admin-actions']);

        return $this->apiResponse($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = User::updateOrCreate(
            ['id' => $user['id']],
            $request->user
        );

        return $this->apiResponse($user);
    }
}
