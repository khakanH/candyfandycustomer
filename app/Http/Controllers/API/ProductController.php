<?php
namespace App\Http\Controllers\API;

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

use App\Helpers\ApiHelper;


class ProductController extends Controller
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

            $cart_id = Cart::where('customer_id',$customer_id)->first()->id;


            $select_object = ['id','name','sale_price','image','description'];



            $all_product = Product::select($select_object)->where('stock','>',0)
                                  ->where('is_show',1)
                                  ->limit(50)
                                  ->get();

            $featured_product  = Product::select($select_object)->where('is_featured',1)
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
                $best_selling_products[] = Product::select($select_object)->where('id',$key)
                                         ->where('stock','>',0)
                                         ->where('is_show',1)
                                         ->first();
              }

            $best_selling_products = array_filter($best_selling_products);


            foreach ($featured_product as $key) 
            {
              $key['description'] = (string)$key['description'];
              $key['image'] = config('app.img_url').$key['image'];
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:(int)CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
            }

            foreach ($best_selling_products as $key) 
            {
              $key['description'] = (string)$key['description'];
              $key['image'] = config('app.img_url').$key['image'];

              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:(int)CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
            }

            foreach ($all_product as $key) 
            {
              $key['description'] = (string)$key['description'];
              $key['image'] = config('app.img_url').$key['image'];
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:(int)CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
            }


            $featured_product = $featured_product->toArray();


            $result =array(
                            "featured_product" => $featured_product,
                            "best_seller"      => $best_selling_products,
                            "more_to_love"     => $all_product,
            );
            
            return response()->json(array("status"=>"1","msg"=>"Product List","result"=>$result), 200);

           
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function SearchProduct(Request $request)
    {
        try 
        {   
          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);

          $cart_id = Cart::where('customer_id',$customer_id)->first()->id;

          $input = $request->all();
          
          $select_object = ['id','name','sale_price','image','description'];


          $all_product = Product::select($select_object)->where('stock','>',0)
                                  ->where('is_show',1)
                                  ->where('name','like','%'.$input['search_text'].'%')
                                  ->limit(50)
                                  ->get();




            

            foreach ($all_product as $key) 
            {

              $key['description'] = (string)$key['description'];
              $key['image'] = config('app.img_url').$key['image'];
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:(int)CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;

            }

            if (count($all_product) > 0) 
            {
            return response()->json(array("status"=>"1","msg"=>"Product List","result"=>$all_product), 200);
            }
            else
            {
            return response()->json(array("status"=>"0","msg"=>"No Product Found."), 200);

            }
           
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }

   
    public function ProductDetail(Request $request)
    {
        try 
        {   
          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);

          $cart_id = Cart::where('customer_id',$customer_id)->first()->id;

          $input = $request->all();
          
          $prod_id = $input['product_id'];

            $product = Product::select(['id','name','sale_price','image','description'])->where('stock','>',0)
                                  ->where('is_show',1)
                                  ->where('id',$prod_id)
                                  ->first();

            if ($product == "") 
            {
              return response()->json(array("status"=>"0","msg"=>"No Product Found."), 200);
            }

            
            $product['description'] = (string)$product['description'];
            $product['image'] = config('app.img_url').$product['image'];
            $product['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->first() == "")?0:(int)CartDetail::where('cart_id',$cart_id)->where('product_id',$prod_id)->first()->product_quantity;
             $product['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$prod_id)->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$prod_id)->first()->id;


            return response()->json(array("status"=>"1","msg"=>"Product Details.","result"=>$product), 200);
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }



    public function MarkItemFavorite(Request $request)
    {
        try 
        {   
          
          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);

          $input = $request->all();

          $prod_id = $input['product_id'];

            if (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$prod_id)->count() == 0) 
            {
              FavoriteProduct::insert(array(
                                            'customer_id' => $customer_id,
                                            'product_id'  => $prod_id,
                                            'created_at'  => date('Y-m-d H:i:s'),
                                            'updated_at'  => date('Y-m-d H:i:s'),
                                      ));

              $toggle = 1; 
              $msg = "Product Marked Favorite Successfully.";
            }
            else
            {
              FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$prod_id)->delete();
              $toggle = 0;
              $msg = "Product Marked Unfavorite Successfully.";
            }

            return response()->json(array("status"=>"1","msg"=>$msg,"result"=>$toggle), 200);
           
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

          $customer_id = $this->common_helper->getCustomerID($request);
          $cust_info = $this->checkCustomerAvailbility($customer_id);

          $input = $request->all();

          $cart_id = $input['cart_id'];
            

            $ids = FavoriteProduct::where('customer_id',$customer_id)->pluck('product_id');

            $fav_product = Product::select(['id','name','sale_price','image','description'])->where('stock','>',0)
                                  ->where('is_show',1)
                                  ->whereIn('id',$ids)
                                  ->get();


            foreach ($fav_product as $key) 
            {
              $key['description'] = (string)$key['description'];
              $key['image'] = config('app.img_url').$key['image'];
              $key['cart_count'] = (CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first() == "")?0:(int)CartDetail::where('cart_id',$cart_id)->where('product_id',$key['id'])->first()->product_quantity;
               $key['favorite_id'] = (FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first() =="")?0:FavoriteProduct::where('customer_id',$customer_id)->where('product_id',$key['id'])->first()->id;
              
            }


           
            return response()->json(array("status"=>"1","msg"=>"Favorite Product List.","result"=>$fav_product), 200);
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
    