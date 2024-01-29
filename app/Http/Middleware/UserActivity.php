<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use DB;


class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


    $user=DB::table('users')->where('id',Auth::user()->id)->first();

    if($user->role=='admin'){
        if($request->url()==url('/user')){
            return redirect()->route('admin');
        } 
        return $next($request);
    }
    if($user->role=='user'){
        if($request->url()==url('/admin')){
            return redirect()->route('user');
        } 
        return $next($request);
    }

    return redirect()->route('login');
   
    }
}
