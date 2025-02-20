<?php

namespace App\Http\Controllers\api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $user = Auth::user();

        $token = $user->createToken('login');
        $user->update(['api_token' => $token]);

        return ['token' => $token->plainTextToken];
    }
}
