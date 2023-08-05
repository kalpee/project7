<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $orders = OrderHistory::where("user_id", $user_id)->get();

        return Inertia::render("Orders/Index", ["orders" => $orders]);
    }
}
