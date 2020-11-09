<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AfterCall
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
        $response = $next($request);
        $request->logs["ms"] = (hrtime(true) - $request->logs["ms"])/1e+6; // nanosec to milisec
        Log::info("Request",$request->logs);
        $response->header("log_id",$request->logs["id"]); //Save log id to heeder for send to client
        return $response;
    }
}
