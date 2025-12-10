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
    
    // MIDTRANS CALLBACK HANDLER
    public function callback(Request $request)
    {
        // SET KONFIGURASI MIDTRANS
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Ambil notifikasi dari Midtrans
        $notification = new Notification();

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        // Ambil order dari database
        $order = Order::where('order_id_midtrans', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        // =============================
        // LOGIKA UPDATE STATUS
        // =============================
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $order->payment_status = 'challenge';
            } else {
                $order->payment_status = 'paid';
            }
        } 
        else if ($transactionStatus == 'settlement') {
            $order->payment_status = 'paid';
        } 
        else if ($transactionStatus == 'pending') {
            $order->payment_status = 'pending';
        } 
        else if ($transactionStatus == 'deny') {
            $order->payment_status = 'deny';
        } 
        else if ($transactionStatus == 'expire') {
            $order->payment_status = 'expired';
        } 
        else if ($transactionStatus == 'cancel') {
            $order->payment_status = 'cancelled';
        }

        $order->save();

        return response()->json(['message' => 'Callback processed'], 200);
    }

    
}