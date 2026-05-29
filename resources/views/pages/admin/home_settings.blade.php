<x-layout>
     <section x-show="home" id="tab-custom" class="tabSection mt-8">
        <section class="min-h-screen bg-gray-100 p-8">

    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8">

        <h1 class="text-3xl font-bold mb-8">
            Home Settings
        </h1>

        <form action="/new" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-xl overflow-hidden">

                    <tbody>

                        <!-- Website Name -->
                        <tr class="border-t">
                            <td class="p-4 font-semibold">
                                Website Name
                            </td>

                            <td class="p-4">
                                <input
                                    type="text"
                                    name="website_name"
                                    value="{{ $name }}"
                                    class="w-full rounded-xl p-2 focus:ring-2 focus:ring-green-500"
                                    placeholder="Enter website name">
                            </td>
                        </tr>

                        <!-- Logo -->
                        <tr class="border-t">
                            <td class="p-4 font-semibold">
                                Website Logo
                            </td>

                            <td class="p-4">
                                @if($logo)
                                    <div class="mb-2">
                                        <p class="text-sm text-gray-600">Current Logo:</p>
                                        <img src="{{ asset('storage/' . $logo) }}" alt="Current Logo" class="h-16 w-16 object-cover rounded">
                                    </div>
                                @endif
                                <input
                                    type="file"
                                    name="logo"
                                    class="w-full rounded-xl border-gray-300">
                            </td>
                        </tr>

                        <!-- Featured Products -->
                        <tr class="border-t">
                            <td class="p-4 font-semibold align-top">
                                Featured Products
                            </td>

                            <td class="p-4">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    @foreach($products as $product)
                                    @if ($product->soft_delete !=1)
                                    <label class="flex items-center gap-3 border rounded-xl p-3 hover:bg-gray-50 cursor-pointer">
                                        
                                        <input
                                                type="checkbox"
                                                name="featured_products[]"
                                                value="{{ $product->id }}"
                                                {{ in_array($product->id, $featuredProducts) ? 'checked' : '' }}
                                                class="rounded text-green-600">

                                            <div>
                                                <h2 class="font-medium">
                                                    {{ $product->name }}
                                                </h2>

                                                <p class="text-sm text-gray-500">
                                                    ${{ $product->price }}
                                                </p>
                                            </div>

                                        </label>

                                        @endif
                                    @endforeach

                                </div>

                                <p class="text-sm text-gray-500 mt-3">
                                    Select products to feature
                                </p>

                            </td>
                        </tr>

                        <tr class="border-t">
                            <td class="p-4 font-semibold">
                                intro
                            </td>

                            <td class="p-4">
                                <input
                                    type="text"
                                    name="intro"
                                    value="{{ $intro }}"
                                    class="w-full rounded-xl p-2 focus:ring-2 focus:ring-green-500"
                                    placeholder="Enter your intro">
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="p-4 font-semibold">
                                desciption
                            </td>

                            <td class="p-4">
                                <input
                                    type="text"
                                    name="description"
                                    value="{{ $des }}"
                                    class="w-full rounded-xl p-2 focus:ring-2 focus:ring-green-500"
                                    placeholder="Enter your description">
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

            <div class="mt-8 flex justify-end">
                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transition">

                    Save Settings

                </button>
            </div>

        </form>
        

    </div>
    <div class="max-w-5xl mx-auto bg-white rounded-2xl mt-8 shadow-lg p-8">
        <form action="/new/about" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-xl overflow-hidden">

                    <tbody>

                        <!-- Website Name -->
                        <tr class="border-t">
                            <td class="p-4 font-semibold">
                                story
                            </td>

                            <td class="p-4">
    <textarea
    name="story"
    class="w-full rounded-xl p-2 focus:ring-2 focus:ring-green-500"
    placeholder="Enter website name">{{ $story }}</textarea>
                            </td>
                        </tr>

                        <!-- Featured Products -->

                        <tr class="border-t">
                            <td class="p-4 font-semibold">
                                info
                            </td>

                            <td class="p-4">
                                <input
                                    type="text"
                                    name="info"
                                    value="{{ $info }}"
                                    class="w-full rounded-xl p-2 focus:ring-2 focus:ring-green-500"
                                    placeholder="Enter your info">
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="p-4 font-semibold">
                                mission
                            </td>

                            <td class="p-4">
                                <input
                                    type="text"
                                    name="mission"
                                    value="{{ $mission }}"
                                    class="w-full rounded-xl p-2 focus:ring-2 focus:ring-green-500"
                                    placeholder="Enter your mission">
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="p-4 font-semibold">
                                vision
                            </td>

                            <td class="p-4">
                                <input
                                    type="text"
                                    name="vision"
                                    value="{{ $vision }}"
                                    class="w-full rounded-xl p-2 focus:ring-2 focus:ring-green-500"
                                    placeholder="Enter your vision">
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="p-4 font-semibold">
                                values
                            </td>

                            <td class="p-4">
                                <input
                                    type="text"
                                    name="values"
                                    value="{{ $values }}"
                                    class="w-full rounded-xl p-2 focus:ring-2 focus:ring-green-500"
                                    placeholder="Enter your values">
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

            <div class="mt-8 flex justify-end">
                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transition">

                    Save Settings

                </button>
            </div>

        </form>
        

    </div>

</section>
      </section>
</x-layout>