<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\FavoriteProduct;
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
                                  ->limit(50)
                                  ->get();

            $featured_product  = Product::where('is_featured',1)
                                        ->where('stock','>',0)
                                        ->where('is_show',1)
                                        ->limit(20)
                                        ->get();

            $product_ids = OrderDetails::select('product_id', DB::raw('COUNT(id) as count'))
                                       ->groupBy('product_id')
                                       ->orderBy(DB::raw('COUNT(id)'), 'DESC')
                                        ->limit(20)
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
              $key['cart_count'] = (int)(CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
            }

            foreach ($best_selling_products as $key) 
            {
              $key['cart_count'] = (int)(CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
            }

            foreach ($all_product as $key) 
            {
              $key['cart_count'] = (int)(CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
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
                                  ->limit(50)
                                  ->get();
              }
              else
              {
                   $all_product = Product::where('stock','>',0)
                                  ->where('is_show',1)
                                  ->where('name','like','%'.$search.'%')
                                  ->limit(50)
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
                                  ->limit(50)
                                  ->get();
              }
              else
              {
                   $all_product = Product::where('stock','>',0)
                                  ->where('is_show',1)
                                  ->where('name','like','%'.$search.'%')
                                  ->where('category_id',$selected_cate_id)
                                  ->limit(50)
                                  ->get();
              }
            }

          

         



            $featured_product  = Product::where('is_featured',1)
                                        ->where('stock','>',0)
                                        ->where('is_show',1)
                                        ->limit(20)
                                        ->get();

            $product_ids = OrderDetails::select('product_id', DB::raw('COUNT(id) as count'))
                                       ->groupBy('product_id')
                                       ->orderBy(DB::raw('COUNT(id)'), 'DESC')
                                       ->limit(20)
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
              $key['cart_count'] = (int)(CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
            }

            foreach ($best_selling_products as $key) 
            {
              $key['cart_count'] = (int)(CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
            }

            foreach ($all_product as $key) 
            {
              $key['cart_count'] = (int)(CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
            }


            $featured_product = $featured_product->toArray();

           
            return view('product',compact('category','all_product','featured_product','best_selling_products','selected_cate_id','search'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }

   
    public function ProductDetail(Request $request,$prod_id)
    {
        try 
        {   
            $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
            $cart_id = empty(session("cart_id"))?0:session("cart_id");

            $product = Product::where('stock','>',0)
                                  ->where('is_show',1)
                                  ->where('id',$prod_id)
                                  ->first();

                                  
            $product['cart_count'] = (int)(CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->first()->product_quantity;
             $product['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$prod_id)->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$prod_id)->first()->id;


            return view('product_detail',compact('product'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }



    public function MarkItemFavorite(Request $request,$prod_id)
    {
        try 
        {   
            $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");

            if (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$prod_id)->count() == 0) 
            {
              FavoriteProduct::insert(array(
                                            'customer_id' => $customer_id,
                                            'product_id'  => $prod_id,
                                            'created_at'  => date('Y-m-d H:i:s'),
                                            'updated_at'  => date('Y-m-d H:i:s'),
                                      ));

              $toggle = 1; 
            }
            else
            {
              FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$prod_id)->delete();
              $toggle = 0;
            }

            return array("status"=>"1","msg"=>"Success","toggle"=>$toggle);

           
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function FavoriteProduct(Request $request)
    {
        try 
        {   

            $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");
            $cart_id = empty(session("cart_id"))?0:session("cart_id");

            
            $customer_info = Customer::where('id',$customer_id)->first();


            if ($customer_info == "") 
            {
              if($request->ajax()) 
              {
                return response()->json(['status'=>"0",'msg' => 'Kindly login first to view your favorite items'],401);
              }
              else
              {
                return redirect()->route('login-form')->with('failed','Kindly login first to view your favorite items');
              }          
            }

            $ids = FavoriteProduct::where('customer_id',$customer_id)->pluck('product_id');

            $fav_product = Product::where('stock','>',0)
                                  ->where('is_show',1)
                                  ->whereIn('id',$ids)
                                  ->get();


            foreach ($fav_product as $key) 
            {
              $key['cart_count'] = (int)(CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
            }


           
            return view('favorite_product',compact('fav_product'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


}
    