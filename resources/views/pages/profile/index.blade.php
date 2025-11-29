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

                    <a href="" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-gray-50 font-semibold transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <span>Ulasan Saya</span>
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
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6">
                <h2 class="font-bold text-xl mb-6 pb-5">Pesanan Saya</h2>

                @if ($orders->isEmpty())
                <p class="text-gray-500">Anda belum memiliki pesanan.</p>
                @else
                <div class="space-y-6">
                    @foreach ($orders as $order)
                    <div class="border border-gray-200 rounded-xl p-5">
                        <div class="flex justify-between items-center mb-3">
                            <p class="font-semibold text-lg">
                                Order #{{ $order->order_number }}
                            </p>
                            <span class="text-sm px-3 py-1 rounded-full
                            @if($order->status === 'completed') bg-green-100 text-green-700
                            @elseif($order->status === 'processing') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($order->shipping_status) }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mb-4">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>

                        <div class="space-y-3">
                            @foreach ($order->orderItems as $item)
                            <div class="flex justify-between text-sm">
                                <p class="text-gray-700">
                                    {{ $item->product->name }} × {{ $item->quantity }}
                                </p>
                                <p class="font-semibold">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t flex justify-between font-semibold">
                            <span>Ongkir</span>
                            <span>
                                @if($order->shipping_cost > 0)
                                Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                @else
                                <span class="text-yellow-600 font-medium">Belum ditentukan</span>
                                @endif
                            </span>
                        </div>
                        <div class="border-t flex justify-between font-semibold">
                            <p>Total</p>
                            <span>Rp {{ number_format($order->subtotal + $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>

                        <div class="border-t pt-3 mt-3 flex justify-between font-semibold">
                            <p>Status Pembayaran</p>
                            <span class="text-sm px-3 py-1 rounded-full
                            @if($order->payment_status === 'paid') bg-green-100 text-green-700
                            @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>

                        @if($order->payment_status === 'pending')
                        <a href="{{ route('order.review', $order->id) }}"
                            class="justify-between block w-fit bg-red-500 text-white px-4 py-0 rounded-full font-semiboldhover:bg-red-600 transition-all duration-300">
                            Bayar Sekarang
                        </a>

                        @elseif($order->payment_status === 'paid')
                        @elseif($order->payment_status === 'failed')
                        @endif





                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            @include('pages.profile.components.rating')

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