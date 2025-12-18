<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Checkout;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Snap;
use Midtrans\Config;


class CheckoutController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $totalWeight = $cartItems->sum(fn($item) => $item->product->weight * $item->quantity);

        return view('pages.checkout.index', [
            'cart' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => 0,
            'total' => $subtotal,
            'totalWeight' => $totalWeight,
        ]);
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'province_id'   => 'nullable',
            'province_name' => 'nullable|string',
            'city_id'       => 'nullable',
            'city_name'     => 'nullable|string',
            'district_id'   => 'nullable',
            'district_name' => 'nullable|string',
            'courier'       => 'required|string',
            'weight'        => 'required|numeric',
            'shipping_cost' => 'nullable|numeric',
        ]);

        $userId = Auth::id();

        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }



        $totalPrice = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = $request->shipping_cost ?? 0;

        DB::beginTransaction();
        try {

            // SIMPAN ORDER DENGAN NAMA WILAYAH
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => 'ORD-' . time(),
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'address' => $request->shipping_address,

                'province_id' => $request->province_id,
                'province_name' => $request->province_name,

                'city_id' => $request->city_id,
                'city_name' => $request->city_name,

                'district_id' => $request->district_id,
                'district_name' => $request->district_name,

                'courier' => $request->courier,
                'weight' => $request->weight,
                'subtotal' => $totalPrice,
                'shipping_cost' => $shippingCost,
                'total' => $totalPrice + $shippingCost,
                'status' => 'pending',
                'shipping_status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // SIMPAN ITEM
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);
            }

            // HAPUS CART
            Cart::where('user_id', $userId)->delete();

            DB::commit();
            return redirect()->route('order.review', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function review($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        // KONFIGURASI MIDTRANS
        Config::$serverKey     = config('midtrans.serverkey');
        Config::$isProduction  = config('midtrans.is_production');
        Config::$isSanitized   = true;
        Config::$is3ds         = true;

        // PARAMETER UNTUK SNAP
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->full_name,
                'phone' => $order->phone,
            ],
            'item_details' => [
                [
                    'id' => $order->order_number,
                    'price' => (int) $order->total,
                    'quantity' => 1,
                    'name' => 'Pembayaran Order ' . $order->order_number
                ]
            ]
        ];

        // AMBIL SNAP TOKEN
        $snapToken = Snap::getSnapToken($params);

        return view('pages.checkout.review', compact('order', 'snapToken'));
    }

    public function success(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $item = $order->orderItems->first();
        $product = Product::find($item->product_id);

        // UPDATE STATUS ORDER


        foreach ($order->orderItems as $item) {
            $product->update([
                'stock' => DB::raw('stock - ' . $item->quantity),
            ]);
        }


        return view('pages.checkout.success', compact('order'));
    }

    // halaman detail
    public function detail($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        return view('pages.checkout.detail', compact('order'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverkey');

        $hashed = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        // VALIDASI SIGNATURE
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_number', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // STATUS SUKSES
        if (
            $request->transaction_status === 'capture' ||
            $request->transaction_status === 'settlement'
        ) {
            $order->update([
                'payment_status'  => 'paid',
                'shipping_status' => 'packed',
                'status'          => 'processing',
            ]);
        }

        // STATUS GAGAL
        if (in_array($request->transaction_status, ['deny', 'cancel', 'expire'])) {
            $order->update([
                'payment_status'  => 'failed',
                'shipping_status' => 'pending',
                'status'          => 'cancelled',
            ]);
        }

        return response()->json(['message' => 'Callback processed'], 200);
    }
}
