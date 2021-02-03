<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\CustomerToken;

class CheckToken
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
         date_default_timezone_set('Asia/Karachi');
        // print_r($request->header());
        
        // $token_explode = explode(" ",$request->header('Authorization'));

        $header         =  $request->header('x-api-key');
        if(CustomerToken::where(array('token'=>$header))->count()>0){
            $checkToken     = CustomerToken::where(array('token'=>$header))->first();
            if(time() > $checkToken->expiry_time) {
                return response()->json(array("msg"=>"unauthorized","status"=>"0"), 401);
            }
        }else{
            return response()->json(array("msg"=>"unauthorized",'status'=>"0"), 401);
        }



        return $next($request);
    }
}
