<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tambah produk ke keranjang.
     */
    public function addToCart(Request $request, $id)
    {
        $product = Product::with('category')->findOrFail($id);

        // Jika user belum login → simpan di session
        if (!Auth::check()) {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'wheight' => $product->weight,
                    'image' => $product->image,
                    'category' => $product->category->name ?? 'Uncategorized',
                    'quantity' => 1,
                ];
            }

            session()->put('cart', $cart);
            session(['redirect_after_login' => route('cart.index')]);
            return redirect()->route('login')->with('info', 'Silakan login untuk melanjutkan.');
        }

        // Jika user sudah login → simpan ke database
        $cart = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $cart->quantity = ($cart->exists ? $cart->quantity + 1 : 1);
        $cart->save();

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menampilkan halaman keranjang.
     */
    public function index()
    {
        
        if (Auth::check()) {
            $cartItems = Cart::with('product.category')
                ->where('user_id', Auth::id())
                ->get()
                ->map(function ($cart) {
                    return [
                        'id' => $cart->product->id,
                        'name' => $cart->product->name,
                        'price' => $cart->product->price,
                        'image' => $cart->product->image
                            ? asset('storage/' . $cart->product->image)
                            : asset('assets/image/thumbnails/meja1.png'),
                        'category' => $cart->product->category->name ?? 'Uncategorized',
                        'quantity' => $cart->quantity,
                    ];
                });
        } else {
            $sessionCart = session()->get('cart', []);
            $cartItems = collect($sessionCart)->map(function ($item, $id) {
                return [
                    'id' => $id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image' => $item['image']
                        ? asset('storage/' . $item['image'])
                        : asset('assets/image/thumbnails/meja1.png'),
                    'category' => $item['category'] ?? 'Uncategorized',
                    'quantity' => $item['quantity'],
                ];
            });
        }

        $subtotal = $cartItems->sum(fn($item) => $item['price'] * $item['quantity']);
        $totalPrice = $subtotal;

        return view('pages.cart.index', compact('cartItems', 'subtotal', 'totalPrice'));
    }

    /**
     * Update jumlah produk di keranjang.
     */
    public function updateQuantity(Request $request, $id)
    {
        $action = $request->input('action');

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('product_id', $id)->first();
            if ($cart) {
                if ($action === 'increase') {
                    $cart->quantity++;
                } elseif ($action === 'decrease' && $cart->quantity > 1) {
                    $cart->quantity--;
                }
                $cart->save();
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                if ($action === 'increase') {
                    $cart[$id]['quantity']++;
                } elseif ($action === 'decrease' && $cart[$id]['quantity'] > 1) {
                    $cart[$id]['quantity']--;
                }
                session()->put('cart', $cart);
            }
        }

        return back();
    }

    /**
     * Hapus produk dari keranjang.
     */
    public function remove($id)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->where('product_id', $id)->delete();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
