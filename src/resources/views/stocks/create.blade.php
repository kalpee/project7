<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="d-flex justify-content-end">
            <a href="{{ url('/carts/index') }}">
                カートを見る
            </a>
            <a href="{{ url('/carts/index') }}">
                <img src="{{ asset('image/カートのアイコン素材.png') }}" class="cart">
            </a>
        </div>


    </x-slot>
    <div class="col-sm-4">
        <div class="mycart_box">
            <form method="post" action="{{ url('/store') }}" enctype="multipart/form-data">
                @csrf
                <label for="name">商品名:</label>
                <input type="text" class="form-control" name="name" placeholder="商品名" required>

                <label for="detail">詳細:</label>
                <textarea name="detail" class="form-control" placeholder="詳細" required></textarea>

                <label for="fee">価格:</label>
                <input type="number" class="form-control" name="fee" placeholder="価格" required>

                <label for="imgpath">画像:</label>
                <input type="file" class="form-control-file" name="imgpath" required>
                <img id="preview" src="#" alt="preview image" style="max-width:200px; display:none;" />

                <button type="submit" class="btn btn-primary mt-3">登録</button>
            </form>
        </div>
    </div>
    <a class="text-center" href="/stocks/index">商品一覧へ</a>
</x-app-layout>
<script>
    document.querySelector('input[type=file]').addEventListener('change', function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
        }
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
