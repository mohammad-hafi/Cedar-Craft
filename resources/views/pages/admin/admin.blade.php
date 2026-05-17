<x-layout>


 <main x-data="{home:true,product:false,orders:false}" class="mx-auto max-w-7xl px-4 py-10">
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
    @click="home=true; product=false; orders=false"
    :class="home
        ? 'border-amber-400 text-emerald-900'
        : 'border-transparent text-gray-500 hover:text-emerald-900'"
    class="tabBtn border-b-4 px-4 py-3 font-extrabold"
>
    Home
</button>
<button 
    @click="home=false; product=true; orders=false"
    :class="product 
        ? 'border-amber-400 text-emerald-900' 
        : 'border-transparent text-gray-500 hover:text-emerald-900'"
    class="tabBtn border-b-4 px-4 py-3 font-extrabold"
>
    Products
</button>

<button 
    @click="home=false; product=false; orders=true"
    :class="orders 
        ? 'border-amber-400 text-emerald-900' 
        : 'border-transparent text-gray-500 hover:text-emerald-900'"
    class="tabBtn border-b-4 px-4 py-3 font-extrabold"
>
    Orders
</button>
        </nav>
      </div>

      <!-- ===== home Requests ===== -->
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

      <!-- ===== Products ===== -->
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

      <!-- ===== Orders ===== -->
      <section x-show="orders" id="tab-orders" class="tabSection mt-8 ">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-2xl font-extrabold text-emerald-900">Customer Orders</h2>
         
</div>
<button id="refreshOrdersBtn"
    class="w-full max-w-xs rounded-xl bg-white p-4 text-left shadow-md border border-gray-200 hover:shadow-lg transition"
>
    <div class="text-xs font-bold text-gray-500">TOTAL REVENUE</div>
    <div class="mt-1 text-3xl font-extrabold text-emerald-900">
        ${{ $total }}
    </div>
</button>        
</div>
        
        @if($orders->isEmpty())
        <div id="ordersEmpty" class="mt-6 rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-600 ">
          <p class="font-extrabold text-emerald-900">No orders yet.</p>
          <p class="mt-2">Once customers checkout, their orders should appear here.</p>
        </div>
        @endif
        @foreach ($orders as $order)
      @foreach($order->items as $item)
        @if($item->soft_delete != 1 && in_array($order->status->value, ['Pending', 'Paid']))
            <div id="ordersList" class="mt-6 space-buffer-4">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class=" space-y-2">
              <div class="text-2xl font-bold text-emerald-900">{{ $item->product->name ?? $item->design->product_name }}</div>
              <div class="text-xl font-extrabold text-emerald-900">Quantity: {{$item->quantity}}</div>
              <div class="mt-1 text-sm text-gray-600">Customer: <span class="font-bold">{{ $order->user->name }}</span></div>
              <div class="mt-1 text-xs text-gray-500">Created: {{ $item->created_at }}</div>
           </div>

            <div class="text-right space-y-2">
              <div class=" stat inline-flex rounded-full bg-amber-100 px-4 py-2 text-sm font-extrabold text-amber-800 border border-amber-200">{{$order->status}}</div>
              <div class="mt-3 text-xs font-bold text-gray-500">Total</div>
              <div class="text-2xl font-extrabold text-emerald-900">${{ $item->price_at_purchase * $item->quantity }}</div>
              @if($order->status->value == 'Paid')
              <button
                onclick="markDelivery({{$order->id}})"
                class="mt-4 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700 cursor-pointer"
            >
                Mark As Delivery
            </button>
            @endif
                {{-- <form action="/cart/remove/{{$order->id}}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-extrabold cursor-pointer text-red-500 underline">remove</button>
                </form> --}}
            </div>
          </div>

        </div>
        @endif
        @endforeach
        @endforeach
        </div>
      </section>
    </div>
  </main>
<div 
    x-data="{
        chatOpen: false,

        newMessage: '',

        selectedUser: {},

        users: [],

        messages: [],
        async init() {

    let res = await axios.get('/chat/users');

    this.users = res.data;

    window.Echo.private('chat.{{ auth()->id() }}')

    .listen('MessageSent', (e) => {

        this.messages.push(e.message);
    });
},
        async selectUser(user) {

    this.selectedUser = user;

    let res = await axios.get('/chat/messages/' + user.id);

    this.messages = res.data;
},

        async sendMessage() {

    if(this.newMessage.trim() == '') return;

    if(!this.selectedUser.id) {
        alert('Please select a user first');
        return;
    }

    try {
        let res = await axios.post('/chat/send', {
            receiver_id: this.selectedUser.id,
            message: this.newMessage,
        });
        this.messages.push(res.data);
        this.newMessage = '';
    } catch(error) {
        if(error.response?.status === 422) {
            const errors = error.response.data.errors;
            alert(Object.values(errors)[0][0]);
        } else {
            alert('Error sending message');
        }
    }
}
    }"
    class="fixed bottom-6 right-6 z-50"
>

    <!-- Floating Button -->
    <button 
        @click="chatOpen = !chatOpen"
        class="bg-yellow-500 text-white p-4 rounded-full shadow-xl hover:bg-emerald-800 transition"
    >
        💬
    </button>

    <!-- Chat Box -->
    <div 
        x-show="chatOpen"
        x-transition

        @admin
            class="fixed bottom-20 right-6 w-[700px] h-[500px] bg-white rounded-2xl shadow-2xl border flex"
        @else
            class="fixed bottom-20 right-6 w-[350px] h-[500px] bg-white shadow-2xl border flex"
        @endadmin
    >

        <!-- USERS LIST -->
        @admin
        <div class="w-1/3 border-r bg-gray-50 rounded-l-2xl overflow-y-auto">

            <!-- Header -->
            <div class="p-4 font-bold text-white bg-emerald-900 rounded-tl-2xl">
                Users
            </div>

            <!-- User Cards -->
            <template x-for="user in users" :key="user.id">

              <div 
                    @click="selectUser(user)"
                    class="p-4 border-b cursor-pointer hover:bg-gray-200 transition"
                    :class="selectedUser.id === user.id ? 'bg-gray-200' : ''"
                >

                    <div 
                        class="font-semibold"
                        x-text="user.name"
                    ></div>

                </div>

            </template>

        </div>
        @endadmin

        <!-- CHAT -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <div class="bg-emerald-900 text-white p-3 flex justify-between items-center

                @admin
                    rounded-tr-2xl
                @else
                    rounded-t-2xl
                @endadmin
            ">

                <span class="font-bold">
                    Chat with 
                    <span x-text="selectedUser.name || 'Support'"></span>
                </span>

                <button @click="chatOpen = false">
                    ✕
                </button>

            </div>

            <!-- Messages -->
            <div class="p-3 flex-1 overflow-y-auto space-y-2">

                <template x-for="msg in messages" :key="msg.id">

                    <div 
                        class="text-sm p-2 rounded max-w-[80%]"
                        :class="msg.sender_id == {{ auth()->id() }}
                            ? 'bg-emerald-200 ml-auto'
                            : 'bg-gray-100'"
                    >

                        <span x-text="msg.message"></span>

                    </div>

                </template>

            </div>

            <!-- Input -->
            <form 
                @submit.prevent="sendMessage"
                class="flex border-t"
            >

                <input 
                    x-model="newMessage"
                    type="text"
                    placeholder="Type a message..."
                    class="flex-1 p-2 outline-none"
                >

                <button class="px-4 bg-emerald-900 text-white">
                    Send
                </button>

            </form>

        </div>

    </div>

</div>
</x-layout>