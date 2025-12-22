@extends('layouts.app')

@section('content')
<div class="max-w-[1280px] mx-auto px-[75px] py-[50px] mt-30">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-[30px]">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-5 space-y-2 sticky top-[160px] sidebar-scroll">
                <!-- User Info -->
                <div class="flex items-center gap-4 pb-6 border-b border-[#E5E5E5]">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-2xl font-bold text-primary">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="font-semibold text-lg leading-[22px] truncate">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Menu -->
                <nav class="space-y-2">
                    <a href="" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-gray-50 font-semibold transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Akun Saya</span>
                    </a>

                    <a href="" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-gray-50 font-semibold transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>Pesanan Saya</span>
                    </a>

                    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-red-50 text-red-500 font-semibold transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-[30px]">
            <!-- Account Info -->
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-bold text-xl">Informasi Akun</h2>
                    <a href="{{ route('profile.edit') }}" class="text-primary font-semibold hover:text-secondary transition-colors">Edit Profil</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                        <p class="font-semibold">{{ $user->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-semibold">{{ $user->email }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Nomor Telepon</p>
                        <p class="font-semibold">{{ $user->phone ?? 'Belum diisi' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Tanggal Bergabung</p>
                        <p class="font-semibold">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- pesanan saya -->
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 md:p-8">
                <h2 class="font-bold text-xl mb-6 pb-5 border-b border-gray-100">Pesanan Saya</h2>

                @if ($orders->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <p class="text-gray-500 text-lg">Anda belum memiliki pesanan.</p>
                    <a href="{{ url('/products') }}" class="inline-block mt-4 text-primary font-semibold hover:underline">
                        Mulai Belanja
                    </a>
                </div>
                @else
                <div class="space-y-6">
                    @foreach ($orders as $order)
                    <div class="border border-gray-200 rounded-xl p-5 md:p-6 hover:border-primary/30 transition-all duration-300">

                        <!-- Header Order -->
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-3">
                            <div>
                                <p class="font-bold text-lg text-gray-800">
                                    Order #{{ $order->order_number }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <!-- Status Pengiriman -->
                                <span class="text-xs px-3 py-1.5 rounded-full font-medium
                        @if($order->shipping_status === 'completed') bg-green-100 text-green-700
                        @elseif($order->shipping_status === 'processing') bg-blue-100 text-blue-700
                        @elseif($order->shipping_status === 'shipped') bg-purple-100 text-purple-700
                        @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($order->shipping_status) }}
                                </span>
                                <!-- Status Pembayaran -->
                                <span class="text-xs px-3 py-1.5 rounded-full font-medium
                        @if($order->payment_status === 'paid') bg-green-100 text-green-700
                        @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-700
                        @elseif($order->payment_status === 'failed') bg-red-100 text-red-700
                        @else bg-gray-100 text-gray-700 @endif">
                                    {{ $order->payment_status === 'paid' ? 'Dibayar' : ($order->payment_status === 'pending' ? 'Menunggu Pembayaran' : ucfirst($order->payment_status)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Items List -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="space-y-3">
                                @foreach ($order->orderItems as $item)
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex items-center gap-3 flex-1">
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                        <div class="flex-1">
                                            <p class="text-gray-800 font-medium">{{ $item->product->name }}</p>
                                            
                                            <p class="text-gray-500 text-xs">Qty: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <p class="font-semibold text-primary">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div class="space-y-2 mb-4 text-sm">
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
                            <div class="flex justify-between font-bold text-lg text-primary pt-2 border-t border-gray-200">
                                <span>Total</span>
                                <span>Rp {{ number_format($order->subtotal + $order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">


                            <!-- Bayar Sekarang (jika pending) -->
                            @if($order->payment_status === 'pending')
                            <a href="{{ route('order.review', $order->id) }}"
                                class="flex-1 min-w-[160px] text-center bg-primary text-white px-4 py-2.5 rounded-full font-semibold hover:bg-primary/90 transition-all duration-300 shadow-md">
                                Bayar Sekarang
                            </a>
                            @elseif($order->payment_status === 'paid')
                            <a href="{{ route('order.detail', $order->id) }}"
                                class="flex-1 min-w-[160px] text-center bg-primary text-white px-4 py-2.5 rounded-full font-semibold hover:bg-primary/90 transition-all duration-300 shadow-md">
                                Lihat Detail
                            </a>
                            @endif

                            

                            
                        </div>

                    </div>
                    @endforeach
                </div>

                

                @endif
            </div>

        </div>
    </div>
</div>


@endsection

<style>
    /* Custom scrollbar for sidebar on desktop */
    @media (min-width: 1024px) {
        .sidebar-scroll {
            max-height: calc(100vh - 100px);
            overflow-y: auto;
            padding-top: 50px;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #E5E5E5;
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #4ECDC4;
        }
    }

    /* Prevent content from being hidden behind mobile bottom nav */
    @media (max-width: 1023px) {
        body {
            padding-bottom: 80px;
        }
    }

    /* Smooth transitions */
    * {
        transition-property: color, background-color, border-color;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>