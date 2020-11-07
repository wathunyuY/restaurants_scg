<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckType
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
        if (empty($request->keyword) && empty($request->next)) { //Check empty of params
            return response("Missing params",400);
        }
        if (!empty($request->keyword)) {// Check and create key type for redis key : send keyword or send next (next page token)
            $key = 'keyword:' . urlencode($request->keyword);
        } else {
            $key = 'next:' . urlencode($request->next);
        }
        $request->redis_key = $key;
        return $next($request);
    }
}
