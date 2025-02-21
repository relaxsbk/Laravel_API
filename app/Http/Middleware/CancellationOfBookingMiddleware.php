<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CancellationOfBookingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $booking = $request->route('booking');

        if ($user->id !== $booking->user_id && !$user->isAdmin()) {
            return response()->json([
                'message' => __('messages.you_have_no_rights')
            ], 403);
        }

        return $next($request);
    }
}
