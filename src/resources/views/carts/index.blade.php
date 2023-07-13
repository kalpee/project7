<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container-fluid">
        <div class="">
            <div class="mx-auto" style="max-width:1200px">
                <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">カートの中身</h1>
                <div class="">
                    <p class="text-center">{{ $message??'' }}</p><br>
                    <div class="d-flex flex-row flex-wrap">
                        @if($my_carts->isNotEmpty())
                        <div class="container">
                            <div class="row">
                                @foreach($my_carts as $my_cart)
                                <div class="col-sm-4">
                                    <div class="mycart_box">
                                        {{$my_cart->stock->name}} <br>
                                        {{ number_format($my_cart->stock->fee)}}円 <br>
                                        <img src="{{ asset('storage/' . $my_cart->stock->imgpath) }}" alt="" class="incart">
                                        <br>
                                        <form action="/delete" method="post">
                                            @csrf
                                            <input type="hidden" name="stock_id" value="{{ $my_cart->stock->id }}">
                                            <input type="submit" value="カートから削除する">
                                        </form>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <div>
                        @if($my_carts->isNotEmpty())
                        <div class="text-center p-2">
                            個数：{{$count}}個<br>
                            <p id="total-amount" style="font-size:1.2em; font-weight:bold;">合計金額:{{number_format($sum)}}円</p>
                        </div>
                        <form class="text-center" action="/checkout" method="POST">
                            @csrf


                            <button id="customButton" class="btn btn-primary">決済をする</button>

                        </form>
                        @else
                        <p class="text-center">カートはからっぽです。</p>
                        @endif
                    </div>
                    <a href="/stocks/index">商品一覧へ</a>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stripeテスト</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>


<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
    var handler = StripeCheckout.configure({
        key: "{{ env('STRIPE_KEY') }}",
        image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
        locale: 'auto',
        currency: "JPY",
        token: function(token) {
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "{{ asset('payment') }}");

            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "_token");
            hiddenField.setAttribute("value", "{{ csrf_token() }}");
            form.appendChild(hiddenField);

            hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "stripeToken");
            hiddenField.setAttribute("value", token.id);
            form.appendChild(hiddenField);

            hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "stripeEmail");
            hiddenField.setAttribute("value", token.email);
            form.appendChild(hiddenField);

            hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "total_amount");
            hiddenField.setAttribute("value", amount);
            form.appendChild(hiddenField);

            document.body.appendChild(form);
            form.submit();
        }
    });

    // グローバル変数amountを定義
    let amount = 0;

    document.getElementById('customButton').addEventListener('click', function(e) {
        // "total-amount"エレメントから金額を取得します
        amount = document.getElementById('total-amount').textContent;

        // "円"の部分を削除し、カンマも削除します
        amount = amount.replace('合計金額:', '').replace('円', '').replace(',', '');

        // 金額はStripeではセント単位で扱われるため、金額を100倍にします
        // amount = amount * 100;

        // Stripe Checkoutを開く
        handler.open({
            name: 'Stripe Demo',
            description: 'これはStripeのデモです。',
            amount: amount // 金額をセットします
        });
        e.preventDefault();
    });

    // ウィンドウが閉じられたときに確認ダイアログを閉じる
    window.addEventListener('popstate', function() {
        handler.close();
    });
</script>


</html>
