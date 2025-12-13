@extends('layouts.app')

@section('content')
<section id="product-detail" class="max-w-[1280px] mx-auto w-full px-6 md:px-[75px] py-[30px] pt-[170px] pb-[50px]">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-[40px] md:gap-[60px] items-center ml-[40px] mr-[40px]">

        <!-- Gambar Produk -->
        <div class="sticky top-[100px]">
            <div class="relative bg-gradient-to-br from-[#F9F9F9] to-[#F3F4F6] p-8 md:p-10 rounded-[24px] border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300">
                <!-- Badge Premium -->
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm">
                    <span class="text-xs font-semibold text-primary">Premium Quality</span>
                </div>
                <img src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    class="h-[250px] md:h-[380px] object-contain mx-auto hover:scale-105 transition-transform duration-500">
            </div>
        </div>

        <!-- Deskripsi Produk -->
        <div class="space-y-6">
            <h1 class="text-3xl md:text-4xl font-bold text-primary leading-tight">
                {{ $product->name }}
            </h1>

            <p class="text-gray-600 text-base md:text-lg leading-relaxed">
                {{ $product->description }}
            </p>

            <div class="flex items-center space-x-4">
                <span class="text-2xl md:text-3xl font-semibold text-primary">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            </div>

            <!-- Stok Produk -->
            <div class="flex items-center gap-2">
                <span class="text-gray-700 font-medium">Stok:</span>
                <span class="text-gray-600">
                    {{ $product->stock > 0 ? $product->stock : 'Habis' }}
                </span>
            </div>

            <div class="flex flex-wrap gap-4 pt-4">
                <a href="{{ route('cart.add', $product->id) }}"
                    class="px-6 py-3 bg-primary text-white font-semibold rounded-full 
                  hover:bg-secondary transition-all duration-300">
                    Add to Cart
                </a>

                <a href="{{ route('cart.add', $product->id) }}"
                    class="px-6 py-3 border-2 border-primary text-primary font-semibold rounded-full 
                  hover:bg-primary hover:text-white transition-all duration-300">
                    Buy Now
                </a>
            </div>

            <!-- Category -->
            <div class="pt-8 border-t border-gray-200 space-y-3">
                <h2 class="text-lg font-semibold text-gray-800">Kategori</h2>
                <p class="text-gray-600">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </p>
            </div>
        </div>

    </div>

    <!-- Produk Lainnya -->
    <div class="space-y-[30px] mt-[40px] ml-[40px] mr-[40px]">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-bold text-2xl leading-[34px]">Produk lainnya</h2>
            <a href="{{ route('products.index') }}"
                class="rounded-full border py-3 px-6 font-semibold border-[#E5E5E5]
                      hover:bg-primary hover:text-white hover:border-primary 
                      transition-all duration-300">
                Continue Shopping
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-[20px] md:gap-[30px]">
            @foreach ($relatedProducts as $item)
            <a href="{{ route('products.show', $item->slug) }}" class="block">
                <div class="p-5 rounded-[20px] border border-[#E5E5E5] space-y-6 
                                hover:ring-2 hover:ring-secondary hover:border-transparent 
                                transition-all duration-300">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                        class="mx-auto h-[90px] object-contain" />
                    <div class="space-y-[10px]">
                        <div class="space-y-1">
                            <h1 class="font-semibold leading-[22px]">{{ $item->name }}</h1>
                            <p class="text-sm leading-[21px] text-gray-500">{{ $item->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <p class="font-semibold text-primary leading-[22px]">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection