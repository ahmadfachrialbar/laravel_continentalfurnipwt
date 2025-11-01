<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 🔹 Tampilkan halaman login
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    // 🔹 Tampilkan halaman register
    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    // 🔹 Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Sinkronisasi cart dari session ke database
            $sessionCart = session()->get('cart', []);
            if (!empty($sessionCart)) {
                foreach ($sessionCart as $productId => $item) {
                    $cart = \App\Models\Cart::firstOrNew([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                    ]);
                    $cart->quantity = ($cart->exists ? $cart->quantity + $item['quantity'] : $item['quantity']);
                    $cart->save();
                }
                session()->forget('cart'); // hapus dari session setelah disimpan ke DB
            }

            // Redirect logic
            if ($user->role === 'admin') {
                return redirect()->route('filament.admin.pages.dashboard')->with('success', 'Berhasil login sebagai admin!');
            }

            $redirectUrl = session()->pull('redirect_after_login', route('home'));
            return redirect()->to($redirectUrl)->with('success', 'Berhasil login!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }


    // 🔹 Proses register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect('/login')->with('success', 'Registrasi berhasil! Selamat datang 👋');
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        // Get the guard name before logout
        $guard = Auth::getDefaultDriver();

        // Only logout if it's the web guard (regular users)
        if ($guard === 'web') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
