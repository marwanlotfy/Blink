<?php

namespace Blink\Http\Middleware;

use Closure;
use Blink\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatParticipant
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
        if (!Chat::isParticipant($request->chatId,Auth::user()->id)) {
            return response()->json(['message'=>'not_belong_to_chat'],403);
        }
        return $next($request);
    }
}
