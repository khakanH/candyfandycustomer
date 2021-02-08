<?php
namespace App\Http\Controllers\API;

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

use App\Helpers\ApiHelper;


class OrderController extends Controller
{
    protected $common_helper;


    public function __construct(Request $request)
    {   
        $this->common_helper                = new ApiHelper();
    }



    public function Checkout(Request $request)
    {	
      try 
        {
          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);
         
          $input = $request->all();
         
          $cart_id = $input['cart_id'];
         
          $cust_info =  array( 
                            'name'=>(string)$cust_info->name,
                            'email'=>(string)$cust_info->email,
                            'address'=>(string)$cust_info->address,
                            'phone'=>(string)$cust_info->phone,
                        );

          $shipping_discount =GeneralSetting::select(['shipping_fee','discount'])->first();
          $payment_method =PaymentMethod::select(['name'])->where('is_show',1)->get();


          $cart_info = Cart::select(['total_price','total_item'])->where('id',$cart_id)->first();

          if ($cart_info == "") 
          {
          return response()->json(array("status"=>"0","msg"=>"Kindly add something into cart before checkout."), 200);
          }

          $cart_info->subtotal = $cart_info->total_price + $shipping_discount->shipping_fee -($cart_info->total_price * ($shipping_discount->discount/100));
          
          $result = array(
                          'customer_info' => $cust_info,
                          'cart_info'     => $cart_info,
                          // 'shipping_discount' => $shipping_discount,
                          'payment_method' => $payment_method,
                    );

          return response()->json(array("status"=>"1","msg"=>"Checkout Info.","result" => $result), 200);
          
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
         
          $customer_id = $this->common_helper->getCustomerID($request);
          
          $cust_info = $this->checkCustomerAvailbility($customer_id);
         
          $validator = \Validator::make($request->all(), [
                                                                'name'     => 'required',
                                                                'address'  => 'required',
                                                                'phone'    => 'required', 
                                                                'payment'  => 'required', 
                                                            ]);
            

            if ($validator->fails()) 
            {   
                return response()->json(array("msg"=>"Required field is missing.",'status'=>"0"), 200);
            }

          $input = $request->all();
         
          $cart_id = $input['cart_id'];
         
          $shipping_discount =GeneralSetting::first();


          $cart_info = Cart::where('id',$cart_id)->first();

          if ($cart_info == "") 
          {
            return response()->json(array("status"=>"0","msg"=>"Kindly add something into cart before checkout."), 200);

          }





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

            return response()->json(array("status"=>"1","msg"=>"Order Placed Successfully."), 200);
          
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }
    



    public function OrderHistory(Request $request)
    { 
      try 
        {
          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");

          $customer_info = Customer::where('id',$customer_id)->first();

          if ($customer_info == "") 
          {
            if($request->ajax()) 
            {
              return response()->json(['status'=>"0",'msg' => 'Kindly login first to view your order history'],401);
            }
            else
            {
              return redirect()->route('login-form')->with('failed','Kindly login first to view your order history');
            }          
          }

          $orders = Orders::where('customer_id',$customer_id)->orderBy('created_at','desc')->get();
            
            

            return view('order_history',compact('orders'));
          
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }

    public function OrderDetails(Request $request)
    { 
      try 
        {
          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);
         
          $input = $request->all();
         
          $id = $input['order_id'];

            $order = Orders::select(['id','order_number','order_status','created_at','delivery_fee','discount','total_paid_amount','customer_name','customer_phone','delivery_address'])->where('id',$id)->first();
            
            if ($order == "") 
            {
              return response()->json(array("status"=>"0","msg"=>"No Order Found."), 200);
            }

            if ($order->order_status == 1) 
            {
              $order->order_status = "New Order";
            }
            elseif ($order->order_status == 2)
            {
              $order->order_status = "Accepted";
            }
            elseif ($order->order_status == 3)
            {
              $order->order_status = "Ongoing";
            }
            elseif ($order->order_status == 4)
            {
              $order->order_status = "Completed";
            }
            elseif ($order->order_status == 5)
            {
              $order->order_status = "Rejected";
            }
            else
            {
              $order->order_status = "-";
            }

            $order->date = date('F d, Y h:i A',strtotime($order->created_at));
            unset($order->created_at);

            $order_item = OrderDetails::select(['product_id','product_name','quantity','subtotal'])->where('order_id',$id)->get();

            $result = array('order_info'=>$order,'order_items'=>$order_item);

            return response()->json(array("status"=>"1","msg"=>"OrderDetails.","result"=>$result), 200);
          
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }







    public function checkCustomerAvailbility($id)
    {
        $cust = Customer::where('id',$id)->first();

        if ($cust == "") 
        {
            echo json_encode(array("status"=>"0","msg"=>"Customer Not Found"), 200); 
            exit();
        }
        else
        {
            return $cust;
        }
    }

}
    