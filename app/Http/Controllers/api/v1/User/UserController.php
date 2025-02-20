<?php

namespace App\Http\Controllers\api\v1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => __('messages.logout_successfully')
        ]);
    }
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => __('messages.successful_logout_from_all_devices')
        ]);
    }
}
