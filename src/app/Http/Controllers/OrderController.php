<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $orders = Order::with("stock")
            ->where("user_id", $user_id)
            ->get();

        return Inertia::render("Orders/Index", ["orders" => $orders]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // オーダーが現在のユーザーに属していることを確認
        if (Auth::id() !== $order->user_id) {
            return redirect()
                ->back()
                ->with("error", "不正な操作です。");
        }

        $order->delete();

        return redirect()
            ->route("orders.index")
            ->with("message", "注文履歴が削除されました。");
    }
}
