<section class="max-w-[1280px] mx-auto w-full space-y-[30px] md:space-y-[30px] space-y-[20px] md:px-[75px] px-[20px] md:py-[50px] py-[30px]">
    <!-- Header -->
    <div class="flex items-center justify-between px-[55px]">
        <div>
            <h1 class="font-bold text-2xl leading-[34px]">
                Ulasan pelanggan
            </h1>
            <p class="text-sm leading-[24px] text-gray-600 mt-2">
                Apa kata pelanggan kami tentang produk kami
            </p>
        </div>
        
        <!-- Navigation Buttons -->
        <div class="hidden md:flex gap-3">
            <button onclick="prevSlide()" class="w-12 h-12 rounded-full border border-[#E5E5E5] flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button onclick="nextSlide()" class="w-12 h-12 rounded-full border border-[#E5E5E5] flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Reviews Grid -->
    <div id="reviewsContainer" class="grid md:grid-cols-3 grid-cols-1 md:gap-[30px] gap-4 px-[55px]">
        <!-- Review Card Template - Isi dengan data dari backend -->
        <div class="review-card md:p-8 p-6 rounded-[20px] border border-[#E5E5E5] space-y-4 hover:ring-2 transition-all duration-300 hover:ring-secondary hover:border-transparent flex flex-col">
            <!-- Rating Stars -->
            <div class="flex gap-1">
                <svg class="w-5 h-5 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="w-5 h-5 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="w-5 h-5 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="w-5 h-5 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="w-5 h-5 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>

            <!-- Review Text -->
            <p class="text-sm leading-[24px] text-gray-600 flex-grow">
                "Ulasan pelanggan akan ditampilkan di sini"
            </p>

            <!-- Product Name -->
            <p class="text-xs leading-[18px] text-gray-500 font-medium">
                Produk: Nama Produk
            </p>

            <!-- Divider -->
            <div class="border-t border-[#E5E5E5]"></div>

            <!-- Customer Info -->
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold leading-[22px]">Nama Pelanggan</h3>
                    <p class="text-xs leading-[18px] text-gray-500">Tanggal</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <span class="text-primary font-semibold text-sm">N</span>
                </div>
            </div>
        </div>

        <!-- Tambahkan card lainnya dari loop backend -->
    </div>

    <!-- Mobile Navigation -->
    <div class="flex md:hidden justify-center gap-3 px-[55px]">
        <button onclick="prevSlide()" class="w-12 h-12 rounded-full border border-[#E5E5E5] flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button onclick="nextSlide()" class="w-12 h-12 rounded-full border border-[#E5E5E5] flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>

    <!-- Pagination Dots -->
    <div id="paginationDots" class="flex justify-center gap-2 px-[55px]">
        <button onclick="goToSlide(0)" class="h-2 w-8 rounded-full bg-primary transition-all duration-300"></button>
        <button onclick="goToSlide(1)" class="h-2 w-2 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300"></button>
    </div>

    <!-- Overall Stats -->
    <div class="grid md:grid-cols-3 grid-cols-1 md:gap-[30px] gap-4 px-[55px]">
        <div class="md:p-6 p-5 rounded-[20px] border border-[#E5E5E5] text-center space-y-2 hover:ring-2 transition-all duration-300 hover:ring-secondary hover:border-transparent">
            <h3 class="font-bold md:text-3xl text-2xl text-primary md:leading-[40px] leading-[32px]">4.9</h3>
            <p class="text-sm leading-[21px] text-gray-600">Rating Rata-rata</p>
            <div class="flex justify-center gap-1 mt-2">
                <svg class="w-4 h-4 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="w-4 h-4 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="w-4 h-4 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="w-4 h-4 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="w-4 h-4 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
        </div>

        <div class="md:p-6 p-5 rounded-[20px] border border-[#E5E5E5] text-center space-y-2 hover:ring-2 transition-all duration-300 hover:ring-secondary hover:border-transparent">
            <h3 class="font-bold md:text-3xl text-2xl text-primary md:leading-[40px] leading-[32px]">98%</h3>
            <p class="text-sm leading-[21px] text-gray-600">Pelanggan Puas</p>
        </div>

        <div class="md:p-6 p-5 rounded-[20px] border border-[#E5E5E5] text-center space-y-2 hover:ring-2 transition-all duration-300 hover:ring-secondary hover:border-transparent">
            <h3 class="font-bold md:text-3xl text-2xl text-primary md:leading-[40px] leading-[32px]">2.5K+</h3>
            <p class="text-sm leading-[21px] text-gray-600">Total Ulasan</p>
        </div>
    </div>
</section>

<script>
    let currentSlide = 0;
    const totalSlides = 2; // Update sesuai jumlah slide dari backend

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlide();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateSlide();
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlide();
    }

    function updateSlide() {
        const dots = document.querySelectorAll('#paginationDots button');
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.className = 'h-2 w-8 rounded-full bg-primary transition-all duration-300';
            } else {
                dot.className = 'h-2 w-2 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300';
            }
        });
        
        // Tambahkan logika carousel sesuai kebutuhan
    }
</script>