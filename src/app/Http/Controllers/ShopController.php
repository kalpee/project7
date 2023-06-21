<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stock; //追加

use App\Models\Cart; //追加

use Illuminate\Support\Facades\Auth;

use App\Models\User; //追加
use App\Models\OrderHistory;
use Illuminate\Support\Facades\Mail; //追記
use App\Mail\Thanks; //追記


class ShopController extends Controller
{
    public function index() //追加
    {
        $stocks = Stock::Paginate(6); //Eloquantで検索
        return view('shop', compact('stocks'));
    }

    public function myCart(Cart $cart)
    {
        $data = $cart->showCart();
        return view('mycart', $data);
    }

    public function addMycart(Request $request, Cart $cart)
    {
        //カートに追加の処理
        $stock_id = $request->stock_id;
        $message = $cart->addCart($stock_id);

        //追加後の情報を取得
        $data = $cart->showCart();

        return view('mycart', $data)->with('message', $message); //追記
    }

    public function deleteCart(Request $request, Cart $cart)
    {

        $stock_id = $request->stock_id;
        $message = $cart->deleteCart($stock_id);

        $data = $cart->showCart();

        return view('mycart', $data)->with('message', $message); //追記
    }





    public function orderHistory()
    {
        $user_id = Auth::id();
        $orders = OrderHistory::where('user_id', $user_id)->get();

        return view('order_history', ['orders' => $orders]);
    }
}
