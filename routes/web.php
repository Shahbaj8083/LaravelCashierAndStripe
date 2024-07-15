<?php

use App\Http\Controllers\ClientController;
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
Route::get('/checkout', [ClientController::class, 'checkout']);
Route::get('/register', [ClientController::class, 'register']);
Route::get('/login', [ClientController::class, 'login']);
Route::get('/logout', [ClientController::class, 'logout']);
Route::post('/registerUser', [ClientController::class, 'registerUser']);
Route::post('/loginUser', [ClientController::class, 'loginUser']);
