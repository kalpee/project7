<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PaymentController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::group(['middleware' => ['auth']], function () {

    Route::get('/stocks/index', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stocks/create', [StockController::class, 'create']);
    Route::post('/store', [StockController::class, 'store']);

    Route::get('/carts/index', [CartController::class, 'index']);
    Route::post('/carts/index', [CartController::class, 'add']);
    Route::post('/delete', [CartController::class, 'delete']);

    Route::get('/orders/index', [OrderController::class, 'index'])->name('order.index');

    // Stripeの処理
    Route::post('/payment', [PaymentController::class, 'payment'])->name('payment');

    // 決済完了ページ
    Route::get('/complete', [PaymentController::class, 'complete'])->name('complete');
});


require __DIR__ . '/auth.php';
