<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stock; //追加

use App\Models\Cart; //追加

class ShopController extends Controller
{
    public function index() //追加
    {
        $stocks = Stock::Paginate(6); //Eloquantで検索
        return view('shop',compact('stocks'));
    }

    public function myCart() //追加
    {
        $carts = Cart::all();
        return view('mycart',compact('carts'));
    }
    
    public function addMycart(Request $request)
    {
        $user_id = Auth::id(); 
        $stock_id=$request->stock_id;
 
        $cart_add_info=Cart::firstOrCreate(['stock_id' => $stock_id,'user_id' => $user_id]);
 
        if($cart_add_info->wasRecentlyCreated){
            $message = 'カートに追加しました';
        }
        else{
            $message = 'カートに登録済みです';
        }
 
        $my_carts = Cart::where('user_id',$user_id)->get();
 
        return view('mycart',compact('my_carts' , 'message'));
 
    }

}