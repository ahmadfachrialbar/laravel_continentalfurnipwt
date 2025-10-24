<section id="products" class="max-w-[1280px] mx-auto w-full space-y-[30px] md:space-y-[30px] space-y-[20px] md:px-[75px] px-[20px]">
    <div class="flex items-center justify-between px-[55px]">
        <h1 class="font-bold text-2xl leading-[34px]">
            Produk Berkualitas <br />
            Kami
        </h1>
        <a href="{{ route('products.index') }}" class="rounded-full border py-3 px-6 font-semibold border-[#E5E5E5]">
            Jelajahi semua
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 md:gap-[30px] gap-4 px-[55px]">
        @forelse ($products as $product)
            <a href="{{ route('products.show', $product->slug) }}">
                <div class="p-5 rounded-[20px] border border-[#E5E5E5] space-y-6 hover:ring-2 transition-all duration-300 hover:ring-secondary hover:border-transparent">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mx-auto md:h-[90px] h-[80px]" />
                    <div class="space-y-[10px]">
                        <div class="space-y-1">
                            <h1 class="font-semibold leading-[22px]">{{ $product->name }}</h1>
                            <p class="text-sm leading-[21px]">{{ $product->category->name ?? '-' }}</p>
                        </div>
                        <p class="font-semibold text-primary leading-[22px]">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                <p class="text-lg font-medium">Belum ada produk yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</section>
