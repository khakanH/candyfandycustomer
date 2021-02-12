<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Orders;
use App\Models\OrderDetails;

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


        $product    = Product::count();
        $customer   = Customer::count();
        $all_orders = Orders::get();

        $accepted   = 0;
        $rejected   = 0;
        $completed  = 0;


        foreach ($all_orders as $key) 
        {
            if ($key['order_status'] == 2) 
            {
                $accepted = $accepted + 1;
            }

            if ($key['order_status'] == 4) 
            {
                $completed = $completed + 1;
            }

            if ($key['order_status'] == 5) 
            {
                $rejected = $rejected + 1;
            }
        }


        $earning = $all_orders->where('order_status',4)->sum('total_paid_amount');
        $all_orders = $all_orders->count();


        $monthly_sale = array();
        for ($i=1; $i <= 12  ; $i++) 
        {   
            $monthly_sale[] = Orders::where('order_status',4)->whereMonth('created_at',$i)->whereYear('created_at',date("Y"))->sum('total_paid_amount');
        }


        $product_ids = OrderDetails::select('product_id', DB::raw('COUNT(id) as count'))
                                       ->groupBy('product_id')
                                       ->orderBy(DB::raw('COUNT(id)'), 'DESC')
                                       ->limit(5)
                                       ->get();

            $top_product_name = array();
            $top_product_count = array();
            foreach ($product_ids as $key) 
              {
                $top_product_name[] = (Product::where('id',$key['product_id'])
                                                         ->where('stock','>',0)
                                                         ->where('is_show',1)
                                                         ->first() != "")?Product::where('id',$key['product_id'])
                                                         ->where('stock','>',0)
                                                         ->where('is_show',1)
                                                         ->first()->name:"";
                $top_product_count[] = $key['count'];
              }

            $top_product_name = array_filter($top_product_name);


        return view('admin.dashboard',compact('product','customer','earning','all_orders','accepted','rejected','completed','top_product_name','top_product_count','monthly_sale'));
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
    