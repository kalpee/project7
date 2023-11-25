<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ["stock_id", "user_id", "quantity"];
    protected $appends = ["formatted_created_at"];

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function stock()
    {
        return $this->belongsTo("App\Models\Stock");
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format("Y-m-d H:i");
    }
}
