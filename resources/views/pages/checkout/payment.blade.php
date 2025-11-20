<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - CFP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-poppins">

    <main id="content" class="py-[50px]">
        <div class="max-w-[800px] mx-auto px-[30px] md:px-[75px]">

            <h1 class="text-2xl font-bold mb-6 text-center">Halaman Pembayaran</h1>

            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 md:p-8">
                <h2 class="font-bold text-xl mb-4">Detail Pesanan</h2>

                <div class="space-y-2 text-sm mb-6">
                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                    <p><strong>Nama:</strong> {{ $order->full_name }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    <p><strong>Status Pembayaran:</strong> {{ $order->payment_status }}</p>
                </div>

                <!-- Placeholder untuk metode pembayaran -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                    <select class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3">
                        <option>Transfer Bank (Placeholder)</option>
                        <option>E-Wallet (Placeholder)</option>
                    </select>
                </div>

                <!-- Form konfirmasi -->
                <form action="{{ route('payment.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-primary text-white py-4 rounded-full font-semibold hover:bg-primary/90 transition-all duration-300">
                        Konfirmasi Pembayaran
                    </button>
                </form>

                <p class="text-xs text-gray-500 mt-4 text-center">
                    Ini adalah halaman placeholder. Integrasi pembayaran nyata (misal Midtrans) bisa ditambahkan nanti.
                </p>
            </div>

        </div>
    </main>

</body>

</html>
