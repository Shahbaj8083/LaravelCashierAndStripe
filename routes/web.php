<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ClientController::class, 'login']);
// Route::get('/', [ClientController::class, 'index']);
Route::get('/dashboard', [ClientController::class, 'index']);
Route::get('/shop', [ClientController::class, 'shop']);
Route::get('/cart', [ClientController::class, 'cart']);
Route::get('/single/{id}', [ClientController::class, 'singleProduct']);
Route::post('/checkout', [ClientController::class, 'checkout']);
Route::get('/register', [ClientController::class, 'register']);
Route::get('/login', [ClientController::class, 'login']);
Route::get('/logout', [ClientController::class, 'logout']);
Route::post('/registerUser', [ClientController::class, 'registerUser']);
Route::post('/loginUser', [ClientController::class, 'loginUser']);
Route::post('/addToCart', [ClientController::class, 'addToCart']);
Route::get('/deleteCartItem/{id}', [ClientController::class, 'deleteCartItem']);
Route::post('/updateCart', [ClientController::class, 'updateCart']);
Route::get('/plans/create', [ClientController::class, 'createPlan']);
Route::post('/plans/store', [SubscriptionController::class, 'savePlan'])->name('plans.store');


Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
    Route::post('/create-invoice')->name('create.invoice');
});
