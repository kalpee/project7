<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use App\Models\Cart;
use App\Mail\Thanks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Exception;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function payment(Request $request, Cart $cart)
    {
        try {
            // Stripeの処理を行う
            \Stripe\Stripe::setApiKey(config("services.stripe.secret"));

            $customer = Customer::create([
                "email" => $request->stripeEmail,
                "source" => $request->stripeToken,
            ]);
            $totalAmount = $request->input("total_amount");

            $charge = Charge::create([
                "customer" => $customer->id,
                "amount" => $totalAmount,
                "currency" => "jpy",
            ]);

            // Stripeの処理が成功したらメールを送信する
            $user = Auth::user();
            $mail_data["user"] = $user->name;
            $mail_data["checkout_items"] = $cart->checkout();
            Mail::to($user->email)->send(new Thanks($mail_data));

            return Inertia::location(route("complete"));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function complete()
    {
        return Inertia::render("Complete");
    }
}
