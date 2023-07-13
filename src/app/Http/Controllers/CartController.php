<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function index(Cart $cart)
    {
        $data = $cart->show();
        return view('carts.index', $data);
    }

    public function delete(Request $request, Cart $cart)
    {

        $stock_id = $request->stock_id;
        $message = $cart->remove($stock_id);

        $data = $cart->show();

        return view('carts.index', $data)->with('message', $message);
    }

    public function add(Request $request, Cart $cart)
    {
        //カートに追加の処理
        $stock_id = $request->stock_id;
        $message = $cart->add($stock_id);

        //追加後の情報を取得
        $data = $cart->show();

        return view('/carts/index', $data)->with('message', $message);
    }
}
