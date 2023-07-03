<?php

/**参考サイトhttps://note.com/mukae9/n/n12cc13fd4f90 */

namespace App\Http\Controllers;


use App\Models\OrderHistory;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $orders = OrderHistory::where('user_id', $user_id)->get();

        return view('orders.index', ['orders' => $orders]);
    }
}
