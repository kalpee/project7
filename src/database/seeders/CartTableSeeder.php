<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //追記

class CartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('carts')->truncate(); //2回目実行の際にシーダー情報をクリア
        DB::table('carts')->insert([
            'id' => 1,
            'stock_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('carts')->insert([
            'id' => 2,
            'stock_id' => 2,
            'user_id' => 2,
        ]);
    }
}
