<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminLoginSession
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
        if (!session('admin_login')) 
        {   
            if($request->ajax()) 
            {
                return response()->json(['status'=>"0",'msg' => 'Session expired'],401);
                
            }
            else
            {
                $request->session()->put('failed', "Kindly Login First!");
                return redirect()->route('index');
            }
        }
        else
        {   
            // if (session('login')['is_set_profile']==0) 
            // {
            //     return redirect()->route('settings')->with('failed','Kindly Save Your Company Information First!');
            // }
            // else
            // {
                return $next($request);
            // }
        }
    }
}
