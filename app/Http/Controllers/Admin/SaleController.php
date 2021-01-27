<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Orders;

use DB;

class SaleController extends Controller
{

    public function __construct(Request $request)
    {   
    }



    public function Index(Request $request)
    {	 
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $sales = Orders::where('order_status',4)->orderBy('created_at','desc')->get();


            return view('admin.sale',compact('sales'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


    public function checkUserAvailbility($id,$request)
    {   

       
        $user = Admin::where('id',$id)->where('is_blocked',0)->first();


        if ($user == "") 
        {   

            if($request->ajax()) 
            {
                return response()->json(['status'=>"0",'msg' => 'Session expired'],401);
            }
            else
            {
                $request->session()->put("failed","Something went wrong.");
                header('Location:'.url('signout'));
            }
            
            exit();
        }
        else
        {   
            return $user;
        }
    }
    


}
    