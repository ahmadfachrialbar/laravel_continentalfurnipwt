<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cart = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $subtotal = $cart->sum(fn($item) => $item->product->price * $item->quantity);
        $totalWeight = $cart->sum(fn($item) => $item->product->weight * $item->quantity);

        return view('pages.checkout.index', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'totalWeight' => $totalWeight,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'shipping_address' => 'required',
            'province_id' => 'nullable',
            'province_name' => 'nullable|string',
            'city_id' => 'nullable',
            'city_name' => 'nullable|string',
            'district_id' => 'nullable',
            'district_name' => 'nullable|string',
            'courier' => 'required',
            'weight' => 'required|numeric',
            'shipping_cost' => 'nullable|numeric',
        ]);

        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $shipping = $request->shipping_cost ?? 0;

            $order = Order::create([
                'user_id' => $userId,
                'order_number' => 'ORD-' . time(),
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->shipping_address,

                'province_id' => $request->province_id,
                'province_name' => $request->province_name,

                'city_id' => $request->city_id,
                'city_name' => $request->city_name,

                'district_id' => $request->district_id,
                'district_name' => $request->district_name,

                'courier' => $request->courier,
                'weight' => $request->weight,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'total' => $subtotal + $shipping,
                'payment_status' => 'pending',
                'shipping_status' => 'pending',
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);
            }

            Cart::where('user_id', $userId)->delete();
            DB::commit();

            return redirect()->route('order.review', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function review($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        // JIKA SUDAH BAYAR → JANGAN KE MIDTRANS
        if ($order->payment_status === 'paid') {
            return redirect()->route('order.detail', $order->id);
        }

        // KONFIGURASI MIDTRANS
        Config::$serverKey = config('midtrans.serverkey');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // JIKA BELUM ADA PAYMENT REFERENCE → BUAT BARU
        if (!$order->payment_reference) {
            $order->update([
                'payment_reference' => $order->order_number . '-PAY-' . time(),
            ]);
        }

        // JIKA BELUM ADA SNAP TOKEN → BUAT SEKALI
        if (!$order->snap_token) {

            $params = [
                'transaction_details' => [
                    'order_id' => $order->payment_reference, // ⬅️ PENTING
                    'gross_amount' => (int) $order->total,
                ],
                'customer_details' => [
                    'first_name' => $order->full_name,
                    'phone' => $order->phone,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            $order->update([
                'snap_token' => $snapToken,
            ]);
        }

        return view('pages.checkout.review', [
            'order' => $order,
            'snapToken' => $order->snap_token,
        ]);
    }


    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return view('pages.checkout.success', compact('order'));
    }

    public function detail($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('pages.checkout.detail', compact('order'));
    }

    //  MIDTRANS CALLBACK
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverkey');

        $signature = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($signature !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // CARI BERDASARKAN payment_reference
        $order = Order::where('payment_reference', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if (in_array($request->transaction_status, ['capture', 'settlement'])) {
            $order->update([
                'payment_status' => 'paid',
                'shipping_status' => 'packed',
                'status' => 'processing',
            ]);

            foreach ($order->orderItems as $item) {
                $item->product->decrement('stock', $item->quantity);
            }
        }

        if (in_array($request->transaction_status, ['cancel', 'expire', 'deny'])) {
            $order->update([
                'payment_status' => 'failed',
                'status' => 'cancelled',
            ]);
        }

        return response()->json(['message' => 'OK'], 200);
    }
}
