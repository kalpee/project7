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

class PaymentController extends Controller
{

    public function payment(Request $request, Cart $cart)
    {
        try {
            // Stripeの処理を行う
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));
            $totalAmount = $request->input('total_amount');


            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => $totalAmount,
                'currency' => 'jpy'
            ));

            // Stripeの処理が成功したらメールを送信する
            $user = Auth::user();
            $mail_data['user'] = $user->name;
            $mail_data['checkout_items'] = $cart->checkoutCart();
            Mail::to($user->email)->send(new Thanks($mail_data));

            return redirect()->route('complete');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function complete()
    {
        return view('complete');
    }
}
