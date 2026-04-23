<x-layout>
<div x-data="{show:false,update:false,design:{}}">
  <section  class="min-h-screen bg-amber-50 px-4 py-10">
    <div class="mx-auto max-w-7xl">
      <div class="rounded-xl bg-white p-8 shadow">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h1 class="text-3xl font-extrabold text-emerald-900">Customize Your Product</h1>
          </div>
          <button
            id="openModalBtn"
            class="inline-flex items-center justify-center rounded-lg bg-emerald-900 px-6 py-3 font-extrabold text-white hover:bg-emerald-950"
            type="button"
            @click="show=!show"
          >
            + Create Custom Request
          </button>
        </div>
        @if($designs->isEmpty())
<div id="emptyState" class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-600">
  <h2 class="text-xl font-extrabold text-emerald-900">No custom requests yet</h2>
  <p class="mt-2">Click “Create Custom Request” to add your first customized design.</p>
</div>
@else

<div id="customGrid" class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

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

    <div class="flex items-center mt-3 gap-3">
    
    <button
      @click="
        update = true;
        design = @js($design);
        design.toDelete = [];
        design.newImages = [];
        design.previewNew = [];
      "
      class="w-full rounded-lg bg-emerald-900 px-4 py-3 font-semibold text-white hover:bg-emerald-800 transition"
    >
      Update Design
    </button>
    
    <form action="/customize/{{ $design->id }}" method="POST">
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
  </div>

</div>
@endforeach
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
  <form :action="'/customize/update/' + design.id" method="POST" enctype="multipart/form-data"  class="mt-6 grid grid-cols-1 gap-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:grid-cols-2">
          @csrf
          @method('PUT')
            <div class="sm:col-span-2 space-y-6">
        <x-form.field label="Product Name*" name="name" x-model="design.product_name"/>
        <x-form.field type="number" label="Price*" name="price" x-model="design.estimated_price"/>
    <label class="block font-semibold text-gray-800 mb-2">Category*</label>
    <select x-model="design.category" name="category" id="material" class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">
      @foreach ($categories as $type)
          <option value="{{ $type->id }}">{{$type->name}}</option>
      @endforeach  
    </select>        
    <x-form.field x-model="design.dimentions" label="Dimensions*" name="dimentions" placeholder="Enter product dimensions"/>
     <label class="block font-semibold text-gray-800 mb-2">Material*</label>
    <select x-model="design.material" name="material" id="material" class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">
      @foreach ($materials as $type)
          <option value="{{ $type->id }}">{{$type->type}}</option>
      @endforeach  
    </select>
          </div>

          <div class="sm:col-span-2">
            <label class="mb-2 block font-semibold text-gray-800">Description*</label>
            <textarea x-model="design.description" id="p_desc" name="description" rows="4" class="w-full rounded-lg border-2 border-gray-200 px-4 py-3 focus:outline-none focus:border-emerald-900"></textarea>
          </div>

          <div class="sm:col-span-2">
           <!-- EXISTING IMAGES -->
<div class="sm:col-span-2">
  <label class="block font-semibold text-gray-800 mb-2">Current Images</label>

  <div class="flex gap-2 flex-wrap">
    <template x-for="(img,index) in design.images" :key="img.id">
      <div class="relative">
        
        <img :src="'/storage/' + img.image" class="w-20 h-20 object-cover rounded">

        <!-- delete button -->
        <button 
          type="button"
          @click="
            design.toDelete.push(img.id);
            design.images.splice(index,1);
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

  <input type="file" name="image[]" multiple
    @change="
      design.newImages = [...$event.target.files];
      design.previewNew = design.newImages.map(f => URL.createObjectURL(f));
    "
    class="w-full text-sm text-gray-700"
  >

  <!-- preview -->
  <div class="flex gap-2 mt-2">
    <template x-for="img in design.previewNew" :key="img">
      <img :src="img" class="w-20 h-20 object-cover rounded">
    </template>
  </div>
</div>


<!-- HIDDEN INPUT FOR DELETIONS -->
<input type="hidden" name="deleted_images" :value="design.toDelete?.join(',')">
          </div>

          <div class="sm:col-span-2 flex flex-col gap-3 sm:flex-row sm:justify-end">
    <button type="submit" class="w-full rounded-lg bg-emerald-900 px-6 py-3 font-extrabold text-white hover:bg-emerald-950 sm:w-auto">Save Product</button>
          </div>
        </form>
      
    </div>
  
  </div> 
</div>
@endif
  </section>
  <!-- Modal -->
  <div x-show="show" id="customModal"  class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4" x-transition>
    <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
      <div 
      @click.away="show = false"
      class="rounded-2xl relative p-6 shadow-2xl"
    >
      <button 
        @click="show=false"
        class="absolute top-4 right-4 text-2xl text-gray-400 hover:text-emerald-900">
        &times;
      </button>
      <form action="{{ url('/customize') }}" method="POST" id="customForm" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        <x-form.field label="Product Name*" name="name" placeholder="Enter Your Product Name"/>

        <label for="description" class="label block font-semibold text-gray-800 mb-2">Description*</label>
        <textarea id="description" name="description" class="input h-30 w-full rounded-lg border-2 border-gray-200 px-4 py-3 focus:outline-none focus:border-emerald-900" placeholder="Enter Your Product Description">{{ old('description') }}</textarea>
        <x-form.error name="description"/>
    <label class="block font-semibold text-gray-800 mb-2">Material*</label>
    <select name="material" id="material" class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">
      @foreach ($materials as $type)
          <option value="{{ $type->id }}">{{$type->type}}</option>
      @endforeach
      
    </select>

    <x-form.field label="Dimentions*" name="dimentions" placeholder="Enter Your Product dimentions"/>
    <x-form.field label="Estimated Price $*" type="number" name="price" placeholder="Enter Your Product dimentions"/>
      <label class="block font-semibold text-gray-800 mb-2">Category*</label>
        <select name="category" id="category" class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">
      @foreach ($categories as $type)
          <option value="{{ $type->id }}">{{$type->name}}</option>
      @endforeach  
    </select>
    <x-form.field label="Image*" name="image[]" type="file"   class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 focus:outline-none" multiple/>

        <div class="sm:col-span-2 flex flex-col gap-3 sm:flex-row sm:justify-end">
          <button
            id="cancelBtn"
            type="button"
            @click="show=false"
            class="w-full rounded-lg bg-gray-200 px-6 py-3 font-extrabold text-gray-800 hover:bg-gray-300 sm:w-auto"
          >
            Cancel
          </button>

          <button
            type="submit"
            class="w-full rounded-lg bg-emerald-900 px-6 py-3 font-extrabold text-white hover:bg-emerald-950 sm:w-auto"
          >
            Submit Request
          </button>
        </div>
      </form>
      
    </div>
  
  </div> 
</div>
 <x-form.footer/>
</x-layout>