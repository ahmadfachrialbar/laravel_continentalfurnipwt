<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ProfileController extends Controller
{
    // Halaman Profil
    public function index()
    {
        $user = Auth::user();

        $orders = Order::with(['orderItems.product', 'province', 'city', 'district'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('pages.profile.index', compact('user', 'orders'));
    }

    // Form Edit Profil
    public function edit()
    {
        $user = Auth::user();
        return view('pages.profile.edit', compact('user'));
    }

    // Update Profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only('name', 'email', 'phone'));

        return redirect()->route('profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    // Pesanan Saya
    public function myOrders()
    {
        $orders = Order::with([
            'orderItems.product',
            'province',
            'city',
            'district'
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pages.user.orders', compact('orders'));
    }
}
