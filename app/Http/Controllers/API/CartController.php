<?php
namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\Cart;
use App\Models\CartDetail;


use App\Models\GeneralSetting;


use File;
use DB;

use App\Helpers\ApiHelper;


class CartController extends Controller
{

    protected $common_helper;


    public function __construct(Request $request)
    {
        $this->common_helper                = new ApiHelper();
    }

    public function Index(Request $request)
    {
        try 
        { 

          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);
         
          $input = $request->all();
         

          $cart_id = $input['cart_id'];

          $shipping_discount =GeneralSetting::first();


          $cart = Cart::where('id',$cart_id)->first(); 
          $cart_detail = CartDetail::where('cart_id',$cart_id)->get();

          foreach ($cart_detail as $key) 
          {
            $get_prod = Product::where('id',$key['product_id'])->where('is_show',1)->where('stock','>',0)->first();
            if ($get_prod != "") 
            {
              $key['product_name']  = $get_prod->name;
              $key['product_price'] = $get_prod->sale_price;
              $key['product_image'] = $get_prod->image;
              $key['product_subtotal'] = $get_prod->sale_price*$key['product_quantity'];
            }
            else
            {
              $key['product_name']  = "";
              $key['product_price'] = "";
              $key['product_image'] = "";
              $key['product_subtotal'] = "";
            }

          }

          $grand_total = ($cart->total_price + $shipping_discount->shipping_fee) - ($cart->total_price * ($shipping_discount->discount/100) ) ;


          $result = array(
                          'cart_item'=>$cart_detail,
                          'total_calculations' => array(
                                                        'shipping'  => $shipping_discount->shipping_fee,
                                                        'discount'  => $shipping_discount->discount,
                                                        'subtotal'  => $cart->total_price,
                                                        'items'     => $cart->total_item,
                                                        'grand_total' => $grand_total,
                                                  ),
                    );




          return response()->json(array("status"=>"1","msg"=>"Cart List","result"=>$result), 200);



        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }

    public function AddToCart(Request $request)
    {
        try 
        {  
         
          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);
         
          $input = $request->all();
         

          $cart_id = $input['cart_id'];
          $prod_id = $input['product_id'];

          $get_prod = Product::where('id',$prod_id)->where('is_show',1)->where('stock','>',0)->first();

          if ($get_prod == "") 
          {
            return response()->json(array("status"=>"0","msg"=>"No Product Found."), 200);
          }


         $check_cart  = Cart::where('id',$cart_id)->first();
         if ($check_cart == "") 
         {
            //make new cart
            $cart_id = Cart::insertGetId(array(
                                      "customer_id" => $customer_id,
                                      "total_price" => $get_prod->sale_price,
                                      "total_item"  => 1,
                                      "created_at"  => date("Y-m-d H:i:s"),
                                      "updated_at"  => date("Y-m-d H:i:s"),
                  ));


            CartDetail::insert(array(
                                "cart_id"           => $cart_id,
                                "customer_id"       => $customer_id,
                                "product_id"        => $prod_id,
                                "product_name"      => $get_prod->name,
                                "product_price"     => $get_prod->sale_price,
                                "product_quantity"  => 1,
                                "product_subtotal"  => $get_prod->sale_price,
                                "created_at"        => date("Y-m-d H:i:s"),
                                "updated_at"        => date("Y-m-d H:i:s"),

                        ));

            $new_cart_id = $cart_id;
         }
         else
         {
            //update existing cart
            $check_cart_prod = CartDetail::where('cart_id',$check_cart->id)->where('product_id',$prod_id)->first();

            if ($check_cart_prod == "") 
            {
                CartDetail::insert(array(
                                "cart_id"           => $check_cart->id,
                                "customer_id"       => $customer_id,
                                "product_id"        => $prod_id,
                                "product_name"      => $get_prod->name,
                                "product_price"     => $get_prod->sale_price,
                                "product_quantity"  => 1,
                                "product_subtotal"  => $get_prod->sale_price,
                                "created_at"        => date("Y-m-d H:i:s"),
                                "updated_at"        => date("Y-m-d H:i:s"),

                        ));

            }
            else
            { 
              CartDetail::where('cart_id',$check_cart->id)->where('product_id',$prod_id)
                        ->update(array(
                                "product_name"      => $get_prod->name,
                                "product_price"     => $get_prod->sale_price,
                                "product_quantity"  => $check_cart_prod->product_quantity + 1,
                                "product_subtotal"  => $get_prod->sale_price * ($check_cart_prod->product_quantity + 1),
                                
                          ));
            }


           $cart_total_price = CartDetail::where('cart_id',$check_cart->id)->sum('product_subtotal');
           $cart_total_item  = CartDetail::where('cart_id',$check_cart->id)->count();


           Cart::where('id',$check_cart->id)->update(array(
                                                  "total_price" => $cart_total_price,
                                                  "total_item"  => $cart_total_item,
                                              ));


           $new_cart_id = $check_cart->id;

         }
          
          

          $product_count    = CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->first()->product_quantity;
          $total_item_count = Cart::where('id',$cart_id)->first()->total_item;


         return response()->json(array("status"=>"1","msg"=>"Item Added.","result"=>array("product_count"=>$product_count,"total_item_count"=>$total_item_count,'cart_id'=>$new_cart_id)));


        
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function ChangeCartItemQty(Request $request)
    {
        try 
        { 

          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);
         
          $input = $request->all();
         

          $cart_id = $input['cart_id'];
          $prod_id = $input['product_id'];
          $qty     = (int)$input['quantity']; 
          
          $shipping_discount =GeneralSetting::first();
          
          $check_cart  = Cart::where('id',$cart_id)->first();
          if ($check_cart == "") 
          {
            return response()->json(array("status"=>"0","msg"=>"Invalid Cart ID."), 200);
          }

          $get_prod = Product::where('id',$prod_id)->where('is_show',1)->where('stock','>',$qty)->first();

          if ($get_prod == "") 
          {
            return response()->json(array("status"=>"0","msg"=>"No Product Found."), 200);
          }

          if ($qty <= 0) 
          {
            return response()->json(array("status"=>"0","msg"=>"Kindly Enter Valid Quantity."));
          }

          CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->update(array(
                                                  'product_price'     => $get_prod->sale_price,
                                                  'product_quantity'  => $qty,
                                                  'product_subtotal'  => $get_prod->sale_price*$qty,
                                              ));
       
          $cart_total_price = CartDetail::where('cart_id',$cart_id)->sum('product_subtotal');


           Cart::where('id',$cart_id)->update(array(
                                                  "total_price" => $cart_total_price,
                                              ));


           $all_total = ($cart_total_price + $shipping_discount->shipping_fee) - ($cart_total_price * ($shipping_discount->discount/100));


           $result = array(
                            "product_quantity"=>$qty,
                            "product_subtotal"=>$get_prod->sale_price*$qty,
                            "shipping_fee"    =>$shipping_discount->shipping_fee,
                            "discount"        =>$shipping_discount->discount,
                            "subtotal"        =>$cart_total_price,
                            'items'           =>$check_cart->total_item,
                            'grand_total'     =>$all_total
                    );

          return response()->json(array("status"=>"1","msg"=>"Item Quantity Updated","result"=>$result));


        
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function CartDetails(Request $request)
    {
        try 
        { 
          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
          $cart_id = empty(session("cart_id"))?0:session("cart_id");

          $cart_detail = CartDetail::where('cart_id',$cart_id)->get();

          if (count($cart_detail) == 0) 
          {
            ?>
            <br><center><p>Cart is Empty</p></center>
            <?php
          }
          else
          {
            ?>
            <div style="overflow-y: auto; max-height: 300px; overflow-x: hidden;">
            <?php
            foreach ($cart_detail as $key) 
            {
              $get_prod = Product::where('id',$key['product_id'])->where('is_show',1)->where('stock','>',0)->first();
              if ($get_prod != "") 
              {
                $key['product_name']  = $get_prod->name;
                $key['product_price'] = $get_prod->sale_price;
                $key['product_image'] = $get_prod->image;
                $key['product_subtotal'] = $get_prod->sale_price*$key['product_quantity'];


              }
              else
              {
                $key['product_name']  = "";
                $key['product_price'] = "";
                $key['product_image'] = "";
                $key['product_subtotal'] = "";
              }

              ?>
              <a class="dropdown-item" href="javascript:void(0)" style="border-bottom: solid #4cdac9 1px;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img style="width:70px; height: 70px;"  class="card-img-top "
                                            src="<?php echo config('app.img_url').$key['product_image'] ?>" alt="Card image cap" >
                                        </div>
                                        <div class="col-md-8 popover-right">
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text"><?php echo $key['product_name'] ?> </li>
                                                </ul>
                                            </div>
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Qty: <?php echo $key['product_quantity'] ?> </li>
                                                    <b> <li class="popover-card-text" style="float: right; color: #3DC4B4;;"><?php echo $key['product_subtotal'] ?> PKR </li></b>
                                                    <div class="clear-both"></div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </a> 
                               
              <?php
            }

            ?>
            </div>
            <hr>
            <div class="row popover-btns">
                                    <ul>
                                        <li> 
                                            <a href="<?php echo route('checkout') ?>"><button class="log-reg-btn cart-bottom-btns">Checkout</button></a> 
                                            <a href="<?php echo route('cart') ?>" class="popover-link">View Cart</a> 
                                            <span style="margin-left: 31px;"> Total: &nbsp; <span style="color: #3DC4B4; " ><?php echo $cart_detail->sum('product_subtotal') ?> PKR</span></span>
                                            <div class="clear-both"></div>
                                        </li>
                                    </ul>
                            </div> 
            <?php
          }        
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function DeleteCartItem(Request $request)
    {
        try 
        { 

          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);
         
          $input = $request->all();
         

          $cart_id = $input['cart_id'];
          $prod_id = $input['product_id'];
          
          $shipping_discount =GeneralSetting::first();
         
          
          if (CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->delete()) 
          {
              $new_cart_detail = CartDetail::where('cart_id',$cart_id)->get();

              Cart::where('id',$cart_id)->update(array('total_price'=>$new_cart_detail->sum('product_subtotal'),"total_item"=>count($new_cart_detail)));

              $cart_total_price =$new_cart_detail->sum('product_subtotal');

            $all_total = ($cart_total_price + $shipping_discount->shipping_fee) - ($cart_total_price * ($shipping_discount->discount/100));


            $result = array(
                            "shipping_fee"    =>$shipping_discount->shipping_fee,
                            "discount"        =>$shipping_discount->discount,
                            "items"=>count($new_cart_detail),
                            "subtotal"=>$cart_total_price,
                            "grand_total"=>$all_total);


            return response()->json(array("status"=>"1","msg"=>"Item Deleted.","result"=>$result));


          }
          else
          {
            return response()->json(array("status"=>"0","msg"=>"Failed to Delete Item."));
          }


        
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
    