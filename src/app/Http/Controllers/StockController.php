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
}
