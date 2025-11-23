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
        $cartItems = \App\Models\Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $totalWeight = $cartItems->sum(fn($item) => $item->product->weight * $item->quantity);
        $shipping = 0;
        $total = $subtotal + $shipping;

        return view('pages.checkout.index', [
            'cart' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
            'totalWeight' => $totalWeight,
        ]);
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'shipping_address' => 'required|string',  // Sesuaikan nama field
            'province_id'   => 'required',
            'city_id'       => 'required',
            'district_id'   => 'required',
            'courier'       => 'nullable|string',
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

        if ($request->shipping_cost === null && $request->courier) {
            return back()->with('error', 'Harap pilih ongkir terlebih dahulu.');
        }



        // Hitung total harga dari cart items (lebih akurat)
        $totalPrice = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = $request->shipping_cost ?? 0;

        DB::beginTransaction();
        try {
            // Simpan order - SESUAIKAN FIELD DENGAN FILLABLE MODEL
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => 'ORD-' . time(),
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'address' => $request->shipping_address,  // Gunakan 'address' sesuai fillable
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'courier' => $request->courier,
                'weight' => $request->weight,
                'subtotal' => $totalPrice,  // Hitung subtotal
                'shipping_cost' => $shippingCost,
                'total' => $totalPrice + $shippingCost,  // Hitung total
                'status' => 'pending',
                'shipping_status' => 'pending',
                'payment_status' => 'pending',

            ]);

            // Simpan item produk - TAMBAHKAN SUBTOTAL
            foreach ($cartItems as $item) {
                $itemSubtotal = $item->product->price * $item->quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $itemSubtotal,  // Hitung subtotal per item
                ]);
            }

            // Kosongkan cart
            Cart::where('user_id', $userId)->delete();

            DB::commit();

            // PERBAIKI NAMA ROUTE: Gunakan 'order.review' sesuai web.php
            return redirect()->route('order.review', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method review dan success tetap sama
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
