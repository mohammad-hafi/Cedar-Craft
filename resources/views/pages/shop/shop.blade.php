<x-layout>
    
  <section class="min-h-screen bg-amber-50 px-4 py-10">
    <div class="mx-auto max-w-7xl">
      <div class="rounded-xl bg-white p-8 shadow">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
          <div>
            <h1 class="text-3xl font-extrabold text-emerald-900">Products</h1>
          </div>
        </div>
        <!-- Products grid -->
        <div id="productsGrid" class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
 @foreach($products as $product)
<a href="{{ route('shop.show', $product->id) }}">
<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
 
  <!-- IMAGE SLIDER -->
  <div class="relative h-56 bg-gradient-to-br from-amber-100 to-amber-50">

    <div 
      x-data="{
        index: 0,
        images: @js($product->images->pluck('image'))
      }"
      class="relative w-full h-full overflow-hidden"
    >

      <template x-for="(img, i) in images" :key="i">
        <img 
          :src="'/storage/' + img"
          class="w-full h-full object-cover"
        >
      </template>
    </div>

  </div>

  <!-- CONTENT -->
  <div class="p-6">
    <div class="flex items-center justify-between gap-3">
      <h3 class="text-xl font-extrabold text-emerald-900 leading-tight">
        {{ $product->name }}
      </h3>
    </div>

    <p class="mt-3 text-gray-600">
 {{ $product->description }}
    </p>
    <p class="mt-3 text-gray-600">
      {{ $product->material->type ?? 'No material' }}
    </p>
    <div class="mt-4 text-2xl font-extrabold text-emerald-900">
    Price:  ${{ $product->price }}
    </div>
    <div class="mt-4 text-2xl font-extrabold text-emerald-900">
    Stock:  {{ $product->stock}}
    </div>

  </div>
</div>

</a>
@endforeach

        </div>
    </div>
    </div>
  </section>
<x-form.footer/>
</x-layout>