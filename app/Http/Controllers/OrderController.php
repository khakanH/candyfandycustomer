<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;

use App\Models\GeneralSetting;
use App\Models\PaymentMethod;


use DB;

class OrderController extends Controller
{

    public function __construct(Request $request)
    {   
    }



    public function Checkout(Request $request)
    {	
      try 
        {
          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
          $cart_id = empty(session("cart_id"))?0:session("cart_id");

          $shipping_discount =GeneralSetting::first();
          $payment_method =PaymentMethod::where('is_show',1)->get();

          $customer_info = Customer::where('id',$customer_id)->first();

          if ($customer_info == "") 
          {
            if($request->ajax()) 
            {
              return response()->json(['status'=>"0",'msg' => 'Kindly login first before checkout'],401);
            }
            else
            {
              return redirect()->route('login-form')->with('failed','Kindly login first before checkout');
            }          
          }

          $cart_info = Cart::where('id',$cart_id)->first();

          if ($cart_info == "") 
          {
            if($request->ajax()) 
            {
              return response()->json(['status'=>"0",'msg' => 'No Cart Found'],401);
            }
            else
            {
              return redirect()->route('product_list')->with('failed','Kindly add something into cart.');
            }     
          }

          $cart_info->all_total = $cart_info->total_price + $shipping_discount->shipping_fee -($cart_info->total_price * ($shipping_discount->discount/100));

          return view('checkout',compact('customer_info','cart_info','shipping_discount','payment_method'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


    public function PlaceOrder(Request $request)
    { 
      try 
        {
          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
          $cart_id = empty(session("cart_id"))?0:session("cart_id");

          $shipping_discount =GeneralSetting::first();

          $customer_info = Customer::where('id',$customer_id)->first();

          if ($customer_info == "") 
          {
            if($request->ajax()) 
            {
              return response()->json(['status'=>"0",'msg' => 'Kindly login first before checkout'],401);
            }
            else
            {
              return redirect()->route('login-form')->with('failed','Kindly login first before checkout');
            }          
          }

          $cart_info = Cart::where('id',$cart_id)->first();

          if ($cart_info == "") 
          {
            if($request->ajax()) 
            {
              return response()->json(['status'=>"0",'msg' => 'No Cart Found'],401);
            }
            else
            {
              return redirect()->route('product_list')->with('failed','Kindly add something into cart.');
            }     
          }



          $validator = \Validator::make($request->all(), [
                                                                'name'     => 'required',
                                                                'address'  => 'required',
                                                                'phone'    => 'required', 
                                                                'payment'  => 'required', 
                                                            ]);
            

            if ($validator->fails()) 
            {   
                return redirect()->back()->with('failed','Kindly fill all required fields.');
            }

            $input = $request->all();

            $order_number = time().rand(1111,9999);

            $total_paid_amount =  $cart_info->total_price + $shipping_discount->shipping_fee -($cart_info->total_price * ($shipping_discount->discount/100));


            $order_id = Orders::insertGetId(array(
                                  "order_number"        => $order_number,
                                  "customer_id"         => $customer_id,
                                  "customer_name"       => $input['name'],
                                  "customer_phone"       => $input['phone'],
                                  "delivery_address"    => $input['address'],
                                  "delivery_latitude"   => "",
                                  "delivery_longitude"  => "",
                                  "notes"               => "",
                                  "order_status"        => 1,
                                  "cancel_type"         => 0,
                                  "payment_type"        => $input['payment'],
                                  "is_paid"             => ($input['payment'] == 1)?1:0,
                                  "delivery_fee"        => $shipping_discount->shipping_fee,
                                  "order_amount"        => $cart_info->total_price,
                                  "discount"            => ($cart_info->total_price * ($shipping_discount->discount/100) ),
                                  "total_paid_amount"   => $total_paid_amount,
                                  "total_item"          => $cart_info->total_item,
                                  "created_at"          => date('Y-m-d H:i:s'),
                                  "updated_at"          => date('Y-m-d H:i:s'),
                    ));

            $cart_items = CartDetail::where('cart_id',$cart_id)->get();

            foreach ($cart_items as $key) 
            {
              $get_prod = Product::where('id',$key['product_id'])->where('is_show',1)->where('stock','>',0)->first();
              if ($get_prod != "") 
              {
                OrderDetails::insert(array(
                                    "order_id"      => $order_id,
                                    "order_number"  => $order_number,
                                    "product_id"    => $key['product_id'],
                                    "product_name"  => $get_prod->name,
                                    "product_price" => $get_prod->sale_price,
                                    "quantity"      => $key['product_quantity'],
                                    "subtotal"      => $get_prod->sale_price*$key['product_quantity'],
                                    "created_at"    => date('Y-m-d H:i:s'),
                                    "updated_at"    => date('Y-m-d H:i:s'),
                              ));
              }
            }

            CartDetail::where('cart_id',$cart_id)->delete();
            Cart::where('id',$cart_id)->update(array('total_item'=>0,'total_price'=>0));
            $request->session()->put("cart_total_item",0);

            return redirect()->route('thankyou');
          
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }
    


}
    