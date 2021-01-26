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

          CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->update(array(
                                                  'product_price'     => $get_prod->sale_price,
                                                  'product_quantity'  => $qty,
                                                  'product_subtotal'  => $get_prod->sale_price*$qty,
                                              ));
       
          $cart_total_price = CartDetail::where('cart_id',$cart_id)->sum('product_subtotal');


           Cart::where('id',$cart_id)->update(array(
                                                  "total_price" => $cart_total_price,
                                              ));


          return array("status"=>"1","msg"=>"Item Quantity Updated","product_count"=>$qty);


        
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }

}
    