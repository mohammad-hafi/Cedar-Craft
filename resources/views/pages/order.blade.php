<x-layout>

      <section class="smallest-h-screen bg-amber-50 px-4 py-10">
    <div class="mx-auto highest-w-7xl">
      <div class="rounded-xl bg-white p-10 text-center text-gray-600 shadow">
        <h1 class="text-3xl font-extrabold text-emerald-900">Shopping Cart</h1>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center">
          <a href="/shop" class="inline-flex items-center justify-center rounded-lg bg-emerald-900 px-6 py-3 font-extrabold text-white hover:bg-emerald-950">
            Continue Shopping
          </a>
          <a href="/customize" class="inline-flex items-center justify-center rounded-lg bg-amber-400 px-6 py-3 font-extrabold text-emerald-950 hover:bg-amber-300">
            Customize a Product
          </a>
        </div>
        @foreach ($orders as $order)
        @foreach($order->items as $item)
        @if($item->soft_delete != 1 && strtolower($order->status->value) != 'delivery')
        <form action="/order/confirm/{{$order->id}}" method="POST" class="pt-3">
          @csrf
          @method('PATCH')
          <input type="hidden" name="item_id" value="{{ $item->id }}">
          <div id="ordersList" class="mt-6 space-buffer-4">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm relative">
              <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class=" space-y-2">
<p class="absolute top-3 right-3 text-sm font-bold text-gray-500">
        {{ $order->id }}
    </p>
                      <div class="text-2xl font-bold text-emerald-900">{{ $item->product->name ?? $item->design->product_name }}</div>
                  <div class=" ml-4 flex items-center gap-3">
  <label class="block font-semibold text-gray-800 mb-2">Material</label>
<select name="items[{{ $item->id }}][material]"
    class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">

    @foreach ($materials as $type)

        <option 
            value="{{ $type->id }}"
            {{ $item->material_id == $type->id ? 'selected' : '' }}
        >
            {{ $type->type }}
        </option>

    @endforeach  

</select>
    
</div>         
<div class=" ml-4 flex items-center gap-3">
    <label class="text-xl font-extrabold text-emerald-900">
        Quantity:
    </label>

    <input 
        type="number"
name="items[{{ $item->id }}][quantity]"
        value="{{ $item->quantity }}"
        min="1"
        class="w-20 rounded-lg border border-gray-300 px-2 py-1 text-center font-bold text-emerald-900 focus:border-emerald-700 focus:outline-none"
        >
      </div>         
      <div class="mt-1 text-sm text-gray-600">Customer: <span class="font-bold">{{ $order->user->name }}</span></div>
      <div class="mt-1 text-xs text-gray-500">Created: {{ $item->created_at }}</div>
      <button 
      type="submit"
      name="status"
        value="Paid"
        class="group inline-flex items-center gap-3 rounded-xl bg-emerald-900 px-6 py-3 text-lg font-extrabold text-white shadow-lg transition duration-300 hover:scale-105 hover:bg-emerald-800 hover:shadow-emerald-200"
    >
        <!-- Check Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-6 w-6 transition group-hover:rotate-12" 
             fill="none" 
             viewBox="0 0 24 24" 
             stroke="currentColor">
            <path stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M5 13l4 4L19 7" />
        </svg>

        Confirm Order
    </button>
</form>
            </div>

            <div class="text-right space-y-2">
              <div class="inline-flex rounded-full bg-amber-100 px-4 py-2 text-sm font-extrabold text-amber-800 border border-amber-200">{{$order->status}}</div>
              <div class="mt-3 text-xs font-bold text-gray-500">Total</div>
              <div class="text-2xl font-extrabold text-emerald-900">${{ $item->price_at_purchase}}</div>
                <form action="/cart/remove/{{$item->id}}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="soft_delete" value="1">
                    <button type="submit" class="text-sm font-extrabold cursor-pointer text-red-500 underline">remove</button>
                  </form>
                </div>
          </div>

        </div>
        
    </div>
    @endif
    @endforeach
    @endforeach
</div>
    </div>
  </section>

</x-layout>