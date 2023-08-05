<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index(Cart $cart)
    {
        $data = $cart->show();
        return Inertia::render("Carts/Index", $data);
    }

    public function delete(Request $request, Cart $cart)
    {
        $stock_id = $request->stock_id;
        $message = $cart->remove($stock_id);

        $data = $cart->show();

        return Inertia::render(
            "Carts/Index",
            array_merge($data, ["message" => $message])
        );
    }

    public function add(Request $request, Cart $cart)
    {
        //カートに追加の処理
        $stock_id = $request->stock_id;
        $message = $cart->add($stock_id);

        //追加後の情報を取得
        $data = $cart->show();

        return Inertia::render(
            "Carts/Index",
            array_merge($data, ["message" => $message])
        );
    }
}
