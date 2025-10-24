<!doctype html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Keranjang Belanja - Furnistyle</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    html {
      scroll-behavior: smooth;
    }

    /* Smooth transitions */
    * {
      transition-property: color, background-color, border-color;
      transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
      transition-duration: 300ms;
    }
  </style>
</head>

<body class="bg-white font-poppins">

  <main id="content" class="space-y-[70px] pb-[100px]">
    
      <div class="max-w-[1280px]  mx-auto px-[30px] md:px-[75px] pt-[50px]">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 mb-8 text-sm">
          <a href="{{ url('products') }}" class="text-gray-500 hover:text-primary transition-colors">Products</a>
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
          <a href="/cart" class="text-primary font-semibold hover:text-primary transition-colors">Keranjang</a>
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
          <span class="text-black transition-colors">Checkout</span>
        </div>
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10">
          <h1 class="text-primary font-bold text-2xl md:text-3xl leading-[34px] mb-2">Keranjang Belanja</h1>
          <a href="{{ url('/') }}" class="mt-4 md:mt-0 inline-block bg-white border border-gray-300 py-2 px-5 rounded-full font-semibold text-primary hover:bg-primary hover:text-white transition">
            ← Lanjut Berbelanja
          </a>
        </div>

        @if (!empty($cartItems) && count($cartItems) > 0)
        <!-- Cart Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

          <!-- Cart Items -->
          <div class="lg:col-span-2 space-y-6">
            @foreach ($cartItems as $item)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 flex flex-col md:flex-row items-center md:items-start gap-5">
              <!-- Gambar -->
              <div class="w-[120px] h-[120px] flex-shrink-0 rounded-xl overflow-hidden bg-gray-50 flex items-center justify-center">
                <img src="{{ $item['image'] ?? asset('assets/image/thumbnails/meja1.png') }}" alt="{{ $item['name'] ?? 'Product' }}" class="object-contain w-full h-full">
              </div>

              <!-- Info Produk -->
              <div class="flex-grow text-center md:text-left space-y-1">
                <h3 class="font-semibold text-lg">{{ $item['name'] ?? 'Nama Produk' }}</h3>
                <p class="text-sm text-gray-500">{{ $item['category'] ?? 'Kategori' }}</p>
                <p class="font-bold text-primary text-lg">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</p>
              </div>

              <!-- Kuantitas & Hapus -->
              <div class="flex flex-col items-center md:items-end gap-3">
                <div class="flex items-center gap-3 bg-gray-50 rounded-full px-4 py-2">
                  <form action="{{ route('cart.update', $item['id']) }}" method="POST">
                    @csrf
                    <button name="action" value="decrease" class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 hover:bg-primary hover:text-white transition">
                      −
                    </button>
                  </form>

                  <span class="font-semibold min-w-[30px] text-center">{{ $item['quantity'] ?? 1 }}</span>

                  <form action="{{ route('cart.update', $item['id']) }}" method="POST">
                    @csrf
                    <button name="action" value="increase" class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 hover:bg-primary hover:text-white transition">
                      +
                    </button>
                  </form>
                </div>

                <!-- Hapus Produk -->
                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </form>
              </div>
            </div>
            @endforeach
          </div>

          <!-- Ringkasan Pesanan -->
          <div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 sticky top-[120px] space-y-6">
              <h2 class="font-semibold text-xl text-center lg:text-left">Order Summary</h2>
              <div class="space-y-3 text-sm">
                <div class="flex justify-between text-gray-600">
                  <span>Subtotal ({{ count($cartItems) }} items)</span>
                  <span class="font-semibold text-black">Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
                </div>
                
                <hr class="border-gray-200">
                <div class="flex justify-between items-center text-base font-semibold">
                  <span>Total</span>
                  <span class="text-primary text-xl font-bold">Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</span>
                </div>
              </div>

              @auth
              <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-primary text-white py-3 rounded-full font-semibold hover:opacity-90 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600" aria-label="{{ __('Proceed to Checkout') }}">
                {{ __('Proceed to Checkout') }}
              </a>
              @else
              <a href="{{ route('login', ['redirect' => route('checkout')]) }}" class="block w-full text-center bg-primary text-white py-3 rounded-full font-semibold hover:opacity-90 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600" aria-label="{{ __('Login to proceed to checkout') }}">
                {{ __('Login or Register to Checkout') }}
              </a>
              @endauth

              <a href="{{ url('/') }}" class="block text-center text-sm text-gray-500 hover:text-primary transition">
                ← Lanjut Berbelanja
              </a>

              <div class="border-t border-gray-200 pt-4 space-y-2">
                <div class="flex items-center gap-3 text-gray-600">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                  <span>Secure Payment</span>
                </div>
                <div class="flex items-center gap-3 text-gray-600">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                  <span>Free Shipping Over Rp 5.000.000</span>
                </div>
              </div>
            </div>
          </div>

        </div>
        @else
        <!-- Empty Cart -->
        <div class="bg-white p-16 rounded-2xl text-center shadow-sm border border-gray-200">
          <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
          <h3 class="font-bold text-2xl mb-3">Keranjang Anda Kosong</h3>
          <p class="text-gray-500 pb-5">Yuk belanja sekarang dan temukan produk terbaik untuk Anda.</p>
          <a href="{{ url('/products') }}" class="inline-block bg-primary text-white py-3 px-8 rounded-full font-semibold hover:opacity-90 transition">
            Mulai Belanja
          </a>
        </div>
        @endif
      </div>
    
  </main>
</body>

</html>