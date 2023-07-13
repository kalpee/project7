<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="d-flex justify-content-end">
            <a href="{{ url('/mycart') }}">
                カートを見る
            </a>
            <a href="{{ url('/mycart') }}">
                <img src="{{ asset('image/カートのアイコン素材.png') }}" class="cart">
            </a>
        </div>


    </x-slot>

    <body>
        <h1>Order History</h1>
        <div class="row">
            @foreach ($orders as $order)
            <div class="col-sm-4">
                <div class="mycart_box">
                    <p>
                        Order ID: {{ $order->id }}
                        <!-- 他のフィールドもここに表示できます。例えば商品名は以下のようになるかもしれません -->
                        Product Name: {{ $order->stock->name }} <br>
                        値段: {{ $order->stock->fee }} <br>
                        画像:<img src="{{ asset('storage/' . $order->stock->imgpath) }}" alt="" class="incart">
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        <a href="/stocks/index">商品一覧へ</a>
    </body>
</x-app-layout>