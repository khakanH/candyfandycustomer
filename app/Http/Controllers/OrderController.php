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
          elseif ($cart_info->total_item == 0) 
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
          elseif ($cart_info->total_item == 0) 
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

    public function OrderHistoryDetails(Request $request,$id)
    { 
      try 
        {
          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");

          $customer_info = Customer::where('id',$customer_id)->first();

          if ($customer_info == "") 
          {
            if($request->ajax()) 
            {
              return response()->json(['status'=>"0",'msg' => 'Kindly login first to view your order history details'],401);
            }
            else
            {
              return redirect()->route('login-form')->with('failed','Kindly login first to view your order history details');
            }          
          }

            $order = Orders::where('id',$id)->first();
            
            if ($order == "") 
            {
              ?>
              <center><p>No order detail found :(</p></center>
              <?php 
              return;
            }

            if ($order->order_status == 1) 
            {
              $status_name = "New Order";
            }
            elseif ($order->order_status == 2)
            {
              $status_name = "Accepted";
            }
            elseif ($order->order_status == 3)
            {
              $status_name = "Ongoing";
            }
            elseif ($order->order_status == 4)
            {
              $status_name = "Completed";
            }
            elseif ($order->order_status == 5)
            {
              $status_name = "Rejected";
            }
            else
            {
              $status_name = "-";
            }


            $order_item = OrderDetails::where('order_id',$id)->get();

            ?>
            <div class="order-history order-heading ">
                                    <p>Order #<?php echo $order->order_number ?> was placed on <?php echo date('F d, Y h:i A',strtotime($order->created_at))?> and is currently <?php echo $status_name; ?></p>
                                    <div class="order-table mt-4" style="overflow-x:auto;">
                                        <table class="table w-100 ">
                                            <thead>
                                              <tr>
                                                <th>Product</th>
                                                <th>QTY</th>
                                                <th class="text-right">Total</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php foreach($order_item as $key): ?> 
                                              <tr>
                                                <td>
                                                    <h4 class="p-0 m-0"> <?php echo $key['product_name'] ?></h4>
                                                </td>
                                                <td><?php echo $key['quantity'] ?></td>
                                                <td class="text-right">RS <?php echo $key['subtotal'] ?></td>
                                              </tr>
                                              <?php endforeach;?>
                                              
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="amount-qty order-history-detail order-history-content mb-1"> 
                                        <div class="mb-2">
                                            <ul>
                                                <li>Shipping: </li>
                                                <li style="float: right;"><?php echo $order->delivery_fee ?> PKR</li>
                                            </ul>
                                        </div>
                                        <div class="mb-2">
                                            <ul>
                                                <li>Discount: </li>
                                                <li style="float: right;"><?php echo $order->discount ?> PKR</li>
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <ul>
                                                <li>Sub Total: </li>
                                                <li style="float: right; color: #3dc4b4;"><?php echo $order->total_paid_amount ?> PKR</li>
                                            </ul>
                                        </div>
                                    </div> 
                                    <hr>
                                    <div class="row">
                                        
                                        <div class="col-md-12 px-4 py-2">
                                            <h3 class="pb-2">
                                                Shipping Address
                                            </h3>
                                            <div class="border-dash p-4">
                                                <p class="m-0">Name: <?php echo $order->customer_name; ?></p>
                                                <p class="m-0">Phone: <?php echo $order->customer_phone; ?></p>
                                                <p class="m-0">Address: <?php echo $order->delivery_address; ?></p>
                                            </div>
                                        </div>
                                    </div>
                              </div>

            <?php
            
          
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }

}
    