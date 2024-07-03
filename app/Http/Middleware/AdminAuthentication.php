<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->admin_username;
        $password = $request->admin_password;
        if($username == "admin" && $password == "admin"){
            return $next($request);
        }

        Session::put('error', 'Account Not Found');
        $error = Session::get('error');
        return redirect()->route('home')->with('error',$error);
    }
}
