<nav class="fixed top-[30px] inset-x-0 max-w-[1280px] w-full mx-auto px-[75px] z-50">
  <div class="flex justify-between items-center w-full mx-auto bg-primary p-4 md:p-5 rounded-3xl relative">
    <!-- Logo -->
    <h1 class="text-2xl font-bold text-white tracking-wide">
      CFP
    </h1>

    <!-- Hamburger button (mobile) -->
    <button id="menu-btn" class="md:hidden text-white focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Nav Links -->
    <ul id="menu"
      class="hidden md:flex space-x-[25px] text-white font-normal absolute md:static bg-primary md:bg-transparent left-0 right-0 top-[70px] md:top-auto rounded-2xl md:rounded-none p-5 md:p-0 flex-col md:flex-row space-y-4 md:space-y-0 shadow-lg md:shadow-none">
      <li class="hover:text-secondary transition-all"><a href="/">Home</a></li>
      <li class="hover:text-secondary transition-all"><a href="{{ url('/#categories') }}">Kategori</a></li>
      <li class="hover:text-secondary transition-all"><a href="{{ url('/#about') }}">Tentang Kami</a></li>
      <li class="hover:text-secondary transition-all"><a href="{{ url('/#products') }}">Produk</a></li>

      <!-- Divider Mobile -->
      <li class="md:hidden"><div class="border-t border-white/30 my-2"></div></li>

      <!-- MOBILE: Cart -->
      <li class="md:hidden">
        <a href="{{ route('cart.index') }}"
           class="flex items-center justify-between p-3 bg-white/95 rounded-[15px] text-primary font-semibold hover:bg-white transition duration-300 shadow-sm">
          <span class="flex items-center gap-3">
            <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
              <img src="{{ asset('assets/image/icons/bag-2.svg') }}" alt="Cart" class="w-5 h-5">
            </div>
            <span>Keranjang</span>
          </span>
          @if(isset($cartCount) && $cartCount > 0)
            <span class="bg-red-500 text-white text-xs font-bold px-2 h-5 rounded-full flex items-center justify-center min-w-[20px]">
              {{ $cartCount }}
            </span>
          @endif
        </a>
      </li>

      @auth
      <!-- MOBILE: Profile -->
      <li class="md:hidden">
        <a href="{{ route('profile') }}"
           class="flex items-center gap-3 p-3 bg-white/95 rounded-[15px] text-primary font-semibold hover:bg-white transition duration-300 shadow-sm">
          <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
            <img src="{{ asset('assets/image/icons/user1.png') }}" alt="Profile" class="w-5 h-5">
          </div>
          <span>Lihat Profil</span>
        </a>
      </li>

      <!-- MOBILE: Logout -->
      <li class="md:hidden">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit"
            class="w-full flex items-center gap-3 p-3 bg-red-500/10 rounded-[15px] text-red-500 font-semibold hover:bg-red-500/20 transition duration-300 shadow-sm">
            <div class="w-8 h-8 bg-red-500/10 rounded-full flex items-center justify-center">
              <span class="text-lg">🚪</span>
            </div>
            <span>Keluar</span>
          </button>
        </form>
      </li>
      @else
      <!-- MOBILE: Login -->
      <li class="md:hidden">
        <button onclick="window.location.href='{{ route('login') }}'"
          class="w-full flex items-center gap-2 p-3 text-white bg-secondary rounded-[15px] font-semibold hover:bg-white hover:text-primary transition duration-300 shadow-sm">
          <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
          </div>
          <span class="flex-1 text-left">Masuk</span>
        </button>
      </li>

      <!-- MOBILE: Register -->
      <li class="md:hidden">
        <button onclick="window.location.href='{{ route('register') }}'"
          class="w-full flex items-center gap-2 p-3 text-white bg-secondary rounded-[15px] font-semibold hover:bg-white hover:text-primary transition duration-300 shadow-sm">
          <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
          </div>
          <span class="flex-1 text-left">Daftar</span>
        </button>
      </li>
      @endauth
    </ul>

    <!-- DESKTOP ACTIONS -->
    <div class="hidden md:flex space-x-3 items-center">
      <!-- Cart -->
      <a href="{{ route('cart.index') }}" class="relative p-3 text-black rounded-full bg-white font-semibold">
        <img src="{{ asset('assets/image/icons/bag-2.svg') }}" alt="Cart">
        @if(isset($cartCount) && $cartCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
          {{ $cartCount }}
        </span>
        @endif
      </a>

      @auth
      <!-- Profile dropdown -->
      <div class="relative flex items-center space-x-3">
        <button id="profileMenuButton"
          class="w-10 h-10 rounded-full bg-white flex items-center justify-center focus:outline-none hover:bg-gray-100 transition">
          <img src="{{ asset('assets/image/icons/user1.png') }}" alt="Profile Icon" class="w-6 h-6">
        </button>

        <!-- Dropdown -->
        <div id="profileDropdown"
          class="hidden absolute right-0 top-12 bg-white border border-gray-200 rounded-xl shadow-md w-44 py-2 z-50">
          <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
            👤 Lihat Profil
          </a>

          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
              class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 transition">
              🚪 Keluar
            </button>
          </form>
        </div>
      </div>
      @else
      <!-- Login / Register -->
      <button onclick="window.location.href='{{ route('login') }}'"
        class="py-2 px-4 text-black rounded-full bg-white font-semibold hover:bg-gray-100 transition">
        Masuk
      </button>
      <button onclick="window.location.href='{{ route('register') }}'"
        class="py-2 px-4 text-black rounded-full bg-white font-semibold hover:bg-gray-100 transition">
        Daftar
      </button>
      @endauth
    </div>
  </div>

  <!-- Mobile menu toggle -->
  <script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    menuBtn.addEventListener('click', () => {
      menu.classList.toggle('hidden');
      menu.classList.toggle('flex');
    });

    const profileMenuButton = document.getElementById('profileMenuButton');
    const profileDropdown = document.getElementById('profileDropdown');
    if (profileMenuButton) {
      profileMenuButton.addEventListener('click', () => {
        profileDropdown.classList.toggle('hidden');
      });
      window.addEventListener('click', (e) => {
        if (!profileMenuButton.contains(e.target) && !profileDropdown.contains(e.target)) {
          profileDropdown.classList.add('hidden');
        }
      });
    }
  </script>
</nav>
