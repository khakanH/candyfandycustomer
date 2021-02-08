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
