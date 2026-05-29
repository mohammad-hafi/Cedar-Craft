<x-layout>
<section x-show="custom" id="tab-custom" class="tabSection mx-auto max-w-7xl px-4 py-10">
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
@if(strtolower($design->status->value) === 'pending')
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

<a href="/admin/custom/{{ $design->id }}">
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
  </div>
</a>
<div class="m-3">
    
    <!-- ACCEPT FORM -->
    <form method="POST" action="/admin/{{ $design->id }}/status">
        @csrf
        @method('PATCH')
        <x-form.field type="number" label="Stock*" name="stock"
         placeholder="Enter stock quantity" 
            required/>
        <!-- Estimated Price Input -->
        <x-form.field 
            type="number" 
            label="Estimated Price*" 
            name="estimated_price" 
            placeholder="Enter estimated price" 
            required
        />
        <!-- Buttons Row -->
        <div class="mt-4 flex gap-3">
            <!-- ACCEPT -->
            <button 
                type="submit"
                name="status"
                value="Accepted"
                class="flex-1 rounded-lg bg-emerald-600 px-4 py-2 font-bold text-white transition hover:bg-emerald-700"
            >
                Accept
            </button>

    </form>

            <!-- REJECT FORM -->
            <form method="POST" action="/admin/reject/{{ $design->id }}" class="flex-1">
                @csrf
                @method('PATCH')

                <button 
                    type="submit"
                    name="status"
                    value="Rejected"
                    class="w-full rounded-lg bg-red-600 px-4 py-2 font-bold text-white transition hover:bg-red-700"
                >
                    Reject
                </button>
            </form>

        </div>

</div>
</div>
@endif
@endforeach
        </div>
</section>
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