<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Mail\Thanks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

class CartController extends Controller
{
    public function index(Cart $cart)
    {
        $data = $cart->show();

        $message = session("message") ?? null;

        return Inertia::render("Carts/Index", [
            "carts" => $data,
            "message" => $message,
        ]);
    }

    public function delete($cartId, Request $request, Cart $cart)
    {
        $message = $cart->remove($cartId);

        $carts = $cart->show();

        return redirect()
            ->route("carts.index")
            ->with("message", $message);
    }

    public function add(Request $request, Cart $cart)
    {
        //カートに追加の処理
        $stock_id = $request->stock_id;
        $message = $cart->add($stock_id);

        //追加後の情報を取得
        $data = $cart->show();

        return redirect()
            ->route("carts.index")
            ->with("message", $message);
    }

    public function updateQuantity(Request $request, $cartId)
    {
        // 数量のバリデーション
        $request->validate([
            "quantity" => "required|integer|min:1",
        ]);

        // 対象のカートアイテムを取得
        $cartItem = Cart::find($cartId);

        // 該当ユーザーのカートアイテムであることの確認
        if (Auth::id() != $cartItem->user_id) {
            return redirect()
                ->route("carts.index")
                ->with("message", "カートの変更に失敗しました");
        }

        // 数量を更新
        $cartItem->quantity = $request->input("quantity");
        $cartItem->save();

        $cart = new Cart();
        $data = $cart->show()->toArray();

        return redirect()
            ->route("carts.index")
            ->with("message", "カートの個数を変更しました");
    }

    public function payment(Request $request, Cart $cart)
    {
        try {
            // Stripeの処理を行う
            Stripe::setApiKey(config("services.stripe.secret"));

            $user = Auth::user();

            $customer = Customer::create([
                "email" => $user->email,
            ]);

            $paymentMethodId = $request->paymentMethodId;
            PaymentMethod::retrieve($paymentMethodId)->attach([
                "customer" => $customer->id,
            ]);

            $totalAmount = $request->input("total_amount");

            $paymentIntent = PaymentIntent::create([
                "customer" => $customer->id,
                "amount" => $totalAmount,
                "currency" => "jpy",
                "payment_method" => $paymentMethodId,
                "confirm" => true,
            ]);

            // Stripeの処理が成功したらをDB更新する
            $checkoutResult = $cart->checkout();

            if ($checkoutResult !== true) {
                throw new \Exception($checkoutResult);
            }

            return redirect()->route("stocks.index");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
