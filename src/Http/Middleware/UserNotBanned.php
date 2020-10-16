<?php

namespace Blink\Http\Middleware;

use Closure;
use Blink\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Chat::isBanned($request->chatId,Auth::user()->id)) {
            return response()->json(['message'=>'get_banned'],403);
        }
        return $next($request);
    }
}
