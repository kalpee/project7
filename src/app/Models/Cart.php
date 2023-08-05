<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\OrderHistory;
class Cart extends Model
{
    protected $fillable = ["stock_id", "user_id"];

    public function show()
    {
        $user_id = Auth::id();

        $data["my_carts"] = $this->where("user_id", $user_id)->get();

        $data["count"] = 0;
        $data["sum"] = 0;

        foreach ($data["my_carts"] as $my_cart) {
            $data["count"]++;
            $data["sum"] += $my_cart->stock->fee;
        }
        return $data;
    }
    public function stock()
    {
        return $this->belongsTo("\App\Models\Stock");
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
                OrderHistory::create([
                    "stock_id" => $item->stock_id,
                    "user_id" => $item->user_id,
                ]);
            }

            $this->where("user_id", $user_id)->delete();

            // すべての処理が成功したらコミット
            DB::commit();
        } catch (\Exception $e) {
            // エラーが発生したらロールバック
            DB::rollback();
            return false;
        }
        return $checkout_items;
    }
}
