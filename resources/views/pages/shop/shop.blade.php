<x-layout>
    
  <section x-data="{update:false,product:{}}" class="relative min-h-screen bg-amber-50 px-4 py-10">
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
@if(!auth()->check() || !auth()->user()->is_admin())
<a href="{{ route('shop.show', $product->id) }}">
@endif 
<div class="group rounded-2xl border border-gray-200 bg-white shadow-sm hover:shadow-lg transition overflow-hidden">

  <!-- IMAGE SLIDER -->
  <div class="relative h-60 bg-gray-100 overflow-hidden"
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
        class="absolute inset-0 w-full h-full object-cover"
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
    <div class="flex items-start justify-between gap-4">
      <h3 class="text-lg font-bold text-gray-900 leading-snug">
        {{ $product->name }}
      </h3>

      <span class="text-xl font-bold text-emerald-700 whitespace-nowrap">
        ${{ $product->price }}
      </span>
    </div>

    <!-- Description -->
    <p class="mt-3 text-sm text-gray-600 line-clamp-2">
      {{ $product->description }}
    </p>

    <!-- Divider -->
    <div class="my-4 border-t"></div>

    <!-- Details -->
    <div class="grid grid-cols-2 gap-4 text-sm">

      <div>
        <p class="text-gray-400 text-xs">Material</p>
        <p class="font-medium text-gray-800">
          {{ $product->material->type ?? 'No material' }}
        </p>
      </div>

      <div>
        <p class="text-end text-gray-400 text-xs">Dimensions</p>
        <p class="text-end font-medium text-gray-800">
          {{ $product->dimentions }}
        </p>
      </div>

      <div>
        <p class="text-gray-400 text-xs">Stock</p>
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
@admin
<div x-show="update" id="customModal"  class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4" x-transition>
  <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
    <div 
    class="rounded-2xl relative p-6 shadow-2xl"
    >
    <button 
    @click="update=false"
    class="absolute top-4 right-4 text-2xl text-gray-400 hover:text-emerald-900">
    &times;
  </button>
  <form :action="'/admin/products/' + product.id" method="POST" enctype="multipart/form-data"  class="mt-6 grid grid-cols-1 gap-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:grid-cols-2">
          @csrf
          @method('PUT')
            <div class="sm:col-span-2 space-y-6">
        <x-form.field label="Product Name*" name="name" x-model="product.name"/>
        <x-form.field type="number" label="Price*" name="price" x-model="product.price"/>
        <x-form.field type="number" label="Stock*" name="stock" x-model="product.stock"/>
        <x-form.field x-model="product.dimentions" label="Dimensions*" name="dimentions" placeholder="Enter product dimensions"/>
     <label class="block font-semibold text-gray-800 mb-2">Material*</label>
    <select x-model="product.material" name="material" id="material" class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">
      @foreach ($materials as $type)
          <option value="{{ $type->id }}">{{$type->type}}</option>
      @endforeach  
    </select>
          </div>

          <div class="sm:col-span-2">
            <label class="mb-2 block font-semibold text-gray-800">Description*</label>
            <textarea x-model="product.description" id="p_desc" name="description" rows="4" class="w-full rounded-lg border-2 border-gray-200 px-4 py-3 focus:outline-none focus:border-emerald-900"></textarea>
          </div>

          <div class="sm:col-span-2">
           <!-- EXISTING IMAGES -->
<div class="sm:col-span-2">
  <label class="block font-semibold text-gray-800 mb-2">Current Images</label>

  <div class="flex gap-2 flex-wrap">
    <template x-for="(img,index) in product.images" :key="img.id">
      <div class="relative">
        
        <img :src="'/storage/' + img.image" class="w-20 h-20 object-cover rounded">

        <!-- delete button -->
        <button 
          type="button"
          @click="
            product.toDelete.push(img.id);
            product.images.splice(index,1);
          "
          class="absolute top-0 right-0 bg-red-600 text-white text-xs px-1 rounded">
          ✕
        </button>

      </div>
    </template>
  </div>
</div>


<!-- ADD NEW IMAGES -->
<div class="sm:col-span-2">
  <label class="block font-semibold text-gray-800 mb-2">Add New Images</label>

  <input type="file" name="images[]" multiple
    @change="
      product.newImages = [...$event.target.files];
      product.previewNew = product.newImages.map(f => URL.createObjectURL(f));
    "
    class="w-full text-sm text-gray-700"
  >

  <!-- preview -->
  <div class="flex gap-2 mt-2">
    <template x-for="img in product.previewNew" :key="img">
      <img :src="img" class="w-20 h-20 object-cover rounded">
    </template>
  </div>
</div>


<!-- HIDDEN INPUT FOR DELETIONS -->
<input type="hidden" name="deleted_images" :value="product.toDelete?.join(',')">
          </div>

          <div class="sm:col-span-2 flex flex-col gap-3 sm:flex-row sm:justify-end">
    <button type="submit" class="w-full rounded-lg bg-emerald-900 px-6 py-3 font-extrabold text-white hover:bg-emerald-950 sm:w-auto">Save Product</button>
          </div>
        </form>
      
    </div>
  
  </div> 
  @endadmin
        </div>
    </div>
    </div>
  </section>
<x-form.footer/>
</x-layout>