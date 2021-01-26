<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
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
Route::get('add-to-cart/{id}',[CartController::class, 'AddToCart'])->name('add-to-cart');
Route::get('change-cart-item-qty/{id}/{val}',[CartController::class, 'ChangeCartItemQty'])->name('change-cart-item-qty');


Route::get('/product',[ProductController::class, 'Index'])->name('product');