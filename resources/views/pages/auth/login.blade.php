@extends('layouts.auth')
@section('content')
<section
  class="min-h-screen h-screen w-screen flex items-center justify-center bg-cover bg-center bg-no-repeat relative overflow-hidden"
  style="background-image: url('{{ asset('assets/image/backgrounds/loreg1.jpg') }}');"
  >
  <div class="absolute inset-0 bg-black/40"></div>

  <!-- Container Utama -->
  <div class="relative z-10 w-full max-w-[1100px] px-5 sm:px-10 flex justify-center items-center">

    <!-- Card Login -->
    <div class="bg-white/90 backdrop-blur-md shadow-2xl rounded-[25px] p-6 sm:p-8 lg:p-10 border border-[#E5E5E5] w-full max-w-md">

      <!-- Logo & Title -->
      <div class="text-center mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-2">FurniStyle</h1>
        <p class="text-gray-600 text-sm">Masuk ke akun Anda</p>
      </div>

      <!-- Login Form -->
      <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <!-- ALERT -->
        @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">
          {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 text-sm">
          {{ $errors->first() }}
        </div>
        @endif

        <!-- Email -->
        <div class="mb-5">
          <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
          <input id="email" name="email" type="email" placeholder="nama@email.com"
            value="{{ old('email') }}" required
            class="w-full border border-[#8B5E3C] rounded-full px-5 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B5E3C] focus:border-transparent transition-all duration-300" />
        </div>

        <!-- Password -->
        <div class="mb-6">
          <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
          <input id="password" name="password" type="password" placeholder="Masukkan password" required
            class="w-full border border-[#8B5E3C] rounded-full px-5 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B5E3C] focus:border-transparent transition-all duration-300" />
        </div>

        <button type="submit"
          class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl mb-4">
          Masuk
        </button>
        <div class="text-center text-sm text-gray-600 pt-6">
          Belum punya akun?
          <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">Daftar Sekarang</a>
        </div>
      </form>
    </div>

  </div>
</section>

<style>
  html,
  body {
    height: 100%;
    overflow: hidden;
    /* agar tidak scroll */
  }
</style>
@endsection