 @foreach($products as $product)
@if(!auth()->check() || !auth()->user()->is_admin())
<a href="{{ route('shop.show', $product->id) }}">
@endif 
<div class="group rounded-2xl border border-gray-200 bg-white shadow-sm hover:shadow-xl w-full transition flex flex-col h-full">
  <!-- IMAGE SLIDER -->
<div class="relative bg-gray-50 overflow-hidden rounded-t-2xl"
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
            class="max-w-full transition duration-300 hover:scale-110 max-h-full object-cover"
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
  <div class="p-6">

    <!-- Title + Price -->
<div class="flex items-start justify-between gap-4 mb-2">
        <h3 class="text-xl font-semibold text-gray-900">
        {{ $product->name }}
      </h3>

      <span class="text-2xl font-bold text-emerald-700">
        ${{ $product->price }}
      </span>
    </div>

    <!-- Description -->
    <p class="mt-2 text-sm text-gray-500 line-clamp-2">
      {{ $product->description }}
    </p>

    <!-- Divider -->
    <div class="my-4"></div>

    <!-- Details -->
    <div class="grid grid-cols-2 gap-y-3 text-sm text-gray-600">

      <div>
        <p class="text-gray-400 text-xs uppercase tracking-wide">Material</p>
        <p class="font-medium text-gray-800">
  {{ $product->material->type ?? 'No material' }}
</p>
      </div>

      <div>
        <p class="text-gray-400 text-end text-xs uppercase tracking-wide">Dimensions</p>
        <p class="text-end font-medium text-gray-800">
          {{ $product->dimentions }}
        </p>
      </div>

      <div>
        <p class="text-gray-400 text-xs uppercase tracking-wide">Stock</p>
        <p class="font-medium text-gray-800">
  {{ $product->stock }}
</p>
      </div>

    </div>
    
    @admin
  <div class="flex items-center mt-2 gap-3">
  
  <button
    @click="
      update = true;
      product = @js($product);
      product.toDelete = [];
      product.newImages = [];
      product.previewNew = [];
    "
    class="w-full rounded-lg bg-emerald-900 px-4 py-3 font-semibold text-white hover:bg-emerald-800 transition"
  >
    Update Product
  </button>
  
  <form action="/admin/products/{{ $product->id }}" method="POST">
    @csrf
    @method('DELETE')
  
    <button 
      type="submit"
      class="rounded-lg bg-red-100 p-3 text-red-700 hover:bg-red-200 transition"
    >
      <svg xmlns="http://www.w3.org/2000/svg" 
           class="h-6 w-6" 
           fill="none" 
           viewBox="0 0 24 24" 
           stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M19 7l-1 12a2 2 0 01-2 2H8a2 2 0 01-2-2L5 7m5-3h4m-7 3h10" />
      </svg>
    </button>
  
  </form>
  
  </div>
    @endadmin
  </div>
</div>
    </a>

@endforeach
        </div>
        <!-- End product grid -->