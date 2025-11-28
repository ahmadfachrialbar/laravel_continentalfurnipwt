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

        if (!$request->shipping_cost && $request->courier) {
            return back()->with('error', 'Harap pilih ongkir terlebih dahulu.');
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
        return view('pages.checkout.review', compact('order'));
    }

    public function success($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('checkout.success', compact('order'));
    }
}
