@props(['categories'])

<section id="categories" class="max-w-[1280px] mx-auto w-full space-y-[30px] md:space-y-[30px] space-y-[20px] md:px-[75px] px-[20px]">
    <div class="flex items-center justify-between px-[55px]">
        <h1 class="font-bold text-2xl leading-[34px]">
            Cari produk <br />
            berdasarkan kategori
        </h1>
    </div>

    <div class="grid md:grid-cols-4 sm:grid-cols-2 grid-cols-1 md:gap-[30px] gap-4 px-[55px]">
        @forelse ($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}">
                <div class="rounded-[20px] border border-[#E5E5E5] p-5 space-x-[14px] flex items-center hover:ring-2 transition-all duration-300 hover:ring-secondary hover:border-transparent">
                    <div class="h-12 w-12 bg-primary grid place-items-center rounded-full flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                            <text x="12" y="16" text-anchor="middle" font-size="10" fill="white">
                                {{ strtoupper(substr($category->name, 0, 1)) }}
                            </text>
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        <h1 class="font-semibold">{{ $category->name }}</h1>
                        <p class="text-sm text-[#616369]">{{ $category->products_count }} produk</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                <p class="text-lg font-medium">Belum ada kategori yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</section>
