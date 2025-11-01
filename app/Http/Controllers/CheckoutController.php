<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Checkout;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ambil cart dari database (bukan session)
        $cartItems = \App\Models\Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        // Hitung subtotal dari database
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = 15000;
        $total = $subtotal + $shipping;

        return view('pages.checkout.index', [
            'cart' => $cartItems, // biar tetap sesuai Blade
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
        ]);

        $user = auth()->user();

        DB::beginTransaction();
        try {
            $carts = \App\Models\Cart::with('product')
                ->where('user_id', $user->id)
                ->get();

            if ($carts->isEmpty()) {
                return back()->withErrors(['error' => 'Keranjang kosong.']);
            }

            $total = $carts->sum(fn($item) => $item->product->price * $item->quantity);

            // Buat order
            $order = Order::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'phone' => $request->phone,
                'total' => $total,
                'status' => 'pending',
            ]);

            // Simpan item dari cart ke order_items
            foreach ($carts as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
            }

            // Simpan placeholder untuk payment
            Payment::create([
                'order_id' => $order->id,
                'method' => 'pending',
                'status' => 'unpaid',
                'amount' => $total,
            ]);

            // Hapus cart user setelah berhasil checkout
            \App\Models\Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Pesanan berhasil dibuat, lanjut ke pembayaran.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('checkout.success', compact('order'));
    }

    
}
