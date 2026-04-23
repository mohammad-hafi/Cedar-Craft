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
        <div id="ordersList" class="mt-6 space-buffer-4">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class=" space-y-2">
              <div class="text-2xl font-bold text-emerald-900">{{$item->product->name}}</div>
              <div class="text-xl font-extrabold text-emerald-900">Quantity: {{$item->quantity}}</div>
              <div class="mt-1 text-sm text-gray-600">Customer: <span class="font-bold">{{ $order->user->name }}</span></div>
              <div class="mt-1 text-xs text-gray-500">Created: {{ $item->created_at }}</div>
              <a class="text-xl font-extrabold rounded-full text-white bg-emerald-900 px-10 py-2 cursor-pointer ">Confirm Order</a>
            </div>

            <div class="text-right space-y-2">
              <div class="inline-flex rounded-full bg-amber-100 px-4 py-2 text-sm font-extrabold text-amber-800 border border-amber-200">{{$order->status}}</div>
              <div class="mt-3 text-xs font-bold text-gray-500">Total</div>
              <div class="text-2xl font-extrabold text-emerald-900">${{ $item->price_at_purchase}}</div>
                <form action="/cart/remove/{{$item->id}}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-extrabold cursor-pointer text-red-500 underline">remove</button>
                </form>
            </div>
          </div>

        </div>
        
    </div>
    
    @endforeach
    @endforeach
</div>
    </div>
  </section>

</x-layout>