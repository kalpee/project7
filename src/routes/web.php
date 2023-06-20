<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShopController;
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

Route::post('/checkout', [ShopController::class, 'checkout']);

Route::get('/order_history', [ShopController::class, 'orderHistory'])->name('order_history');

});
require __DIR__.'/auth.php';