<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::orderBy("created_at", "desc")->paginate(6);
        return Inertia::render("Stocks/Index", ["stocks" => $stocks]);
    }

    public function create()
    {
        return Inertia::render("Stocks/Create");
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            "name" => "required|max:100",
            "detail" => "required|max:500",
            "fee" => "required|integer",
            "imgpath" => "required|file|image",
        ]);

        // public/imagesに画像保存
        $file = $request->file("imgpath");
        $filename = $file->getClientOriginalName();
        $disk = Storage::build([
            "driver" => "local",
            "root" => public_path("images"),
        ]);
        $disk->putFileAs("", $file, $filename);

        // DBに新規登録
        $stock = new Stock();
        $stock->name = $request->name;
        $stock->detail = $request->detail;
        $stock->fee = $request->fee;
        $stock->imgpath = $filename;
        $stock->save();

        // 商品一覧にリダイレクト
        return Inertia::location("/stocks/index");
    }

    public function view($id)
    {
        $stock = Stock::find($id);

        if ($stock === null) {
            return abort(404, "商品がありません。");
        }
        return Inertia::render("Stocks/View", ["stock" => $stock]);
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::find($id);

        if ($stock === null) {
            return abort(404, "商品がありません。");
        }

        // バリデーション
        $request->validate([
            "name" => "required|max:100",
            "detail" => "required|max:500",
            "fee" => "required|integer",
            "imgpath" => "sometimes|file|image",
        ]);

        if ($request->file("imgpath")) {
            $file = $request->file("imgpath");
            $filename = $file->getClientOriginalName();

            // 以前の画像を削除
            $disk = Storage::build([
                "driver" => "local",
                "root" => public_path("images"),
            ]);
            $disk->delete($stock->imgpath);

            // 新しい画像を保存
            $disk->putFileAs("", $file, $filename);
            $stock->imgpath = $filename;
        }

        $stock->name = $request->name;
        $stock->detail = $request->detail;
        $stock->fee = $request->fee;

        $stock->save();

        return Inertia::location("/stocks/index");
    }

    public function delete($id)
    {
        $stock = Stock::find($id);

        if ($stock === null) {
            return abort(404, "商品がありません。");
        }

        // 画像を削除
        $disk = Storage::build([
            "driver" => "local",
            "root" => public_path("images"),
        ]);
        $disk->delete($stock->imgpath);

        // データベースレコードを削除
        $stock->delete();

        // 商品一覧ページにリダイレクト
        return Inertia::location("/stocks/index");
    }
}
