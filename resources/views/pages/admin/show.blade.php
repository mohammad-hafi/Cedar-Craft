<x-layout>
<div class="max-w-6xl mx-auto p-6">
    
    <!-- Product Card -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Product Image -->
        <div 
    x-data="{
        images: @js($design->images->pluck('image')->map(fn($img) => asset('storage/' . $img))),
        active: 0
    }"
    class="p-4"
>
    <div class="relative">

        <!-- Main Image -->
        <template x-if="images.length">
            <img 
                :src="images[active]" 
                class="w-full h-80 object-cover rounded-xl transition duration-300"
            >
        </template>

        <!-- Fallback if no images -->
        <template x-if="!images.length">
            <img 
                src="/images/placeholder.jpg"
                class="w-full h-80 object-cover rounded-xl"
            >
        </template>

        <!-- Prev -->
        <button 
  x-show="images.length > 1"
  @click="if(active>0){active--} else if(active === 0){active=images.length-1}"
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
  @click="if(active < images.length-1){active++} else if(active === images.length-1){active=0}"
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

    <!-- Thumbnails -->
    <div class="flex gap-2 mt-4" x-show="images.length > 1">
        <template x-for="(img, index) in images" :key="index">
            <img 
                :src="img"
                @click="active = index"
                class="w-16 h-16 object-cover rounded-lg cursor-pointer border-2"
                :class="active === index ? 'border-emerald-600' : 'border-gray-200'"
            >
        </template>
    </div>
</div>

        <!-- Product Info -->
        <div class="p-6 flex flex-col justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{$design->name}}</h1>
                <p class="text-gray-500 mt-2">Material: {{$design->material->type}}</p>
                <p class="text-gray-500">Dimensions: {{$design->dimentions}}</p>

                <p class="mt-4 text-gray-700">
                    {{$design->description}}
                </p>

                <p class="mt-4 text-2xl font-semibold text-emerald-600">${{$design->estimated_price}}</p>
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
    </div>

    <!-- Compatible Designs -->
    {{-- <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Compatible Designs</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            <!-- Design Card -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <img src="design1.jpg" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-lg">Design Name</h3>
                    <p class="text-gray-500 text-sm mt-1">Short design description</p>
                    <button class="mt-3 w-full bg-amber-500 text-white py-1 rounded-lg hover:bg-amber-600">
                        Apply Design
                    </button>
                </div>
            </div>

            <!-- Repeat Design -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <img src="design2.jpg" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-lg">Design Name</h3>
                    <p class="text-gray-500 text-sm mt-1">Short design description</p>
                    <button class="mt-3 w-full bg-amber-500 text-white py-1 rounded-lg hover:bg-amber-600">
                        Apply Design
                    </button>
                </div>
            </div>

        </div>
    </div> --}}

</div>
</x-layout>