<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WebhookController;
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

# Public routes
Route::get('/', [ClientController::class, 'login']);
Route::get('/register', [ClientController::class, 'register']);
Route::get('/login', [ClientController::class, 'login'])->name('login');
Route::post('/registerUser', [ClientController::class, 'registerUser']);
Route::post('/loginUser', [ClientController::class, 'loginUser']);

# Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'index']);
    Route::get('/cart', [ClientController::class, 'cart']);
    Route::get('/single/{id}', [ClientController::class, 'singleProduct']);
    Route::post('/checkout', [ClientController::class, 'checkout']);
    Route::get('/logout', [ClientController::class, 'logout']);
    Route::post('/addToCart', [ClientController::class, 'addToCart']);
    Route::get('/deleteCartItem/{id}', [ClientController::class, 'deleteCartItem']);
    Route::post('/updateCart', [ClientController::class, 'updateCart']);

    Route::post('/plans/store', [SubscriptionController::class, 'savePlan'])->name('plans.store');
    Route::get('plans/create', [SubscriptionController::class, 'showPlanForm'])->name('plans.create');
    Route::get('/plans', [SubscriptionController::class, 'allPlans'])->name('plans.all');
    Route::get('plans/checkout/{planId}', [SubscriptionController::class, 'checkout'])->name('plans.checkout');
    Route::post('plans/process', [SubscriptionController::class, 'processPlan'])->name('plan.process');
    Route::get('subscriptions/all', [SubscriptionController::class, 'allSubscriptions'])->name('subscriptions.all');
    Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);

    Route::controller(StripePaymentController::class)->group(function () {
        Route::get('stripe', 'stripe');
        Route::post('stripe', 'stripePost')->name('stripe.post');
        Route::post('/create-invoice')->name('create.invoice');
    });
});
