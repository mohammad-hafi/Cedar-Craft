<x-layout>
    
  <section x-data="{update:false,product:{}}" class="relative min-h-screen bg-amber-50 px-4 py-10">
    <div class="mx-auto max-w-[1800px]">
      <div class="rounded-xl bg-white p-8 shadow">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
          <div>
            <h1 class="text-3xl font-extrabold text-emerald-900">Products</h1>
          </div>
        </div>
        
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
          <!-- FILTER SIDEBAR -->
          <div class="lg:col-span-1">

  <h2 class="text-xl font-bold text-emerald-900 mb-4">Filter</h2>

  <form method="GET" action="" class="space-y-6">
    <!-- CATEGORY -->
    <div>
      <label class="text-sm font-semibold text-gray-600">Category</label>
      <select name="cat" class="w-full mt-2 border rounded-lg p-2">
        <option value="">All</option>
        @foreach($categories as $category)
          <option value="{{ $category->id }}"
            {{ request('cat') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
        @endforeach
      </select>
    </div>
    <!-- material -->
    <div>
      <label class="text-sm font-semibold text-gray-600">Material</label>
      <select name="mat" class="w-full mt-2 border rounded-lg p-2">
        <option value="">All</option>
        @foreach($materials as $material)
        <option value="{{ $material->id }}"
          {{ request('mat') == $material->id ? 'selected' : '' }}>
          {{ $material->type }}
        </option>
        @endforeach
      </select>
    </div>

    <!-- PRICE RANGE -->

    <div x-data="{min: 0, max: 1000}">
<input type="range" min="0" max="1000" x-model="min" class="w-full accent-yellow-500">
<input type="range" min="0" max="1000" x-model="max" class="w-full accent-yellow-500">

<p x-text="min + ' - ' + max"></p>

<input type="hidden" name="min_price" :value="min">
<input type="hidden" name="max_price" :value="max">
</div>

<!-- BUTTONS -->
<div class="flex flex-col gap-2">
  <button type="submit" class="bg-emerald-900 text-white py-2 rounded-lg">
    Apply Filters
  </button>
  
  <a href="/shop" class="text-center border py-2 rounded-lg">
    Reset
  </a>
</div>

</form>
</div>
<div class="lg:col-span-3">
          <input
          type="text"
          id="searchInput"
          placeholder="Search products..."
          class="w-full border rounded-lg p-3 mb-6"
          />
<div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
  @include('partials.productgrid',['products'=>$products])
    </div>
      <!-- End inner grid -->
    </div>
    <!-- End card -->
  </div>
  <!-- End outer container -->

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
        <label class="block font-semibold text-gray-800 mb-2">Category*</label>
    <select x-model="design.category" name="category" id="material" class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">
      @foreach ($categories as $type)
          <option value="{{ $type->id }}">{{$type->name}}</option>
      @endforeach  
    </select> 
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