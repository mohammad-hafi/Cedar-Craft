<x-layout>
    <section class="relative overflow-hidden bg-gradient-to-br from-emerald-900 to-emerald-700 px-4 py-16 text-white">
    <div class="pointer-events-none absolute inset-0    ">
      <span class="absolute text-5xl tree tree-1">🌲</span>
      <span class="absolute text-5xl tree tree-2">🌲</span>
      <span class="absolute text-5xl tree tree-3">🌲</span>
      <span class="absolute text-5xl tree tree-4">🌲</span>
      <span class="absolute text-5xl tree tree-5">🌲</span>
      <span class="absolute text-5xl tree tree-6">🌲</span>
      <span class="absolute text-5xl tree tree-7">🌲</span>
      <span class="absolute text-5xl tree tree-8">🌲</span>
      <span class="absolute text-5xl tree tree-9">🌲</span>
      <span class="absolute text-5xl tree tree-10">🌲</span>
    </div>

    <div class="relative z-10 mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 md:grid-cols-2">
      <div class="hero-left">
        
        <h1 class="text-4xl font-extrabold leading-tight md:text-5xl">{{ setting('intro') }}</h1>
        
        <p class="mt-4 text-lg text-white/90">{{ setting('description') }}</p>
        <a href="/shop" class="mt-8 inline-block rounded-full bg-amber-400 px-10 py-4 text-sm font-extrabold uppercase tracking-wider text-emerald-950 shadow hover:bg-amber-300">
          Shop Now
        </a>
      </div>

      <div class="hero-right flex justify-center md:justify-end">
        <div class="cube relative h-64 w-64 rounded-2xl bg-gradient-to-br from-amber-200 to-amber-500 shadow-2xl">
          <div class="grain absolute inset-0 rounded-2xl opacity-20"></div>
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="cedar text-7xl">🌲</div>
          </div>
        </div>
      </div>
    </div> 
    </section>  
    @if($products->count() > 0)
@php $totalSlides = max(1, $products->count() - 2); @endphp
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">Featured Products</h2>

            <div class="relative" x-data="{ current: 0, totalSlides: {{ $totalSlides }}, visible: 3, interval: null }" x-init="interval = setInterval(() => current = (current + 1) % totalSlides, 2500)" @mouseenter="clearInterval(interval); interval = null" @mouseleave="if (!interval) interval = setInterval(() => current = (current + 1) % totalSlides, 2500)">
                <!-- Slider Container -->
                <div class="overflow-hidden rounded-2xl">
                    <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${current * (100 / 3)}%)`">
                        @foreach($products as $index => $product)
                        <div class="w-1/3 flex-shrink-0 px-2">
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full">
                                <!-- IMAGE SLIDER -->
                                <div class="relative bg-gray-50 overflow-hidden h-48"
                                     x-data="{
                                        index: 0,
                                        images: @js($product->images->pluck('image')),
                                       }">
                                    <!-- Images -->
                                    <template x-for="(img, i) in images" :key="i">
                                      <img 
                                        x-show="index === i"
                                        x-transition.opacity
                                        :src="'/storage/' + img"
                                        class="w-full h-full object-cover"
                                      >
                                    </template>
                                    <!-- Category Badge -->
                                    <div class="absolute top-3 left-3">
                                      <span class="px-3 py-1 text-xs font-semibold bg-emerald-600 text-white rounded-full shadow">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                      </span>
                                    </div>
                                </div>

                                <!-- CONTENT -->
                                <div class="p-4">
                                    <!-- Title + Price -->
                                    <div class="flex items-start justify-between gap-2 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 line-clamp-1">
                                            {{ $product->name }}
                                        </h3>
                                        <span class="text-xl font-bold text-emerald-700">
                                            ${{ $product->price }}
                                        </span>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">
                                        {{ $product->description }}
                                    </p>

                                    <!-- Details -->
                                    <div class="grid grid-cols-2 gap-y-2 text-xs text-gray-600 mb-4">
                                        <div>
                                            <p class="text-gray-400 uppercase tracking-wide">Material</p>
                                            <p class="font-medium text-gray-800">
                                                {{ $product->material->type ?? 'No material' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-right uppercase tracking-wide">Dimensions</p>
                                            <p class="text-right font-medium text-gray-800">
                                                {{ $product->dimentions }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 uppercase tracking-wide">Stock</p>
                                            <p class="font-medium text-gray-800">
                                                {{ $product->stock }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Shop Button -->
                                    <a href="{{ route('shop.show', $product->id) }}" class="w-full inline-block text-center rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                                        View Product
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button 
                  @click="current = (current - 1 + totalSlides) % totalSlides"
                  class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-3 shadow-lg">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                  </svg>
                </button>
                <button 
                  @click="current = (current + 1) % totalSlides"
                  class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-3 shadow-lg">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </button>

                <!-- Indicators -->
                <div class="flex justify-center mt-6 space-x-2">
                    <template x-for="i in totalSlides" :key="i">
                        <button 
                          @click="current = i - 1"
                          class="w-3 h-3 rounded-full transition"
                          :class="current === i - 1 ? 'bg-emerald-600' : 'bg-gray-300'">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </section>
    @endif
     <x-form.footer/>
</x-layout>