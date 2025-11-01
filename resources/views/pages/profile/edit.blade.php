@extends('layouts.app')

@section('content')
<div class="max-w-[1280px] mx-auto px-[75px] py-[50px] mt-30">
    <div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6">
        <h2 class="font-bold text-xl mb-6">Edit Profil</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm text-gray-500 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-500 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-500 mb-1">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('profile') }}" class="text-gray-500 hover:text-primary">Batal</a>
                <button type="submit" class="bg-primary text-white px-5 py-2 rounded-lg hover:bg-secondary transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
