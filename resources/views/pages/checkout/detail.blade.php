<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->order_number }} - CFP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-poppins">

    <main id="content" class="py-[50px]">
        <div class="max-w-[1280px] mx-auto px-[30px] md:px-[75px]">

            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 mb-8 text-sm">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-primary transition-colors">Beranda</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url('/profile') }}" class="text-gray-500 hover:text-primary transition-colors">Profil</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-primary font-semibold">Detail Pesanan</span>
            </div>

            <!-- Header -->
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 md:p-8 mb-6">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <h1 class="font-bold text-2xl text-gray-800 mb-2">
                            Order #{{ $order->order_number }}
                        </h1>
                        <p class="text-sm text-gray-500">
                            Dipesan pada {{ $order->created_at->format('d M Y, H:i') }} WIB
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <!-- Status Pembayaran -->
                        <span class="text-sm px-4 py-2 rounded-full font-semibold
                            @if($order->payment_status === 'paid') bg-green-100 text-green-700
                            @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($order->payment_status === 'failed') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $order->payment_status === 'paid' ? 'Dibayar' : ($order->payment_status === 'pending' ? 'Menunggu Pembayaran' : ucfirst($order->payment_status)) }}
                        </span>
                        <!-- Status Pengiriman -->
                        <span class="text-sm px-4 py-2 rounded-full font-semibold
                            @if($order->shipping_status === 'completed') bg-green-100 text-green-700
                            @elseif($order->shipping_status === 'shipped') bg-purple-100 text-purple-700
                            @elseif($order->shipping_status === 'processing') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst($order->shipping_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-[30px]">

                <!-- LEFT -->
                <div class="lg:col-span-2 space-y-[30px]">

                    <!-- Detail Pengiriman -->
                    <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 md:p-8">
                        <h2 class="font-bold text-xl mb-6 pb-4 border-b border-gray-100">Detail Pengiriman</h2>

                        <div class="space-y-4 text-sm">
                            <div class="flex flex-col md:flex-row md:justify-between gap-2">
                                <span class="font-semibold text-gray-600">Nama Penerima</span>
                                <span class="md:text-right">{{ $order->full_name }}</span>
                            </div>

                            <div class="flex flex-col md:flex-row md:justify-between gap-2">
                                <span class="font-semibold text-gray-600">Nomor Telepon</span>
                                <span class="md:text-right">{{ $order->phone }}</span>
                            </div>

                            <div class="flex flex-col md:flex-row md:justify-between gap-2">
                                <span class="font-semibold text-gray-600">Email</span>
                                <span class="md:text-right">{{ $order->email }}</span>
                            </div>

                            <div class="flex flex-col md:flex-row md:justify-between gap-2">
                                <span class="font-semibold text-gray-600">Alamat Lengkap</span>
                                <span class="md:max-w-[60%] md:text-right">{{ $order->address }}</span>
                            </div>

                            <div class="flex flex-col md:flex-row md:justify-between gap-2">
                                <span class="font-semibold text-gray-600">Provinsi</span>
                                <span class="md:text-right">{{ $order->province_name ?? '-' }}</span>
                            </div>

                            <div class="flex flex-col md:flex-row md:justify-between gap-2">
                                <span class="font-semibold text-gray-600">Kota</span>
                                <span class="md:text-right">{{ $order->city_name ?? '-' }}</span>
                            </div>

                            <div class="flex flex-col md:flex-row md:justify-between gap-2">
                                <span class="font-semibold text-gray-600">Kecamatan</span>
                                <span class="md:text-right">{{ $order->district_name ?? '-' }}</span>
                            </div>

                            <div class="flex flex-col md:flex-row md:justify-between gap-2">
                                <span class="font-semibold text-gray-600">Kurir</span>
                                <span class="md:text-right uppercase">{{ $order->courier ?? '-' }}</span>
                            </div>

                            @if($order->tracking_number)
                            <div class="flex flex-col md:flex-row md:justify-between gap-2 pt-2 border-t border-gray-100">
                                <span class="font-semibold text-gray-600">Nomor Resi</span>
                                <span class="md:text-right font-mono text-primary">{{ $order->tracking_number }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Info -->
                    @if(is_null($order->shipping_cost) || $order->shipping_cost == 0)
                    <div class="p-5 rounded-xl border border-yellow-300 bg-yellow-50">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm text-yellow-700 font-semibold mb-1">Menunggu Konfirmasi Ongkir</p>
                                <p class="text-sm text-yellow-700 mb-3">
                                    Ongkir akan dihitung oleh admin. Silakan hubungi admin untuk konfirmasi.
                                </p>
                                <button onclick="window.location.href='https://wa.me/6285880232466?text=Halo%20Admin%2C%20saya%20ingin%20konfirmasi%20ongkir%20untuk%20order%20{{ $order->order_number }}'"
                                    class="inline-flex items-center gap-2 bg-yellow-600 text-white py-2 px-4 rounded-full text-sm font-semibold hover:bg-yellow-700 transition-all duration-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                    </svg>
                                    Hubungi Admin via WhatsApp
                                </button>
                            </div>
                        </div>
                    </div>
                    @elseif($order->payment_status === 'pending')
                    <div class="p-5 rounded-xl border border-yellow-300 bg-yellow-50">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-yellow-700 font-semibold mb-1">Menunggu Pembayaran</p>
                                <p class="text-sm text-yellow-700">
                                    Silakan selesaikan pembayaran untuk melanjutkan pesanan Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                    @elseif($order->payment_status === 'paid' && $order->shipping_status === 'processing')
                    <div class="p-5 rounded-xl border border-blue-300 bg-blue-50">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-blue-700 font-semibold mb-1">Pesanan Sedang Diproses</p>
                                <p class="text-sm text-blue-700">
                                    Pembayaran berhasil. Pesanan Anda sedang disiapkan untuk pengiriman.
                                </p>
                            </div>
                        </div>
                    </div>
                    @elseif($order->shipping_status === 'shipped')
                    <div class="p-5 rounded-xl border border-purple-300 bg-purple-50">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            <div>
                                <p class="text-sm text-purple-700 font-semibold mb-1">Pesanan Sedang Dikirim</p>
                                <p class="text-sm text-purple-700">
                                    Pesanan Anda sedang dalam perjalanan. Lacak paket dengan nomor resi di atas.
                                </p>
                            </div>
                        </div>
                    </div>
                    @elseif($order->shipping_status === 'completed')
                    <div class="p-5 rounded-xl border border-green-300 bg-green-50">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-green-700 font-semibold mb-1">Pesanan Selesai</p>
                                <p class="text-sm text-green-700">
                                    Terima kasih! Pesanan telah diterima. Semoga Anda puas dengan produk kami.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>

                <!-- RIGHT -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 sticky top-6">

                        <h2 class="font-bold text-xl pb-5 border-b border-gray-100">Ringkasan Pesanan</h2>

                        <!-- ITEMS -->
                        <div class="space-y-4 my-6 max-h-[300px] overflow-y-auto pr-2">
                            @foreach($order->orderItems as $item)
                            <div class="flex gap-4 pb-4 border-b border-[#E5E5E5] last:border-0">
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-16 h-16 rounded-lg object-cover border border-gray-200">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-sm text-gray-800">{{ $item->product->name }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                                    <p class="font-semibold text-primary text-sm mt-1">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- PRICE -->
                        <div class="border-t border-gray-200 pt-4 text-sm space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Ongkir</span>
                                <span>
                                    @if($order->shipping_cost > 0)
                                    Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                    @else
                                    <span class="text-yellow-600 font-medium">Belum ditentukan</span>
                                    @endif
                                </span>
                            </div>

                            <div class="flex justify-between font-bold text-primary text-lg pt-3 border-t border-gray-200">
                                <span>Total</span>
                                <span>Rp {{ number_format($order->subtotal + $order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-3">
                            @if($order->payment_status === 'paid')
                            <button disabled
                                class="w-full bg-green-500 text-white py-4 rounded-full font-semibold cursor-not-allowed opacity-75 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Sudah Dibayar
                            </button>
                            @elseif($order->payment_status === 'pending' && $order->shipping_cost > 0)
                            <button id="pay-button"
                                class="w-full bg-primary text-white py-4 rounded-full font-semibold hover:bg-primary/90 transition-all duration-300 shadow-md">
                                Bayar Sekarang
                            </button>
                            @endif

                            <a href="{{ url('/profile') }}"
                                class="block w-full bg-gray-100 text-gray-700 py-4 rounded-full font-semibold hover:bg-gray-200 transition-all duration-300 text-center">
                                Kembali ke Profil
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    @if($order->payment_status === 'pending' && isset($snapToken))
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.clientkey') }}">
    </script>

    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function(e) {
                e.preventDefault();

                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        window.location.href = "/checkout/success/{{ $order->order_number }}";
                    },
                    onPending: function(result) {
                        window.location.href = "/checkout/success/{{ $order->order_number }}";
                    },
                    onError: function(result) {
                        alert("Terjadi kesalahan pembayaran");
                        console.log(result);
                    }
                });
            });
        }
    </script>
    @endif

</body>

</html>