@extends('layouts.app')

@section('content')
<section class="max-w-[1280px] mx-auto w-full px-5 sm:px-10 md:px-[50px] lg:px-[75px] py-[50px] pt-[140px] md:pt-[170px]">
    <div class="space-y-[30px]">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 ml-[40px] mr-[40px] ">
            <h1 class="font-bold text-xl sm:text-2xl md:text-3xl leading-tight text-center md:text-left">
                Semua Produk <br class="block md:hidden" />
                Dari Toko Kami
            </h1>

            <div class="flex flex-wrap justify-center md:justify-end gap-3">
                <select
                    class="rounded-full border border-[#E5E5E5] py-2 sm:py-3 px-4 sm:px-6 text-sm sm:text-base font-semibold bg-white cursor-pointer hover:border-secondary transition-colors"
                    onchange="if (this.value) window.location.href=this.value">
                    <option value="{{ route('products.index') }}"
                        {{ is_null($categoryActive) ? 'selected' : '' }}>
                        Semua kategori
                    </option>
                    @foreach ($categories as $category)
                    <option value="{{ route('products.byCategory', $category->slug) }}"
                        {{ isset($categoryActive) && $categoryActive->id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>

            </div>
        </div>


        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6 md:gap-[30px] ml-[40px] mr-[40px]">
            @forelse ($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="group">
                <div
                    class="p-4 sm:p-5 rounded-[20px] border border-[#E5E5E5] space-y-4 sm:space-y-6 hover:ring-2 transition-all duration-300 hover:ring-secondary hover:border-transparent bg-white">
                    <img src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="mx-auto h-[70px] sm:h-[90px] object-contain" />
                    <div class="space-y-[6px] sm:space-y-[10px] text-center sm:text-left">
                        <div class="space-y-1">
                            <h1 class="font-semibold leading-[20px] sm:leading-[22px] text-sm sm:text-base">{{ $product->name }}</h1>
                            <p class="text-xs sm:text-sm leading-[18px] sm:leading-[21px] text-gray-500">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </p>
                        </div>
                        <p class="font-semibold text-primary leading-[22px] text-sm sm:text-base">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </a>
            @empty
            <p class="text-center text-gray-500 col-span-full">Belum ada produk tersedia.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-center mt-6">
            {{ $products->links() }}
        </div>
    </div>
</section>
@endsection