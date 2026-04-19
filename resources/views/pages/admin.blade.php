<x-layout>


 <main x-data="{custom:true, product:false,orders:false}" class="mx-auto max-w-7xl px-4 py-10">
    <div class="rounded-xl bg-white p-8 shadow">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <h1 class="text-3xl font-extrabold text-emerald-900">Admin Dashboard</h1>
          <p class="mt-1 text-gray-600">Manage products, review custom requests, and view orders.</p>
        </div>
      </div>

      <!-- Tabs -->
      <div class="mt-8 border-b border-gray-200">
        <nav class="-mb-px flex flex-wrap gap-2">
         <button 
    @click="custom=true; product=false; orders=false"
    :class="custom 
        ? 'border-amber-400 text-emerald-900' 
        : 'border-transparent text-gray-500 hover:text-emerald-900'"
    class="tabBtn border-b-4 px-4 py-3 font-extrabold"
>
    Customized Requests
</button>

<button 
    @click="custom=false; product=true; orders=false"
    :class="product 
        ? 'border-amber-400 text-emerald-900' 
        : 'border-transparent text-gray-500 hover:text-emerald-900'"
    class="tabBtn border-b-4 px-4 py-3 font-extrabold"
>
    Products
</button>

<button 
    @click="custom=false; product=false; orders=true"
    :class="orders 
        ? 'border-amber-400 text-emerald-900' 
        : 'border-transparent text-gray-500 hover:text-emerald-900'"
    class="tabBtn border-b-4 px-4 py-3 font-extrabold"
>
    Orders
</button>
        </nav>
      </div>

      <!-- ===== Customized Requests ===== -->
      <section x-show="custom" id="tab-custom" class="tabSection mt-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-2xl font-extrabold text-emerald-900">Customized Requests</h2>
            <p class="text-gray-600">Read requests submitted from Customize page.</p>
          </div>
        </div>
        @if($designs->isEmpty())
        <div id="customEmpty" class="mt-6 rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-600 ">
          <p class="font-extrabold text-emerald-900">No customized requests found.</p>
          <p class="mt-2">Go to the Customize page and submit a request.</p>
        </div>
        @endif
        <div id="customGrid" class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
@foreach($designs as $design)
<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">

  <!-- IMAGE SLIDER -->
  <div class="relative h-56 bg-gradient-to-br from-amber-100 to-amber-50">

    <div 
      x-data="{
        index: 0,
        images: @js($design->images->pluck('image'))
      }"
      class="relative w-full h-full overflow-hidden"
    >

      <template x-for="(img, i) in images" :key="i">
        <img 
          x-show="index === i"
          :src="'/storage/' + img"
          class="w-full h-full object-cover"
        >
      </template>
<button 
  x-show="images.length > 1"
  @click="if(index>0) index--"
  class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 backdrop-blur-md p-2 rounded-full shadow-md hover:bg-white transition"
>
  <svg xmlns="http://www.w3.org/2000/svg" 
       class="h-5 w-5 text-gray-800" 
       fill="none" 
       viewBox="0 0 24 24" 
       stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
  </svg>
</button>

<button 
  x-show="images.length > 1"
  @click="if(index < images.length-1) index++"
  class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 backdrop-blur-md p-2 rounded-full shadow-md hover:bg-white transition"
>
  <svg xmlns="http://www.w3.org/2000/svg" 
       class="h-5 w-5 text-gray-800" 
       fill="none" 
       viewBox="0 0 24 24" 
       stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
  </svg>
</button>

    </div>

    <div class="absolute right-4 top-4 rounded-full px-4 py-1 text-xs font-extrabold text-white
    {{ strtolower($design->status->value) === 'pending' ? 'bg-yellow-500' : '' }}
    {{ strtolower($design->status->value) === 'accepted' ? 'bg-emerald-600' : '' }}
    {{ strtolower($design->status->value) === 'rejected' ? 'bg-red-600' : '' }}
">
    {{ $design->status }}
</div>

  </div>

  <!-- CONTENT -->
  <div class="p-6">
    <div class="flex items-center justify-between gap-3">
      <h3 class="text-xl font-extrabold text-emerald-900 leading-tight">
        {{ $design->product_name }}
      </h3>
    </div>

    <p class="mt-3 text-gray-600">
      {{ $design->description }}
    </p>
    <p class="mt-3 text-gray-600">
      {{ $design->material->type ?? 'No material' }}s
    </p>

    <div class="mt-4 text-2xl font-extrabold text-emerald-900">
      ${{ $design->estimated_price }}
    </div>
    
  </div>
<form method="POST" action="/admin/{{ $design->id }}/status" class=" m-3 flex gap-3">
    @csrf
    @method('PATCH')

    <!-- ACCEPT -->
    <button 
        type="submit"
        name="status"
        value="Accepted"
        class="flex-1 rounded-lg bg-emerald-600 px-2 py-2 font-bold text-white hover:bg-emerald-700 transition"
    >
        Accept
    </button>

    <!-- REJECT -->
    <button 
        type="submit"
        name="status"
        value="Rejected"
        class="flex-1 rounded-lg bg-red-600 px-2 py-2 font-bold text-white hover:bg-red-700 transition"
    >
        Reject
    </button>
</form>
</div>
@endforeach
        </div>
      </section>

      <!-- ===== Products ===== -->
      <section x-show="product" id="tab-products" class="tabSection mt-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-2xl font-extrabold text-emerald-900">Add New Product</h2>
          </div>
        </div>

        <form action="/admin" method="POST" enctype="multipart/form-data" id="newProductForm" class="mt-6 grid grid-cols-1 gap-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:grid-cols-2">
          @csrf
            <div class="sm:col-span-2 space-y-6">
        <x-form.field label="Product Name*" name="name"/>
        <x-form.field type="number" label="Price*" name="price"/>
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
    <button type="submit" class="w-full rounded-lg bg-emerald-900 px-6 py-3 font-extrabold text-white hover:bg-emerald-950 sm:w-auto">Save Product</button>
          </div>
        </form>

        {{-- <div class="mt-10">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-extrabold text-emerald-900">All Products</h3>
            <button id="refreshProductsBtn" class="rounded-lg bg-emerald-900 px-4 py-2 font-extrabold text-white hover:bg-emerald-950">Refresh</button>
          </div> --}}
          
          {{-- <div id="productsEmpty" class="mt-6 rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-600 ">
            <p class="font-extrabold text-emerald-900">No products found.</p>
            <p class="mt-2">Use the form above to add your first product.</p>
          </div>

          <div id="productsGrid" class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            //products is here
          </div>
        </div> --}}
      </section>

      <!-- ===== Orders ===== -->
      <section x-show="orders" id="tab-orders" class="tabSection mt-8 ">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-2xl font-extrabold text-emerald-900">Customer Orders</h2>
            <p class="text-gray-600">
              Orders are read from localStorage key <code class="font-bold">cedar_orders</code>.
              (You can create orders from checkout later.)
            </p>
          </div>
          <button id="refreshOrdersBtn" class="rounded-lg bg-emerald-900 px-4 py-2 font-extrabold text-white hover:bg-emerald-950">Refresh</button>
        </div>

        <div id="ordersEmpty" class="mt-6 rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-600 ">
          <p class="font-extrabold text-emerald-900">No orders yet.</p>
          <p class="mt-2">Once customers checkout, their orders should appear here.</p>
        </div>

        <div id="ordersList" class="mt-6 space-y-4"></div>
      </section>
    </div>
  </main>

</x-layout>
