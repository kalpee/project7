<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class Cart extends Model
{
    protected $fillable = ["stock_id", "user_id"];

    public function show()
    {
        $user_id = Auth::id();

        $data = $this->where("user_id", $user_id)
            ->with("stock")
            ->get();

        return $data;
    }

    public function stock()
    {
        return $this->belongsTo("\App\Models\Stock", "stock_id");
    }

    public function add($stock_id)
    {
        $user_id = Auth::id();
        $cart_add_info = Cart::firstOrCreate([
            "stock_id" => $stock_id,
            "user_id" => $user_id,
        ]);

        if ($cart_add_info->wasRecentlyCreated) {
            $message = "カートに追加しました";
        } else {
            $message = "カートに登録済みです";
        }

        return $message;
    }

    public function remove($stock_id)
    {
        $user_id = Auth::id();
        $delete = $this->where("user_id", $user_id)
            ->where("stock_id", $stock_id)
            ->delete();

        if ($delete > 0) {
            $message = "カートから一つの商品を削除しました";
        } else {
            $message = "削除に失敗しました";
        }
        return $message;
    }

    public function checkout()
    {
        $user_id = Auth::id();

        // トランザクション開始
        DB::beginTransaction();

        try {
            $checkout_items = $this->where("user_id", $user_id)->get();

            foreach ($checkout_items as $item) {
                Order::create([
                    "stock_id" => $item->stock_id,
                    "user_id" => $item->user_id,
                    "quantity" => $item->quantity,
                ]);
            }

            $this->where("user_id", $user_id)->delete();

            // すべての処理が成功したらコミット
            DB::commit();
            return true;
        } catch (\Exception $e) {
            // エラーが発生したらロールバック
            DB::rollback();
            return $e->getMessage();
        }
    }
}
