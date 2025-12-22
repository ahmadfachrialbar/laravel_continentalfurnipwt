<!doctype html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout - CFP</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    html {
      scroll-behavior: smooth;
    }

    .overflow-y-auto::-webkit-scrollbar {
      width: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
      background: #E5E5E5;
      border-radius: 10px;
    }

    input[type="radio"]:checked {
      accent-color: #FF6B35;
    }

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

        <a href="" class="text-primary font-semibold">Checkout</a>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>

      </div>

      <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-[30px]">
          <!-- LEFT SIDE -->
          <div class="lg:col-span-2 space-y-[30px]">
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 md:p-8">
              <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
                <h2 class="font-bold text-xl">Detail Pengiriman</h2>
              </div>

              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                  <input type="text" name="full_name" placeholder="Masukkan nama lengkap"
                    class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:outline-none transition-all duration-300"
                    required>
                </div>

                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                  <input type="tel" name="phone" placeholder="08xxxxxxxxxx"
                    class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:outline-none transition-all duration-300"
                    required>
                </div>

                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                  <input type="email" name="email" placeholder="Masukkan email anda"
                    class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:outline-none transition-all duration-300"
                    required>
                </div>

                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                  <textarea name="shipping_address" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan"
                    class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 focus:ring-2 focus:ring-secondary focus:outline-none transition-all duration-300 resize-none"
                    required></textarea>
                </div>

                <!-- RAJAONGKIR FORM INCLUDE -->
                @include('pages.rajaongkir.form')
                <!-- Warning jika API RajaOngkir sedang limit -->
                <div id="rajaongkir-limit-warning" class="p-5 rounded-xl border border-yellow-300 bg-yellow-50 text-sm text-yellow-700 mt-6">
                  Jika Provinsi, kota, dan kecamatan tidak memuat, harap masukan alamat lengkap di form alamat, kemudian lanjutkan checkout. Admin akan menghitung ongkir anda sebelum anda melakukan pembayaran.
                  <button onclick="window.location.href='https://wa.me/6285880232466?text=Halo%20Admin%2C%20saya%20ingin%20konfirmasi%20ongkir%20untuk%20pesanan saya'"
                    class="mt-3 inline-block bg-yellow-300 text-yellow-900 py-2 px-0 rounded-full text-sm font-semibold hover:bg-yellow-400 transition-all duration-300">
                    Harap konfirmasi Admin via WhatsApp
                  </button>
                </div>

              </div>
            </div>
          </div>

          <!-- RIGHT SIDE -->
          <div class="lg:col-span-1">
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 sticky top-6">
              <h2 class="font-bold text-xl pb-5">Ringkasan Pesanan</h2>

              <!-- CART ITEMS -->
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
                  <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                  </svg>
                  <p class="text-gray-500">Keranjang kosong</p>
                </div>
                @endforelse
              </div>

              <!-- PRICE DETAILS -->
              @php
              $subtotal = $cart->sum(fn($i) => $i->product->price * $i->quantity);
              $weight = $cart->sum(fn($i) => $i->product->weight * $i->quantity);
              @endphp

              <div class="mt-4 border-t pt-4">
                <div class="flex justify-between">
                  <span>Subtotal</span>
                  <span id="subtotal" data-value="{{ $subtotal }}">{{ number_format($subtotal) }}</span>
                </div>
                <div class="flex justify-between">
                  <span>Biaya Pengiriman</span>
                  <span id="shipping-amount">Rp 0</span>
                </div>
                <div class="flex justify-between font-bold text-primary mt-2">
                  <span>Total</span>
                  <span id="total-amount">{{ number_format($subtotal) }}</span>
                </div>
              </div>


              <input type="hidden" name="weight" id="total-weight" value="{{ $weight }}">
              <input type="hidden" name="shipping_cost" id="shipping-cost-hidden" value="0">

              <button type="submit"
                class="w-full bg-primary text-white font-semibold py-4 rounded-full hover:bg-primary/90 transition-all duration-300 shadow-lg hover:shadow-xl">
                Checkout Now
              </button>

              <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span>Pemesanan aman dan terenkripsi</span>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </main>

</body>


</html>