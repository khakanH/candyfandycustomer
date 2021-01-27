<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;

use DB;

class DashboardController extends Controller
{

    public function __construct(Request $request)
    {   
    }



    public function Index(Request $request)
    {	
        $user_id = session("admin_login.user_id");

        $user_info = $this->checkUserAvailbility($user_id,$request);

        return view('admin.dashboard');
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
    