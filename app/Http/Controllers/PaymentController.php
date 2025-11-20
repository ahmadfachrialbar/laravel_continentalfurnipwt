<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;


class PaymentController extends Controller
{
    public function process(Request $request, $orderId)
    {
        // Ambil order berdasarkan ID
        $order = Order::with('orderItems.product')->findOrFail($orderId);

        // Untuk halaman sederhana, kita pass order ke view
        return view('pages.checkout.payment', compact('order'));
    }

    public function confirm(Request $request, $orderId)
    {
        // Placeholder untuk konfirmasi pembayaran
        // Di sini Anda bisa tambahkan logika pembayaran nyata (misal update status payment)
        $order = Order::findOrFail($orderId);
        $order->update(['payment_status' => 'paid']);  // Update status sebagai contoh

        // Redirect ke halaman success
        return redirect()->route('checkout.success', $order->id);
    }
}