<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // try{
        // $user=Auth::user();
        // if($user->email_verified_at==NULL){
        //     return response()->json(['message'=>'Verify Email first']);
        // }
        // }
        // catch(\Exception $e){
        //     return response()->json(['error'=> $e->getMessage()]);
        // }
        return $next($request);
    }
}
