<nav class="fixed top-[30px] inset-x-0 max-w-[1280px] w-full mx-auto px-[75px] z-50">
  <div class="flex justify-between items-center w-full mx-auto bg-primary p-4 md:p-5 rounded-3xl relative">
    <!-- Logo -->
    <h1 class="text-2xl font-bold text-white tracking-wide">
      Furni<span>Style</span>
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
      class="hidden md:flex space-x-[25px] text-white font-normal absolute md:static bg-primary md:bg-transparent left-0 right-0 top-[70px] md:top-auto rounded-2xl md:rounded-none p-5 md:p-0 flex-col md:flex-row space-y-4 md:space-y-0">
      <li class="hover:text-secondary duration-300 transition-all"><a href="/">Home</a></li>
      <li class="hover:text-secondary duration-300 transition-all"><a href="{{ url('/#categories') }}">Kategori</a></li>
      <li class="hover:text-secondary duration-300 transition-all"><a href="{{ url('/#about') }}">Tentang Kami</a></li>
      <li class="hover:text-secondary duration-300 transition-all"><a href="{{ url('/#products') }}">Produk</a></li>
    </ul>

    <!-- Buttons -->
    <div class="hidden md:flex space-x-3 items-center">
      <!-- Cart Icon -->
      <a href="{{ route('cart.index') }}" class="relative p-3 text-black rounded-full bg-white font-semibold">
        <img src="{{ asset('assets/image/icons/bag-2.svg') }}" alt="Cart">
        @if(isset($cartCount) && $cartCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
          {{ $cartCount }}
        </span>
        @endif
      </a>

      @auth
      <!-- Jika sudah login -->
      <div class="relative flex items-center space-x-3">
        <!-- Tombol Icon Profile -->
        <button id="profileMenuButton"
          class="w-10 h-10 rounded-full bg-white flex items-center justify-center focus:outline-none hover:bg-gray-100 transition">
          <img src="{{ asset('assets/image/icons/user1.png') }}" alt="Profile Icon" class="w-6 h-6">
        </button>

        <!-- Dropdown Menu -->
        <div id="profileDropdown"
          class="hidden absolute right-0 top-12 bg-white border border-gray-200 rounded-xl shadow-md w-44 py-2 z-50">
          <a href="{{ route('profile') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
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

      <script>
        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');

        profileMenuButton.addEventListener('click', () => {
          profileDropdown.classList.toggle('hidden');
        });

        // Klik di luar dropdown -> tutup
        window.addEventListener('click', (e) => {
          if (!profileMenuButton.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.add('hidden');
          }
        });
      </script>
      @else
      <!-- Jika belum login -->
      <button onclick="window.location.href='{{ route('login') }}'"
        class="py-2 px-4 md:py-3 md:px-5 text-black rounded-full bg-white font-semibold hover:bg-gray-100 transition">
        Masuk
      </button>
      <button onclick="window.location.href='{{ route('register') }}'"
        class="py-2 px-4 md:py-3 md:px-5 text-black rounded-full bg-white font-semibold hover:bg-gray-100 transition">
        Daftar
      </button>
      @endauth

    </div>
  </div>

  <!-- Mobile dropdown overlay -->
  <script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    menuBtn.addEventListener('click', () => {
      menu.classList.toggle('hidden');
      menu.classList.toggle('flex');
    });
  </script>
</nav>