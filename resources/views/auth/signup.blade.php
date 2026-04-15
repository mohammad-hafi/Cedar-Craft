<x-layout>
<section class="bg-gradient-to-br from-emerald-900 to-emerald-700 px-4 py-14">
    <div class="mx-auto w-full max-w-md rounded-xl bg-white p-10 shadow-2xl">
      <h1 class="text-center text-2xl font-extrabold text-emerald-900">Create your account</h1>
      <p class="mt-2 text-center text-gray-600">Join Cedar Craft to save and customize products</p>

      <form class="mt-8 space-y-5" method="POST" action="/signup">
        @csrf
        
       <x-form.field label="Name *" name="name" required placeholder="Your Username Here"/>


       <x-form.field label="Email *" name="email" required placeholder="your@email.com"/>
      

      <div x-data="{ showPass : false}" class="relative w-full">
        <label class="block font-semibold text-gray-800 mb-2">Password *</label>
          <input id="password" name="password" :type="showPass ? 'text' : 'password'" required class="w-full rounded-lg border-2 border-gray-200 px-4 py-3 pr-20 focus:outline-none focus:border-emerald-900" placeholder="Create a password"/> 
          <x-form.error name="password"/>
          <button type="button" @click="showPass = !showPass" x-text="showPass ? 'Hide' : 'Show'" class="absolute right-2 top-1/2 -translate-y-0.5 px-3 py-1 text-sm font-semibold text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 transition">
          </button>
      </div>

       <x-form.field label="Phone *" name="phone" required placeholder="+961 12345678"/>

        
    <div>  
      <label class="block font-semibold text-gray-800 mb-2">Address:</label>
    <select name="address" id="address"
     class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-green-800 focus:border-green-800">
      <option value="Beirut">Beirut</option>
      <option value="Mount Lebanon">Mount Lebanon</option>
      <option value="North">North</option>
      <option value="Bekaa">Bekaa</option>
      <option value="South">South</option>
      <option value="Nabatieh">Nabatieh</option>
    </select>
  </div>
        
       
        <button type="submit" class="w-full rounded-lg bg-emerald-900 px-4 py-3 font-extrabold text-white hover:bg-emerald-950">
          Sign Up
        </button>

        <p class="text-center text-sm text-gray-600">
          Already have an account?
          <a href="/login" class="font-extrabold text-emerald-900 hover:text-amber-600">Login</a>
        </p>
      </form>
    </div>
  </section>
</x-layout>