<x-layout>

{{-- ============================================================
     Shopping Cart Page
     ============================================================ --}}

<section class="min-h-screen bg-amber-50 px-4 py-10">
    <div class="mx-auto max-w-4xl">

        {{-- ── Page Header ── --}}
        <div class="mb-8 border-b-2 border-emerald-900 pb-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Your Selection</p>
            <h1 class="mt-1 font-serif text-4xl font-black text-emerald-900">Shopping Cart</h1>

            {{-- Navigation Buttons --}}
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="/shop"
                   class="inline-flex items-center gap-2 rounded bg-emerald-900 px-5 py-2.5 text-sm font-semibold tracking-wide text-white transition hover:-translate-y-px hover:bg-emerald-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Continue Shopping
                </a>

                <a href="/customize"
                   class="inline-flex items-center gap-2 rounded bg-amber-400 px-5 py-2.5 text-sm font-bold tracking-wide text-emerald-900 transition hover:-translate-y-px hover:bg-amber-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Customize a Product
                </a>
            </div>
        </div>

        {{-- ── Orders List ── --}}
        @foreach ($orders as $order)

            {{-- Check if the order has any visible items --}}
            @php $hasVisible = false; @endphp
            @foreach ($order->items as $item)
                @if ($item->soft_delete != 1 && strtolower($order->status->value) != 'delivery')
                    @php $hasVisible = true; @endphp
                @endif
            @endforeach

            {{-- Render order box only if it has visible items --}}
            @if ($hasVisible)

                {{-- Confirm Order Form (wraps the entire order box) --}}
                <form id="confirm-order-{{ $order->id }}" action="/order/confirm/{{ $order->id }}" method="POST" class="mb-6">
                    @csrf
                    @method('PATCH')

                    {{-- ── Order Box ── --}}
                    <div class="overflow-hidden rounded border border-gray-200 border-l-4 border-l-emerald-900 bg-white shadow-sm">

                        {{-- Order Box Header --}}
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-200 bg-gray-50 px-6 py-3">

                            <span class="text-xs font-bold uppercase tracking-widest text-gray-400">
                                Order #{{ $order->id }}
                            </span>

                            <div class="flex flex-wrap items-center gap-3">
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $order->user->name }}
                                </span>

                                <span class="rounded border border-amber-300 bg-amber-50 px-3 py-0.5 text-xs font-bold uppercase tracking-widest text-amber-800">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>

                        {{-- ── Order Items ── --}}
                        @foreach ($order->items as $item)
                            @if ($item->soft_delete != 1 && strtolower($order->status->value) != 'Received')

                                {{-- Item Row --}}
                                <div class="flex flex-col gap-4 border-b border-dashed border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                                    {{-- Left: Product Info + Fields --}}
                                    <div class="flex-1">

                                        {{-- Product Name --}}
                                        <h2 class="mb-3 font-serif text-lg font-bold text-emerald-900">
                                            {{ $item->product->name ?? $item->design->product_name }}
                                        </h2>

                                        {{-- Material & Quantity Fields --}}
                                        <div class="flex flex-wrap items-center gap-x-6 gap-y-3">

                                            {{-- Material Select --}}
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">
                                                    Material
                                                </span>
                                                @if (in_array($order->status->value, ['Pending']))
                                                <select name="items[{{ $item->id }}][material]"
                                                        class="min-w-[130px] rounded border border-gray-300 bg-gray-50 px-2.5 py-1.5 text-sm text-gray-900 focus:border-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-700/20">
                                                    @foreach ($materials as $type)
                                                        <option value="{{ $type->id }}"
                                                                {{ $item->material_id == $type->id ? 'selected' : '' }}>
                                                            {{ $type->type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @else
                                                <span class="text-xs font-bold tracking-widest text-emerald-900">
                                                    {{ $item->material->type }}
                                                </span>
                                                @endif
                                            </div>

                                            {{-- Quantity Input --}}
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">
                                                    Qty
                                                </span>
                                                @if (in_array($order->status->value, ['Pending']))
                                                    
                                                <input type="number"
                                                name="items[{{ $item->id }}][quantity]"
                                                value="{{ $item->quantity }}"
                                                min="1"
                                                class="w-16 rounded border border-gray-300 bg-gray-50 py-1.5 text-center text-sm font-bold text-emerald-900 focus:border-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-700/20">
                                                @else
                                                <span class="text-xs font-bold uppercase tracking-widest text-emerald-900">
                                                    {{ $item->quantity }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Date Added --}}
                                        <p class="mt-2 text-xs text-gray-400">
                                            Added {{ $item->created_at }}
                                        </p>
                                    </div>

                                    {{-- Right: Price + Remove --}}
                                    <div class="flex flex-col items-end gap-1.5 sm:min-w-[120px]">

                                        <p class="text-xs font-bold uppercase tracking-widest text-gray-400">
                                            Item Total
                                        </p>

                                        <p class="font-serif text-2xl font-black text-emerald-900">
                                            ${{ $item->price_at_purchase }}
                                        </p>

                                        {{-- Remove Item Button --}}
                                        <button type="submit"
                                                form="remove-item-{{ $item->id }}"
                                                class="text-xs font-bold text-red-500 underline transition hover:text-red-700">
                                            Remove
                                        </button>

                                    </div>
                                </div>{{-- end item row --}}

                            @endif
                        @endforeach
                        {{-- ── End Items ── --}}

                        {{-- ── Order Box Footer: Confirm Button ── --}}
                        <div class="flex items-center justify-end bg-gray-50 px-6 py-4">
                             @if (in_array($order->status->value, ['Pending']))
                            <button type="submit"
                                    name="status"
                                    value="Paid"
                                    class="inline-flex items-center gap-2 rounded bg-emerald-900 px-6 py-2.5 text-sm font-bold tracking-wide text-white shadow transition hover:-translate-y-px hover:bg-emerald-800 hover:shadow-emerald-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Confirm Order
                            </button>
                            @endif
                        </div>

                    </div>{{-- end order box --}}

                </form>{{-- end confirm form --}}

                @foreach ($order->items as $item)
                    @if ($item->soft_delete != 1 && strtolower($order->status->value) != 'Received')
                        <form id="remove-item-{{ $item->id }}" action="/cart/remove/{{ $item->id }}" method="POST" class="hidden">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="soft_delete" value="1">
                        </form>
                    @endif
                @endforeach

            @endif
        @endforeach
        {{-- ── End Orders List ── --}}

    </div>
</section>

</x-layout>