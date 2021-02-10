<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/test_notification', function(Request $request) {
     $content = array(
        "en" => 'From Web Server'
        );

        $fields = array(
          'app_id' => "4175ccac-b26f-4be2-9749-bb0cc5836b9a",
          'include_player_ids' => array($request->player_id),
          'data' => array("foo" => "bar"),
          'contents' => $content
      );

      $fields = json_encode($fields);
     

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

      $response = curl_exec($ch);
      if ($response === FALSE) 

            {

              \Log::info(curl_error($ch));
                   // die('FCM Send Error: ' . curl_error($ch));

            }
    

            curl_close($ch);
});



Route::post('login',[AccountController::class, 'Login']);
Route::post('signup',[AccountController::class, 'Signup']);



Route::middleware(['CheckToken'])->group(function () 
{
	Route::get('get_products',[ProductController::class, 'Index']);
	Route::post('search_products',[ProductController::class, 'SearchProduct']);
	Route::post('get_product_details',[ProductController::class, 'ProductDetail']);
	Route::post('mark_product_favorite',[ProductController::class, 'MarkItemFavorite']);
	Route::post('get_favorite_products',[ProductController::class, 'FavoriteProduct']);


	Route::post('get_cart',[CartController::class, 'Index']);
	Route::post('add_to_cart',[CartController::class, 'AddToCart']);
	Route::post('change_cart_item_quantity',[CartController::class, 'ChangeCartItemQty']);
	Route::post('delete_cart_item',[CartController::class, 'DeleteCartItem']);


	Route::post('checkout',[OrderController::class, 'Checkout']);
	Route::post('place_order',[OrderController::class, 'PlaceOrder']);
	


	Route::get('get_profile',[AccountController::class, 'Profile']);
	Route::post('get_order_details',[OrderController::class, 'OrderDetails']);



});
