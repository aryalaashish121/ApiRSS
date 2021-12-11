<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUrlSection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        $pathLowercase = strtolower($path); 
        if($path!==$pathLowercase){
            return response()->json([
                "error"=>"Url Can only be in lower case!"
            ],406);
        }
        return $next($request);
    }
}
