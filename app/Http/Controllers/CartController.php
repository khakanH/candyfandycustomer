<?php
namespace App\Http\Controllers;

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
use File;
use DB;

class CartController extends Controller
{


    public function __construct(Request $request)
    {

    }

     public function Index(Request $request)
    {
        try 
        { 

          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
          $cart_id = empty(session("cart_id"))?0:session("cart_id");


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
          // dump($cart_detail);
          // exit();
          return view('cart',compact('cart','cart_detail'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }

    public function AddToCart(Request $request,$prod_id)
    {
        try 
        {  
          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
          $cart_id = empty(session("cart_id"))?0:session("cart_id");

          $get_prod = Product::where('id',$prod_id)->where('is_show',1)->where('stock','>',0)->first();

          if ($get_prod == "") 
          {
            return array("status"=>"0","msg"=>"Product Not Found.");
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
            $request->session()->put("cart_id",$cart_id);

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


         }
          
          

          $product_count    = CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->first()->product_quantity;
          $total_item_count = Cart::where('id',$cart_id)->first()->total_item;

          $request->session()->put("cart_total_item",$total_item_count);

          return array("status"=>"1","msg"=>"Item Added.","data"=>array("product_count"=>$product_count,"total_item_count"=>$total_item_count));


        
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function ChangeCartItemQty(Request $request,$prod_id,$qty)
    {
        try 
        { 
          $qty = (int)$qty; 

          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
          $cart_id = empty(session("cart_id"))?0:session("cart_id");

          $get_prod = Product::where('id',$prod_id)->where('is_show',1)->where('stock','>',$qty)->first();

          if ($get_prod == "") 
          {
            return array("status"=>"0","msg"=>"Product Not Found.");
          }

          if ($qty <= 0) 
          {
            return array("status"=>"0","msg"=>"Kindly enter valid quantity.");
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


          return array("status"=>"1","msg"=>"Item Quantity Updated","product_count"=>$qty,"cart_total_price"=>$cart_total_price,"cart_item_subtotal"=>$get_prod->sale_price*$qty);


        
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


    public function DeleteCartItem(Request $request,$prod_id)
    {
        try 
        { 

          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
          $cart_id = empty(session("cart_id"))?0:session("cart_id");

          
          if (CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->delete()) 
          {
              $new_cart_detail = CartDetail::where('cart_id',$cart_id)->get();

              Cart::where('id',$cart_id)->update(array('total_price'=>$new_cart_detail->sum('product_subtotal'),"total_item"=>count($new_cart_detail)));

              $request->session()->put("cart_total_item",count($new_cart_detail));

          return array("status"=>"1","msg"=>"Item Deleted.","total_item_count"=>count($new_cart_detail),"cart_total_price"=>$new_cart_detail->sum('product_subtotal'));


          }
          else
          {
             return array("status"=>"0","msg"=>"Failed to Delete Item.");
          }


        
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }
}
    