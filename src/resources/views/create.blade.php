<form method="post" action="{{ url('/store') }}" enctype="multipart/form-data">
    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name" placeholder="商品名">

    <label for="detail">Detail:</label>
    <textarea name="detail" placeholder="詳細"></textarea>

    <label for="fee">Fee:</label>
    <input type="number" name="fee" placeholder="価格">

    <label for="imgpath">Image Path:</label>
    <input type="file" name="imgpath">

    <button type="submit">登録</button>
</form>
