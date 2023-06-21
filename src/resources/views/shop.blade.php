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
    <div class="container-fluid">
        <div class="">
            <div class="mx-auto" style="max-width:1200px">
                <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">商品一覧</h1>
                <a class="dropdown-item" href="{{ url('/order_history') }}">
                    購入履歴
                </a>
                <div class="container">
                    <div class="row">
                        @foreach($stocks as $stock)
                        <div class="col-sm-4">
                            <div class="mycart_box">
                                {{$stock->name}} <br>
                                {{$stock->fee}}円<br>
                                <img src="{{ asset('storage/' . $stock->imgpath) }}" alt="{{ $stock->name }}" class="incart">
                                <br>
                                {{$stock->detail}} <br>

                                <form action="mycart" method="post">
                                    @csrf
                                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                    <input type="submit" value="カートに入れる">
                                </form>
                            </div>

                        </div>
                        @endforeach
                        <a class="text-center" href="/create">商品登録</a>
                        <a class="text-center" href="/">商品一覧へ</a>
                        <div class="text-center" style="width: 200px;margin: 20px auto;">
                            {{ $stocks->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
