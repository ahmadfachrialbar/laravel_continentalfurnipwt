<!-- Ulasan saya -->
<div class="bg-white rounded-[20px] border border-[#E5E5E5] p-6 space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="font-bold text-xl">Ulasan Saya</h2>
        <button onclick="openAddReviewModal()" class="rounded-full border py-2 px-5 text-sm font-semibold border-[#E5E5E5] hover:bg-primary hover:text-white hover:border-primary transition-all duration-300">
            + Tambah Ulasan
        </button>
    </div>

    <!-- Daftar Ulasan -->
    <div class="space-y-4">
        <!-- Review Card 1 - Loop dari backend -->
        <div class="p-5 rounded-[20px] border border-[#E5E5E5] space-y-4 hover:ring-2 transition-all duration-300 hover:ring-secondary hover:border-transparent">
            <div class="flex items-start justify-between">
                <div class="flex-1 space-y-3">
                    <!-- Rating & Date -->
                    <div class="flex items-center gap-4">
                        <div class="flex gap-1">
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
                        <span class="text-xs text-gray-500">15 November 2024</span>
                    </div>

                    <!-- Product Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="https://placehold.co/64x64" alt="Product" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="font-semibold text-sm leading-[22px]">Kursi Kantor Ergonomis</h3>
                            <p class="text-xs text-gray-500">Furnitur - Kursi</p>
                        </div>
                    </div>

                    <!-- Review Text -->
                    <p class="text-sm leading-[24px] text-gray-600">
                        Kualitas furnitur sangat bagus dan sesuai dengan deskripsi. Pengiriman cepat dan packaging rapi. Sangat puas dengan kursi kantor yang saya beli!
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2 ml-4">
                    <button onclick="openEditReviewModal(1)" class="w-8 h-8 rounded-full border border-[#E5E5E5] flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all duration-300" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button onclick="confirmDelete(1)" class="w-8 h-8 rounded-full border border-[#E5E5E5] flex items-center justify-center hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-300" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Jika tidak ada ulasan - Tampilkan ini -->
        <!-- <p class="text-gray-500 text-center py-8">Anda belum memiliki ulasan.</p> -->
    </div>
</div>

<!-- Modal Tambah/Edit Ulasan -->
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[20px] max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-xl" id="modalTitle">Tambah Ulasan</h3>
                <button onclick="closeReviewModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form id="reviewForm" action="" method="POST" class="space-y-5">
                <!-- CSRF Token - Tambahkan sesuai Laravel -->
                <!-- @csrf -->

                <!-- Pilih Produk -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold">Produk <span class="text-red-500">*</span></label>
                    <select name="product_id" required class="w-full px-4 py-3 rounded-[12px] border border-[#E5E5E5] focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                        <option value="">Pilih Produk</option>
                        <option value="1">Kursi Kantor Ergonomis</option>
                        <option value="2">Meja Makan Minimalis</option>
                        <option value="3">Sofa 3 Dudukan</option>
                    </select>
                </div>

                <!-- Rating -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold">Rating <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <input type="radio" name="rating" value="1" id="star1" class="hidden" required>
                        <label for="star1" onclick="setRating(1)" class="cursor-pointer">
                            <svg class="w-8 h-8 star-icon text-gray-300 hover:text-yellow-400 transition-colors duration-200" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </label>
                        
                        <input type="radio" name="rating" value="2" id="star2" class="hidden">
                        <label for="star2" onclick="setRating(2)" class="cursor-pointer">
                            <svg class="w-8 h-8 star-icon text-gray-300 hover:text-yellow-400 transition-colors duration-200" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </label>
                        
                        <input type="radio" name="rating" value="3" id="star3" class="hidden">
                        <label for="star3" onclick="setRating(3)" class="cursor-pointer">
                            <svg class="w-8 h-8 star-icon text-gray-300 hover:text-yellow-400 transition-colors duration-200" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </label>
                        
                        <input type="radio" name="rating" value="4" id="star4" class="hidden">
                        <label for="star4" onclick="setRating(4)" class="cursor-pointer">
                            <svg class="w-8 h-8 star-icon text-gray-300 hover:text-yellow-400 transition-colors duration-200" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </label>
                        
                        <input type="radio" name="rating" value="5" id="star5" class="hidden">
                        <label for="star5" onclick="setRating(5)" class="cursor-pointer">
                            <svg class="w-8 h-8 star-icon text-gray-300 hover:text-yellow-400 transition-colors duration-200" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </label>
                    </div>
                </div>

                <!-- Ulasan -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold">Ulasan <span class="text-red-500">*</span></label>
                    <textarea name="review" rows="5" required placeholder="Tulis ulasan Anda tentang produk ini..." class="w-full px-4 py-3 rounded-[12px] border border-[#E5E5E5] focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 resize-none"></textarea>
                    <p class="text-xs text-gray-500">Minimal 20 karakter</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeReviewModal()" class="flex-1 rounded-full border py-3 px-6 font-semibold border-[#E5E5E5] hover:bg-gray-50 transition-all duration-300">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-full py-3 px-6 font-semibold bg-primary text-white hover:bg-primary/90 transition-all duration-300">
                        Simpan Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[20px] max-w-md w-full p-6 space-y-5">
        <div class="text-center space-y-3">
            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-xl">Hapus Ulasan?</h3>
            <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus ulasan ini? Tindakan ini tidak dapat dibatalkan.</p>
        </div>

        <form id="deleteForm" action="" method="POST" class="flex gap-3">
            <!-- @csrf @method('DELETE') -->
            <button type="button" onclick="closeDeleteModal()" class="flex-1 rounded-full border py-3 px-6 font-semibold border-[#E5E5E5] hover:bg-gray-50 transition-all duration-300">
                Batal
            </button>
            <button type="submit" class="flex-1 rounded-full py-3 px-6 font-semibold bg-red-500 text-white hover:bg-red-600 transition-all duration-300">
                Hapus
            </button>
        </form>
    </div>
</div>

<script>
    // Modal Functions
    function openAddReviewModal() {
        document.getElementById('reviewModal').classList.remove('hidden');
        document.getElementById('reviewModal').classList.add('flex');
        document.getElementById('modalTitle').textContent = 'Tambah Ulasan';
        document.getElementById('reviewForm').reset();
        resetStarRating();
    }

    function openEditReviewModal(reviewId) {
        document.getElementById('reviewModal').classList.remove('hidden');
        document.getElementById('reviewModal').classList.add('flex');
        document.getElementById('modalTitle').textContent = 'Edit Ulasan';
        
        // Load data ulasan dari backend dan isi form
        // Contoh: fetch data dan isi form
        // setRating(5); // Set rating yang sudah ada
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
        document.getElementById('reviewModal').classList.remove('flex');
    }

    function confirmDelete(reviewId) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
        // Set action form delete dengan ID ulasan
        // document.getElementById('deleteForm').action = '/reviews/' + reviewId;
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    // Rating Functions
    function setRating(rating) {
        const stars = document.querySelectorAll('.star-icon');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('fill-yellow-400', 'text-yellow-400');
            } else {
                star.classList.add('text-gray-300');
                star.classList.remove('fill-yellow-400', 'text-yellow-400');
            }
        });
    }

    function resetStarRating() {
        const stars = document.querySelectorAll('.star-icon');
        stars.forEach(star => {
            star.classList.add('text-gray-300');
            star.classList.remove('fill-yellow-400', 'text-yellow-400');
        });
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const reviewModal = document.getElementById('reviewModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (event.target === reviewModal) {
            closeReviewModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }
</script>