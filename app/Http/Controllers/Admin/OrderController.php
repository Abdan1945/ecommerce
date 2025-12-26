<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // ⬅️ WAJIB
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::latest()->paginate(10);

    return view('admin.orders.index', compact('orders'));
}

}
