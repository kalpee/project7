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
                                    <img src="/image/{{$my_cart->stock->imgpath}}" alt="" class="incart" >
                                    <br>
                                    <form action="/cartdelete" method="post">
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
                                <p style="font-size:1.2em; font-weight:bold;">合計金額:{{number_format($sum)}}円</p>  
                            </div>  
                            <form class="text-center" action="/checkout" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-lg text-center buy-btn " >購入する</button>
                            </form>
                        @else
                            <p class="text-center">カートはからっぽです。</p>
                        @endif
                    </div>
                    <a href="/index">商品一覧へ</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
