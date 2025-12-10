<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class OrderController extends Controller
{
    public function review($orderId)
    {
        $order = Order::with('orderItems.product')->findOrFail($orderId);

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Sandbox
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_id_midtrans, // pakai kolom ini
                'gross_amount' => $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->full_name,
                'email' => auth()->user()->email ?? 'noemail@example.com',
                'phone' => $order->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('pages.checkout.review', compact('order', 'snapToken'));
    }

    public function success($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('checkout.success', compact('order'));
    }
}
