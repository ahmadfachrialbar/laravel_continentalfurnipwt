<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Pesanan - CFP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-poppins">

    <main id="content" class="py-[50px]">
        <div class="max-w-[1280px] mx-auto px-[30px] md:px-[75px]">

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
                <a href="{{ url('checkout') }}" class="text-gray-500 hover:text-primary transition-colors">Checkout</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-primary font-semibold">Review</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-[30px]">

                <!-- LEFT -->
                <div class="lg:col-span-2 space-y-[30px]">

                    <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 md:p-8">
                        <h2 class="font-bold text-xl mb-6">Detail Pengiriman</h2>

                        <div class="space-y-4 text-sm">

                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Nama Penerima</span>
                                <span>{{ $order->full_name }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Nomor Telepon</span>
                                <span>{{ $order->phone }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Alamat Lengkap</span>
                                <span class="max-w-[60%] text-right">{{ $order->address }}</span>  <!-- Ganti shipping_address ke address -->
                            </div>

                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Provinsi</span>
                                <span>{{ $order->province->name ?? '-' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Kota</span>
                                <span>{{ $order->city->name ?? '-' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-600">Kecamatan</span>
                                <span>{{ $order->district->name ?? '-' }}</span>
                            </div>

                        </div>
                    </div>

                    <!-- Catatan Ongkir Manual -->
                    @if($order->shipping_status === 'manual')
                    <div class="p-5 rounded-xl border border-yellow-300 bg-yellow-50 text-sm text-yellow-700">
                        Ongkir belum dapat dihitung otomatis.
                        Admin akan menghubungi Anda melalui WhatsApp untuk biaya pengiriman.
                    </div>
                    @endif

                </div>

                <!-- RIGHT -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 sticky top-6">

                        <h2 class="font-bold text-xl pb-5">Ringkasan Pesanan</h2>

                        <!-- ITEMS -->
                        <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2">
                            @foreach($order->orderItems as $item)  <!-- Ganti $orderItems ke $order->orderItems -->
                            <div class="flex gap-4 pb-4 border-b border-[#E5E5E5] last:border-0">
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-16 h-16 rounded-lg object-cover">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-sm">{{ $item->product->name }}</h3>
                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    <p class="font-semibold text-primary text-sm">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}  <!-- Ganti total_price ke subtotal -->
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- PRICE -->
                        <div class="border-t pt-4 text-sm space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>  <!-- Ganti total_price ke subtotal -->
                            </div>

                            <div class="flex justify-between">
                                <span>Ongkir</span>
                                <span>
                                    @if($order->shipping_cost > 0)
                                    Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                    @else
                                    <span class="text-yellow-600 font-medium">Belum ditentukan</span>
                                    @endif
                                </span>
                            </div>

                            <div class="flex justify-between font-bold text-primary text-lg pt-2">
                                <span>Total</span>
                                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>  <!-- Ganti grand_total ke total -->
                            </div>
                        </div>

                        <!-- BUTTON BAYAR -->
                        <form action="{{ route('payment.process', $order->id) }}" method="POST" class="mt-6">
                            @csrf
                            <button class="w-full bg-primary text-white py-4 rounded-full font-semibold hover:bg-primary/90 transition-all duration-300">
                                Bayar Sekarang
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </main>

</body>

</html>