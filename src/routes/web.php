<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShopController;

use App\Http\Controllers\StockController;

use App\Http\Controllers\PaymentsController;

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
    Route::get('/index', [ShopController::class, 'index'])->name('index');

    Route::get('/mycart', [ShopController::class, 'myCart']);

    Route::post('/mycart', [ShopController::class, 'addMycart']);

    Route::post('/cartdelete', [ShopController::class, 'deleteCart']);

    Route::get('/order_history', [ShopController::class, 'orderHistory'])->name('order_history');



    // Stripeの処理
    Route::post('/payment', [PaymentsController::class, 'payment'])->name('payment');

    // 決済完了ページ
    Route::get('/complete', [PaymentsController::class, 'complete'])->name('complete');
});


// 新たに商品追加のルートを追加
Route::get('/create', [StockController::class, 'create']);
Route::post('/store', [StockController::class, 'store']);



require __DIR__ . '/auth.php';
