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

class ProductController extends Controller
{


    public function __construct(Request $request)
    {

    }


    public function Index(Request $request)
    {
        try 
        {   
            $selected_cate_id = 0;  
            $search = '';  

            $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
            $cart_id = empty(session("cart_id"))?0:session("cart_id");

            $category          = Category::where('is_show',1)->get()->toArray();

            $all_product = Product::where('stock','>',0)
                                  ->where('is_show',1)
                                  ->get();

            $featured_product  = Product::where('is_featured',1)
                                        ->where('stock','>',0)
                                        ->where('is_show',1)
                                        ->get();

            $product_ids = OrderDetails::select('product_id', DB::raw('COUNT(id) as count'))
                                       ->groupBy('product_id')
                                       ->orderBy(DB::raw('COUNT(id)'), 'DESC')
                                       ->pluck('product_id');

            $best_selling_products = array();
            foreach ($product_ids as $key) 
              {
                $best_selling_products[] = Product::where('id',$key)
                                         ->where('stock','>',0)
                                         ->where('is_show',1)
                                         ->first();
              }

            $best_selling_products = array_filter($best_selling_products);


            foreach ($featured_product as $key) 
            {
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
            }

            foreach ($best_selling_products as $key) 
            {
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
            }

            foreach ($all_product as $key) 
            {
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
            }


            $featured_product = $featured_product->toArray();

           
            return view('product',compact('category','all_product','featured_product','best_selling_products','selected_cate_id','search'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function ProductByFilter(Request $request,$selected_cate_id,$search)
    {
        try 
        {   
            $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
            $cart_id = empty(session("cart_id"))?0:session("cart_id");

            $category          = Category::where('is_show',1)->get()->toArray();


            if (empty($selected_cate_id)) 
            {
              if (empty($search)) 
              {
                $all_product = Product::where('stock','>',0)
                                  ->where('is_show',1)
                                  ->get();
              }
              else
              {
                   $all_product = Product::where('stock','>',0)
                                  ->where('is_show',1)
                                  ->where('name','like','%'.$search.'%')
                                  ->get();
              }
            }
            else
            {
              if (empty($search)) 
              {
                $all_product = Product::where('stock','>',0)
                                  ->where('is_show',1)
                                  ->where('category_id',$selected_cate_id)
                                  ->get();
              }
              else
              {
                   $all_product = Product::where('stock','>',0)
                                  ->where('is_show',1)
                                  ->where('name','like','%'.$search.'%')
                                  ->where('category_id',$selected_cate_id)
                                  ->get();
              }
            }

          

         



            $featured_product  = Product::where('is_featured',1)
                                        ->where('stock','>',0)
                                        ->where('is_show',1)
                                        ->get();

            $product_ids = OrderDetails::select('product_id', DB::raw('COUNT(id) as count'))
                                       ->groupBy('product_id')
                                       ->orderBy(DB::raw('COUNT(id)'), 'DESC')
                                       ->pluck('product_id');

            $best_selling_products = array();
            foreach ($product_ids as $key) 
              {
                $best_selling_products[] = Product::where('id',$key)
                                         ->where('stock','>',0)
                                         ->where('is_show',1)
                                         ->first();
              }

            $best_selling_products = array_filter($best_selling_products);


            foreach ($featured_product as $key) 
            {
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
            }

            foreach ($best_selling_products as $key) 
            {
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
            }

            foreach ($all_product as $key) 
            {
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
            }


            $featured_product = $featured_product->toArray();

           
            return view('product',compact('category','all_product','featured_product','best_selling_products','selected_cate_id','search'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }

   


}
    