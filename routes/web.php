<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SaleController as AdminSaleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\GeneralSettingController as AdminGeneralSettingController;


use App\Models\UserRole;
use App\Models\Modules;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/curl', function() {
  echo curl_init();
});

Route::get('/clear-cache', function() {
   \Artisan::call('cache:clear');
   \Artisan::call('config:cache');
   \Artisan::call('config:clear');
   \Artisan::call('view:clear');
   \Artisan::call('route:clear');
});




Route::get('/refresh', function(Request $request)
{
	$request->session()->flush(); 

});



Route::get('/about-us', function () {
	return view('aboutus');
})->name('about-us');

Route::get('/contact-us', function () {
	return view('contactus');
})->name('contact-us');

Route::get('/login-form', function () {
	return view('login');
})->name('login-form');

Route::get('/signup-form', function () {
	return view('signup');
})->name('signup-form');

Route::get('check-email-registration',[AccountController::class, 'CheckEmailRegistration'])->name('check-email-registration');
Route::post('signup',[AccountController::class, 'Signup'])->name('signup');
Route::post('login',[AccountController::class, 'Login'])->name('login');
Route::get('logout',[AccountController::class, 'Logout'])->name('logout');

Route::get('/', [HomeController::class, 'Index'])->name('home');

Route::get('cart', [CartController::class, 'Index'])->name('cart');
Route::get('add-to-cart/{id}',[CartController::class, 'AddToCart'])->name('add-to-cart');
Route::get('change-cart-item-qty/{id}/{val}',[CartController::class, 'ChangeCartItemQty'])->name('change-cart-item-qty');
Route::get('get-cart-details', [CartController::class, 'CartDetails'])->name('get-cart-details');
Route::get('delete-cart-item/{id}',[CartController::class, 'DeleteCartItem'])->name('delete-cart-item');



Route::get('product_list',[ProductController::class, 'Index'])->name('product_list');
Route::get('product-by-filter/{id}/{val}',[ProductController::class, 'ProductByFilter'])->name('product-by-filter');

Route::get('product-detail/{id}',[ProductController::class, 'ProductDetail'])->name('product-detail');
Route::get('mark-item-favorite/{id}',[ProductController::class, 'MarkItemFavorite'])->name('mark-item-favorite');


Route::get('checkout',[OrderController::class, 'Checkout'])->name('checkout');

Route::post('place-order',[OrderController::class, 'PlaceOrder'])->name('place-order');

Route::get('thankyou',function(){
	return view('thankyou');
})->name('thankyou');

Route::get('profile',[AccountController::class, 'Profile'])->name('profile');
Route::post('save-profile',[AccountController::class, 'SaveProfile'])->name('save-profile');

Route::get('favorite_products',[ProductController::class, 'FavoriteProduct'])->name('favorite_products');
Route::get('order_history',[OrderController::class, 'OrderHistory'])->name('order_history');
Route::get('get-order-details/{id}',[OrderController::class, 'OrderHistoryDetails'])->name('get-order-details');








//Admin Route
Route::prefix('admin')->group(function () {


	Route::get('/MB-Script',function(){

	$modules = Modules::get();
	foreach ($modules as $key) 
	{
		UserRole::insert(array(
				'user_type'	=> 0,
				'module_id'		=> $key['id'],
		));
	}
});



Route::get('/', function () {
    return view('admin.signin');
})->name('index')->middleware('AdminCheckLogin');


Route::post('signin', [AdminAccountController::class, 'Sigin'])->name('signin');

Route::get('signout', [AdminAccountController::class, 'SignOut'])->name('signout');



Route::middleware(['AdminLoginSession','AdminCheckUserRole'])->group(function () 
{	

Route::get('dashboard',[AdminDashboardController::class, 'Index'])->name('dashboard');


Route::get('category',[AdminInventoryController::class, 'CategoryList'])->name('category');
Route::post('add-update-category',[AdminInventoryController::class, 'AddUpdateCategory'])->name('add-update-category');
Route::get('get-category-list-AJAX',[AdminInventoryController::class, 'CategoryListAJAX'])->name('get-category-list-AJAX');
Route::get('change-category-availability/{id}/{val}',[AdminInventoryController::class, 'ChangeCategoryAvailability'])->name('change-category-availability');
Route::get('delete-category/{id}',[AdminInventoryController::class, 'DeleteCategory'])->name('delete-category');




Route::get('product',[AdminInventoryController::class, 'ProductList'])->name('product');
Route::post('add-update-product',[AdminInventoryController::class, 'AddUpdateProduct'])->name('add-update-product');
Route::get('get-product-list-AJAX',[AdminInventoryController::class, 'ProductListAJAX'])->name('get-product-list-AJAX');
Route::get('get-category-name-list/{id}',[AdminInventoryController::class, 'CategoryNameList'])->name('get-category-name-list');
Route::get('change-product-availability/{id}/{val}',[AdminInventoryController::class, 'ChangeProductAvailability'])->name('change-product-availability');
Route::get('delete-product/{id}',[AdminInventoryController::class, 'DeleteProduct'])->name('delete-product');



Route::get('order/{type}',[AdminOrderController::class, 'Index'])->name('order');
Route::get('get-new-order',[AdminOrderController::class, 'NewOrders'])->name('get-new-order');
Route::get('accept-order/{id}',[AdminOrderController::class, 'AcceptOrder'])->name('accept-order');
Route::get('reject-order/{id}',[AdminOrderController::class, 'RejectOrder'])->name('reject-order');
Route::get('complete-order/{id}',[AdminOrderController::class, 'CompleteOrder'])->name('complete-order');

Route::get('search-order/{val}',[AdminOrderController::class, 'SearchOrder'])->name('search-order');

Route::get('get-accepted-order',[AdminOrderController::class, 'AcceptedOrderList'])->name('get-accepted-order');
Route::get('get-completed-order',[AdminOrderController::class, 'CompletedOrderList'])->name('get-completed-order');
Route::get('get-rejected-order',[AdminOrderController::class, 'RejectedOrderList'])->name('get-rejected-order');



Route::get('sale',[AdminSaleController::class, 'Index'])->name('sale');


Route::get('user',[AdminUserController::class, 'Index'])->name('user');
Route::post('add-update-user',[AdminUserController::class, 'AddUpdateUser'])->name('add-update-user');
Route::get('get-user-type-name-list/{type}',[AdminUserController::class, 'UserTypeNameList'])->name('get-user-type-name-list');
Route::get('get-user-list-AJAX',[AdminUserController::class, 'UserListAJAX'])->name('get-user-list-AJAX');
Route::get('delete-user/{id}',[AdminUserController::class, 'DeleteUser'])->name('delete-user');
Route::get('block-unblock-user/{id}',[AdminUserController::class, 'BlockUnblockUser'])->name('block-unblock-user');
Route::get('user-type',[AdminUserController::class, 'UserType'])->name('user-type');
Route::get('delete-user-type/{id}',[AdminUserController::class, 'DeleteUserType'])->name('delete-user-type');
Route::post('add-update-user-type',[AdminUserController::class, 'AddUpdateUserType'])->name('add-update-user-type');
Route::get('get-user-type-list-AJAX',[AdminUserController::class, 'UserTypeListAJAX'])->name('get-user-type-list-AJAX');
Route::get('user-roles',[AdminUserController::class, 'UserRoles'])->name('user-roles');
Route::post('save-roles',[AdminUserController::class,'SaveRoles'])->name('save-roles');
Route::get('get-user-roles-AJAX/{id}',[AdminUserController::class,'UserRolesAJAX'])->name('get-user-roles-AJAX');












Route::get('general-setting',[AdminGeneralSettingController::class, 'Index'])->name('general-setting');
Route::post('save-general-setting',[AdminGeneralSettingController::class, 'SaveGeneralSetting'])->name('save-general-setting');
Route::get('payment-method',[AdminGeneralSettingController::class, 'PaymentMethod'])->name('payment-method');
Route::post('add-update-payment-method',[AdminGeneralSettingController::class, 'AddUpdatePaymentMethod'])->name('add-update-payment-method');
Route::get('change-payment-method-availability/{id}/{val}',[AdminGeneralSettingController::class, 'ChangePaymentAvailability'])->name('change-payment-method-availability');
Route::get('get-payment-method-list-AJAX',[AdminGeneralSettingController::class, 'PaymentMethodListAJAX'])->name('get-payment-method-list-AJAX');
});


});