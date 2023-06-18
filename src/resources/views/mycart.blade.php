<div class="container-fluid">
   <div class="">
       <div class="mx-auto" style="max-width:1200px">
           <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">カートの中身</h1>
           {{ Auth::user()->name }}さんのカートの中身</h1>
                <div class="">
                     <p class="text-center">{{ $message }}</p><br>
                        <div class="d-flex flex-row flex-wrap">

                            @foreach($my_carts as $my_cart)
                                <div class="mycart_box">
                                    <p>ユーザーID：{{$my_cart->user_id}}</p>
                                    <p>ストックID：{{$my_cart->stock_id}}</p>
                                <>/div
                            @endforeach

                        </div>

                         <a href="/">商品一覧へ</a>
                </div>
        </div>
    </div>
</div>