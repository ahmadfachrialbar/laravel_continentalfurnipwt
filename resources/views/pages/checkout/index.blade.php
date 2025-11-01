<!doctype html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout - CFP</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    html {
      scroll-behavior: smooth;
    }

    /* Custom scrollbar for cart items */
    .overflow-y-auto::-webkit-scrollbar {
      width: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
      background: #E5E5E5;
      border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
      background: #4ECDC4;
    }

    /* Radio button custom styling */
    input[type="radio"]:checked {
      accent-color: #FF6B35;
    }

    /* Mobile responsive padding adjustment */
    @media (max-width: 768px) {
      .sticky {
        position: relative;
        top: 0;
      }
    }
  </style>
</head>

<body class="bg-white font-poppins">

  <main id="content" class="space-y-[70px] pb-[100px]">
    <div class="max-w-[1280px] mx-auto px-[30px] md:px-[75px] pt-[50px]">
      <!-- Breadcrumb -->
      <div class="flex items-center gap-2 mb-8 text-sm">
        <a href="{{ url('products') }}" class="text-gray-500 hover:text-primary transition-colors">Produk</a>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ url('cart') }}" class="text-gray-500 hover:text-primary transition-colors">Keranjang</a>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-primary font-semibold">Checkout</span>
      </div>

      <!-- Page Title -->
      <div class="mb-8">
        <h1 class="text-primary font-bold text-2xl md:text-3xl leading-[34px] mb-2">Checkout</h1>
        <p class="text-gray-600">Lengkapi informasi pengiriman Anda</p>
      </div>

      <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-[30px]">
          <!-- Left Side - Shipping & Payment Info -->
          <div class="lg:col-span-2 space-y-[30px]">
            <!-- Shipping Information -->
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 md:p-8">
              <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
                <h2 class="font-bold text-xl">Detail Pengiriman</h2>
              </div>

              <div class="space-y-4">
                <!-- Full Name -->
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                  <input type="text" name="full_name" placeholder="Masukkan nama lengkap" class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300" required>
                </div>

                <!-- Phone Number -->
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                  <input type="tel" name="phone" placeholder="08xxxxxxxxxx" class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300" required>
                </div>

                <!-- Full Address -->
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                  <textarea name="address" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan" class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300 resize-none" required></textarea>
                </div>

                <!-- City & Postal Code -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kota</label>
                    <input type="text" name="city" placeholder="Nama kota" class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300" required>
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Pos</label>
                    <input type="text" name="postal_code" placeholder="12345" class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300" required>
                  </div>
                </div>

                <!-- Province -->
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Provinsi</label>
                  <input type="text" name="province" placeholder="Nama provinsi" class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300" required>
                </div>
              </div>
            </div>

            <!-- Shipping Method -->
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 md:p-8">
              <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                  </svg>
                </div>
                <h2 class="font-bold text-xl">Metode Pengiriman</h2>
              </div>

              <div class="space-y-3">
                <label class="flex items-center justify-between p-4 border-2 border-[#E5E5E5] rounded-[15px] cursor-pointer hover:border-secondary transition-all duration-300">
                  <div class="flex items-center gap-4">
                    <input type="radio" name="shipping_method" value="regular" class="w-5 h-5 text-primary" checked>
                    <div>
                      <p class="font-semibold">Reguler (3-5 hari)</p>
                      <p class="text-sm text-gray-500">Estimasi sampai 22-24 Okt</p>
                    </div>
                  </div>
                  <span class="font-semibold text-primary">Rp 15.000</span>
                </label>

                <label class="flex items-center justify-between p-4 border-2 border-[#E5E5E5] rounded-[15px] cursor-pointer hover:border-secondary transition-all duration-300">
                  <div class="flex items-center gap-4">
                    <input type="radio" name="shipping_method" value="express" class="w-5 h-5 text-primary">
                    <div>
                      <p class="font-semibold">Express (1-2 hari)</p>
                      <p class="text-sm text-gray-500">Estimasi sampai 23 Okt</p>
                    </div>
                  </div>
                  <span class="font-semibold text-primary">Rp 35.000</span>
                </label>

                <label class="flex items-center justify-between p-4 border-2 border-[#E5E5E5] rounded-[15px] cursor-pointer hover:border-secondary transition-all duration-300">
                  <div class="flex items-center gap-4">
                    <input type="radio" name="shipping_method" value="same_day" class="w-5 h-5 text-primary">
                    <div>
                      <p class="font-semibold">Same Day</p>
                      <p class="text-sm text-gray-500">Hari ini sampai</p>
                    </div>
                  </div>
                  <span class="font-semibold text-primary">Rp 50.000</span>
                </label>
              </div>
            </div>

          </div>

          <!-- Right Side - Order Summary -->
          <div class="lg:col-span-1">
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 sticky top-6">
              <h2 class="font-bold text-xl pb-5">Ringkasan Pesanan</h2>

              <!-- Cart Items -->
              <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2">
                @forelse($cart as $item)
                <div class="flex gap-4 pb-4 border-b border-[#E5E5E5] last:border-0">
                  <img src="{{ asset('storage/' . $item->product->image) }}"
                    alt="{{ $item->product->name }}"
                    class="w-16 h-16 object-cover rounded-[10px]">

                  <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-sm leading-[20px] truncate">{{ $item->product->name }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                    <p class="font-semibold text-primary text-sm mt-1">
                      Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                    </p>
                  </div>
                </div>
                @empty
                <div class="text-center py-8">
                  <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                  </svg>
                  <p class="text-gray-500">Keranjang kosong</p>
                </div>
                @endforelse
              </div>

              <!-- Promo Code -->

              <!-- Price Details -->
              <div class="space-y-3 mb-6 pb-6 border-b border-[#E5E5E5]">
                <div class="flex justify-between text-sm">
                  <span class="text-gray-600">Subtotal</span>
                  <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                  <span class="text-gray-600">Biaya Pengiriman</span>
                  <span class="font-semibold">Rp 15.000</span>
                </div>
                <div class="flex justify-between text-sm">
                  <span class="text-gray-600">Diskon</span>
                  <span class="font-semibold text-green-600">- Rp 0</span>
                </div>
              </div>

              <!-- Total -->
              <div class="flex justify-between items-center mb-6">
                <span class="font-bold text-lg">Total</span>
                <span class="font-bold text-xl text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
              </div>

              <!-- INTEGRASI PAYMENT GATEWAY -->
              <!-- Submit Button -->
              <button type="submit" class="w-full bg-primary text-white font-semibold py-4 rounded-full hover:bg-primary/90 transition-all duration-300 shadow-lg hover:shadow-xl">
                Bayar Sekarang
              </button>

              <!-- Security Info -->
              <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span>Pembayaran aman dan terenkripsi</span>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </main>

</body>

</html>