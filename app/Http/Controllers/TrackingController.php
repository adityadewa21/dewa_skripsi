<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class TrackingController extends Controller
{
    public function track()
    {
        return view('orders.track');
    }

    public function result(Request $request)
    {
        $request->validate([
            'order_code' => 'required'
        ]);

        $order = Order::where('order_code', $request->order_code)
            ->with('orderItems')
            ->first();

        if (!$order) {
            return back()->with('error', 'Kode pesanan tidak ditemukan');
        }

        return view('orders.result-track', compact('order'));
    }
}
