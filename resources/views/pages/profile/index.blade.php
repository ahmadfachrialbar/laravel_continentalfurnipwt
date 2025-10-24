@extends('layouts.app')

@section('content')
<div class="max-w-[1280px] mx-auto px-[75px] py-[50px] mt-30">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-[30px]">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-5 space-y-2 sticky top-[160px] sidebar-scroll">
                <!-- User Info -->
                <div class="flex items-center gap-4 pb-6 border-b border-[#E5E5E5]">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-2xl font-bold text-white">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="font-semibold text-lg leading-[22px] truncate">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Menu -->
                <nav class="space-y-2">
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] bg-primary text-white font-semibold transition-all duration-300">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Alamat Saya</span>
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
                    <button class="text-primary font-semibold hover:text-secondary transition-colors">Edit Profil</button>
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

            <!-- Recent Orders -->
            <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-bold text-xl">Pesanan Saya</h2>
                    <a href="" class="text-primary font-semibold hover:text-secondary transition-colors">Lihat Detail</a>
                </div>

                <!-- Order Item -->
                <div class="space-y-4">
                    <!-- Order 1 -->
                    <div class="border border-[#E5E5E5] rounded-[15px] p-4 hover:border-secondary transition-all duration-300">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="text-sm text-gray-500">Order #12345</p>
                                <p class="text-xs text-gray-400">20 Oktober 2024</p>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-600 text-xs font-semibold rounded-full">Selesai</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <img src="./assets/image/thumbnails/meja1.png" alt="Product" class="w-16 h-16 object-cover rounded-[10px]">
                            <div class="flex-1">
                                <h3 class="font-semibold leading-[22px]">iMac Green Energy</h3>
                                <p class="text-sm text-gray-500">1 item</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-primary">Rp 24.000.000</p>
                                <button class="text-sm text-secondary hover:text-primary transition-colors mt-1">Beli Lagi</button>
                            </div>
                        </div>
                    </div>
                    <!-- Order 2 -->
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-5 text-center hover:border-secondary transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <p class="text-2xl font-bold">12</p>
                    <p class="text-sm text-gray-500">Total Pesanan</p>
                </div>

                <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-5 text-center hover:border-secondary transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-2xl font-bold">8</p>
                    <p class="text-sm text-gray-500">Selesai</p>
                </div>

                <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-5 text-center hover:border-secondary transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-2xl font-bold">3</p>
                    <p class="text-sm text-gray-500">Diproses</p>
                </div>

                <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-5 text-center hover:border-secondary transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <p class="text-2xl font-bold">1</p>
                    <p class="text-sm text-gray-500">Dibatalkan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Bottom Navigation (only visible on mobile) -->
<div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-[#E5E5E5] px-4 py-3 z-50">
    <div class="flex items-center justify-around">
        <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 text-primary">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-xs font-semibold">Profil</span>
        </a>
        <a href="" class="flex flex-col items-center gap-1 text-gray-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="text-xs font-semibold">Pesanan</span>
        </a>
        <a href="" class="flex flex-col items-center gap-1 text-gray-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <span class="text-xs font-semibold">Wishlist</span>
        </a>
        <a href="" class="flex flex-col items-center gap-1 text-gray-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="text-xs font-semibold">Pengaturan</span>
        </a>
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