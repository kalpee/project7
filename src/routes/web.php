<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get("/", function () {
    return Inertia::render("Welcome", [
        "canLogin" => Route::has("login"),
        "canRegister" => Route::has("register"),
        "laravelVersion" => Application::VERSION,
        "phpVersion" => PHP_VERSION,
    ]);
});

Route::get("/home", function () {
    return Inertia::render("Home");
})
    ->middleware(["auth", "verified"])
    ->name("home");

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit"
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update"
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy"
    );
});

Route::middleware("auth")->group(function () {
    Route::get("/stocks/index", [StockController::class, "index"])->name(
        "stocks.index"
    );

    Route::get("/stocks/create", [StockController::class, "create"])->name(
        "stocks.create"
    );

    Route::post("/stocks/store", [StockController::class, "store"])->name(
        "stocks.store"
    );

    Route::get("/carts/index", function () {
        return Inertia::render("Cart/Index");
    });

    Route::post("/carts/index", [CartController::class, "add"]);
    Route::post("/delete", [CartController::class, "delete"]);

    Route::get("/orders/index", [OrderController::class, "index"])->name(
        "orders.index"
    );
    Route::delete("/orders/{id}", [OrderController::class, "destroy"])->name(
        "orders.destroy"
    );

    // Stripeの処理
    Route::post("/payment", [PaymentController::class, "payment"])->name(
        "payment"
    );

    // 決済完了ページ
    Route::get("/complete", function () {
        return Inertia::render("Payment/Complete");
    })->name("complete");
});

require __DIR__ . "/auth.php";
