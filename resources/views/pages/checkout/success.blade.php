<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - CFP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-poppins">

    <main id="content" class="min-h-screen flex items-center justify-center py-[50px] px-4">
        <div class="max-w-[600px] w-full">

            <!-- Success Card -->
            <div class="bg-white rounded-[30px] border border-[#E5E5E5] p-8 md:p-12 text-center shadow-lg">

                <!-- Success Icon -->
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="font-bold text-2xl md:text-3xl text-gray-800 mb-3">
                    Pembayaran Berhasil!
                </h1>

                <!-- Description -->
                <p class="text-gray-600 mb-2">
                    Terima kasih telah berbelanja di CFP
                </p>
                <p class="text-sm text-gray-500 mb-8">
                    Pesanan Anda sedang diproses dan akan segera dikirim
                </p>

                <!-- Order Info -->
                <div class="bg-gray-50 rounded-[20px] p-6 mb-8 text-left">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nomor Pesanan</span>
                            <span class="font-semibold text-primary">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Pembayaran</span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($order->subtotal + $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="font-semibold text-green-600">Dibayar</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <!-- Primary Button -->
                    <a href="{{ url('/profile') }}" 
                        class="block w-full bg-primary text-white py-4 rounded-full font-semibold hover:bg-primary/90 transition-all duration-300 shadow-md hover:shadow-lg">
                        Lihat Pesanan Saya
                    </a>

                    <!-- Secondary Button -->
                    <a href="{{ url('/') }}" 
                        class="block w-full bg-white text-primary py-4 rounded-full font-semibold border-2 border-primary hover:bg-gray-50 transition-all duration-300">
                        Kembali ke Beranda
                    </a>
                </div>

                <!-- Additional Info -->
            </div>

            <!-- Help Section -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Ada pertanyaan? 
                    <a href="https://wa.me/6285880232466" 
                        class="text-primary font-semibold hover:underline">
                        Hubungi Kami
                    </a>
                </p>
            </div>

        </div>
    </main>

</body>

</html>