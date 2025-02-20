<?php

namespace App\Http\Controllers\api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use App\Repositories\User\RegisterRepository;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, RegisterRepository $registerRepository)
    {
        $validated = $request->validated();

        $registerRepository->register($validated);

        return response()->json([
            'message' => __('messages.user_registered_successfully')
        ], 201);
    }
}
