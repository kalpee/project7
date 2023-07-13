<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;


class StockController extends Controller
{

    public function index()
    {
        $stocks = Stock::orderBy('created_at', 'desc')->paginate(6); //Eloquantで検索
        return view('stocks.index', compact('stocks'));
    }


    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'detail' => 'required|max:500',
            'fee' => 'required|integer',
            'imgpath' => 'required|file|image',
        ]);

        $file = $request->file('imgpath');
        $path = $file->store('public/image');
        $filename = str_replace('public/', '', $path);

        $stock = new Stock;
        $stock->name = $request->name;
        $stock->detail = $request->detail;
        $stock->fee = $request->fee;
        $stock->imgpath = $filename;
        $stock->save();

        return redirect('/stocks/index');
    }
}
