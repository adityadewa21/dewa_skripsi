<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function dashboard()
    {
        return redirect('/');
    }
    public function profile()
    {
        $user = Auth::user();

        // Optional: pastikan hanya customer
        if ($user->role !== 'customer') {
            abort(403);
        }

        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'customer') {
            abort(403);
        }

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->address = $request->address;

        // kalau password diisi → update
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('customer.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.order', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('orderItems');

        return view('customer.detail', compact('order'));
    }
}
