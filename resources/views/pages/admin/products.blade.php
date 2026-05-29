<x-layout>
    <section x-show="product" id="tab-products" class="tabSection space-y-6 mt-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-2xl font-extrabold text-emerald-900">Add New Product</h2>
          </div>
        </div>
        <form action="/admin" method="POST" id="productForm" enctype="multipart/form-data" class="mt-6 grid grid-cols-1 gap-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:grid-cols-2">
          @csrf
        <div class="sm:col-span-2 space-y-6">
        <x-form.field label="Product Name*" name="name"/>
        <x-form.field type="number" label="Price*" name="price"/>
      <label class="block font-semibold text-gray-800 mb-2">Category*</label>
        <select name="category" id="category" class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">
      @foreach ($categories as $type)
          <option value="{{ $type->id }}">{{$type->name}}</option>
      @endforeach 
    </select>
        <x-form.field type="number" label="Stock*" name="stock"/>
        <x-form.field label="Dimensions*" name="dimentions" placeholder="Enter product dimensions"/>
     <label class="block font-semibold text-gray-800 mb-2">Material*</label>
    <select name="material" id="material" class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">
      @foreach ($materials as $type)
          <option value="{{ $type->id }}">{{$type->type}}</option>
      @endforeach  
    </select>
          </div>

          <div class="sm:col-span-2">
            <label class="mb-2 block font-semibold text-gray-800">Description*</label>
            <textarea id="p_desc" name="description" rows="4" class="w-full rounded-lg border-2 border-gray-200 px-4 py-3 focus:outline-none focus:border-emerald-900"></textarea>
          </div>
          
          <div class="sm:col-span-2">
           <x-form.field label="Image*" name="image[]" type="file"   class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 focus:outline-none" multiple/>
          </div>

          <div class="sm:col-span-2 flex flex-col gap-3 sm:flex-row sm:justify-end">
    <button type="button" onclick="storeProduct()" class="w-full rounded-lg bg-emerald-900 px-6 py-3 font-extrabold text-white hover:bg-emerald-950 sm:w-auto">Save Product</button>
          </div>
        </form>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

  <!-- Material Form -->
  <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm space-y-4">

    <h3 class="text-sm font-semibold text-gray-800">Add Material</h3>

    <div x-data="{ material: '' }">
      <x-form.field 
        label="Material Name" 
        name="materials"
        id="materials"
        value=""
        placeholder="e.g. Wood"
        x-model="material"
        class="focus:ring-2 focus:ring-emerald-600"
      />

      <div class="flex justify-end gap-2 mt-3">
        <button 
          type="button"
          @click="material = ''"
          class="text-xs text-gray-500 hover:text-gray-700">
          Cancel
        </button>

        <button
         @click="material = ''"
          onclick="storeMaterial()"
          type="button"
          class="rounded-md bg-emerald-700 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-800">
          Save
        </button>
      </div>
    </div>
  </div>

  <!-- Category Form -->
  <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm space-y-4">
  

    <h3 class="text-sm font-semibold text-gray-800">Add Category</h3>

    <div x-data="{ category: '' }">
      <x-form.field 
        label="Category Name" 
        name="categories"
        id="categories"
        value=""
        placeholder="e.g. Furniture"
        x-model="category"
        class="focus:ring-2 focus:ring-emerald-600"
      />

      <div class="flex justify-end gap-2 mt-3">
        <button 
          type="button"
          @click="category = ''"
          class="text-xs text-gray-500 hover:text-gray-700">
          Cancel
        </button>

        <button 
        @click="category = ''"
          type="button"
          onclick="storeCategory()"
          class="rounded-md bg-emerald-700 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-800">
          Save
        </button>
      </div>
    </div>
  </div>

</div>


</section>
</x-layout>
