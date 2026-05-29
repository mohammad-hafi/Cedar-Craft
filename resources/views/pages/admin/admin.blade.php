<x-layout>

<main class="mx-auto max-w-7xl px-4 py-10">

    {{-- ===== Orders Section ===== --}}
    <section id="tab-orders" class="tabSection mt-8">

        {{-- ── Page Header ── --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <h2 class="text-2xl font-extrabold text-emerald-900">Customer Orders</h2>

            {{-- Total Revenue Card --}}
            <button
                id="refreshOrdersBtn"
                class="w-full max-w-xs rounded-xl border border-gray-200 bg-white p-4 text-left shadow-md transition hover:shadow-lg"
            >
                <div class="text-xs font-bold text-gray-500">TOTAL REVENUE</div>
                <div class="mt-1 text-3xl font-extrabold text-emerald-900">${{ $total }}</div>
            </button>

        </div>

        {{-- ── Empty State ── --}}
        @if ($orders->isEmpty())
            <div id="ordersEmpty" class="mt-6 rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-600">
                <p class="font-extrabold text-emerald-900">No orders yet.</p>
                <p class="mt-2">Once customers checkout, their orders should appear here.</p>
            </div>
        @endif

        {{-- ── Orders List ── --}}
        <div id="ordersList" class="mt-6 space-y-6">

            @foreach ($orders as $order)

                {{-- Check if this order has any visible items (Pending, Paid, or Delivery) --}}
                @php $hasVisible = false; @endphp
                @foreach ($order->items as $item)
                    @if ($item->soft_delete != 1 && in_array($order->status->value, ['Pending', 'Confirmed', 'Delivery']))
                        @php $hasVisible = true; @endphp
                    @endif
                @endforeach

                @if ($hasVisible)

                    {{-- ── Order Box ── --}}
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                        {{-- Order Box Header: ID + Customer + Status --}}
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 bg-gray-50 px-6 py-3">

                            <div class="flex items-center gap-4">
                                <span class="font-mono text-xs font-bold uppercase tracking-widest text-gray-400">
                                    Order #{{ $order->id }}
                                </span>
                                <span class="text-sm font-semibold text-gray-600">
                                    {{ $order->user->name }}
                                </span>
                            </div>

                            {{-- Status badge — colour shifts per status --}}
                            @php
                                $badgeClass = match(strtolower($order->status->value)) {
                                    'paid'     => 'border-emerald-200 bg-emerald-100 text-emerald-800',
                                    'delivery' => 'border-blue-200 bg-blue-100 text-blue-800',
                                    default    => 'border-amber-200 bg-amber-100 text-amber-800',
                                };
                            @endphp
                            <div class="stat inline-flex rounded-full border px-4 py-2 text-sm font-extrabold {{ $badgeClass }}">
                                {{ $order->status }}
                            </div>

                        </div>

                        {{-- ── Items Inside This Order ── --}}
                        @foreach ($order->items as $item)
                            @if ($item->soft_delete != 1 && in_array($order->status->value, ['Pending', 'Confirmed', 'Delivery']))

                                <div class="flex flex-col gap-3 border-b border-dashed border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                                    {{-- Left: Item Details --}}
                                    <div class="space-y-2">

                                        <div class="text-2xl font-bold text-emerald-900">
                                            {{ $item->product->name ?? $item->design->product_name }}
                                        </div>

                                        <div class="text-xl font-extrabold text-emerald-900">
                                            Quantity: {{ $item->quantity }}
                                        </div>

                                        <div class="mt-1 text-sm text-gray-600">
                                            Material: <span class="font-bold">{{ $item->material->type }}</span>
                                        </div>

                                        <div class="mt-1 text-xs text-gray-500">
                                            Created: {{ $item->created_at }}
                                        </div>

                                    </div>

                                    {{-- Right: Price --}}
                                    <div class="text-right space-y-2">
                                        <div class="text-xs font-bold text-gray-500">Total</div>
                                        <div class="text-2xl font-extrabold text-emerald-900">
                                            ${{ $item->price_at_purchase }}
                                        </div>
                                    </div>

                                </div>

                            @endif
                        @endforeach
                        {{-- ── End Items ── --}}

                        {{-- ── Order Box Footer ── --}}
                        <div class="flex items-center justify-end gap-3 bg-gray-50 px-6 py-4">

                            {{-- Mark As Delivery — shown when status is Paid --}}
                            @if ($order->status->value == 'Confirmed')
                            <form action="/orders/{{ $order->id }}/delivery" method="POST">
                                    @csrf
                                    @method('PATCH')
                                <button
                                    type="submit"
                                    class="cursor-pointer rounded-lg bg-emerald-600 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700"
                                >
                                    Mark As Delivery
                                </button>
                                </form>
                            @endif

                            {{-- Mark As Received — shown when status is Delivery --}}
                            @if ($order->status->value == 'Delivery')
                                <form action="/order/{{ $order->id }}/received" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        name="status"
                                        value="Received"
                                        class="cursor-pointer rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-blue-700"
                                    >
                                        Mark As Received
                                    </button>
                                </form>
                            @endif

                        </div>
                        {{-- ── End Footer ── --}}

                        {{-- Commented remove form preserved --}}
                        {{-- <form action="/cart/remove/{{$order->id}}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-extrabold cursor-pointer text-red-500 underline">remove</button>
                        </form> --}}

                    </div>{{-- end order box --}}

                @endif

            @endforeach

        </div>{{-- end orders list --}}

    </section>

</main>

</x-layout>