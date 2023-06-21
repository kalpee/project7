<?php

namespace App\Http\Controllers;

use App\Mail\Thanks;
use App\Models\Stock;
use App\Models\Cart;
use App\Models\User;
use App\Models\OrderHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ShopController extends Controller
{
    public function index()
    {
        $stocks = Stock::Paginate(6); //Eloquantで検索
        return view("shop", compact("stocks"));
    }

    public function myCart(Cart $cart)
    {
        $data = $cart->showCart();
        return view("mycart", $data);
    }

    public function addMycart(Request $request, Cart $cart)
    {
        // カートに追加の処理
        $stock_id = $request->stock_id;
        $message = $cart->addCart($stock_id);

        // カートに追加後の情報を取得
        $data = $cart->showCart();

        return view("mycart", $data)->with("message", $message);
    }

    public function deleteCart(Request $request, Cart $cart)
    {
        $stock_id = $request->stock_id;
        $message = $cart->deleteCart($stock_id);

        $data = $cart->showCart();

        return view("mycart", $data)->with("message", $message);
    }

    public function orderHistory()
    {
        $user_id = Auth::id();
        $orders = OrderHistory::where("user_id", $user_id)->get();

        return view("order_history", ["orders" => $orders]);
    }
}
