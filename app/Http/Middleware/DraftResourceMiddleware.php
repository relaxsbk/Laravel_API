<?php

namespace App\Http\Middleware;

use App\Exceptions\ResourceNotFoundException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DraftResourceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws ResourceNotFoundException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $resource = $request->route('resource');

        if ($resource->isDraft()) {
            throw new ResourceNotFoundException();
        }



        return $next($request);
    }
}
