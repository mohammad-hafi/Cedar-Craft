<x-layout>

      <section class="bg-gradient-to-br from-emerald-900 to-emerald-700 px-4 py-14">
    <div class="mx-auto w-full max-w-md rounded-xl bg-white p-10 shadow-2xl">
      <h1 class="text-center text-2xl font-extrabold text-emerald-900">🌲 Cedar Craft</h1>
      <p class="mt-2 text-center text-gray-600">Login to your account</p>

      <form action="/login" method="POST" class="mt-8 space-y-5">
        @csrf
        <x-form.field label="Email" name="email" required/>


        <div x-data="{ showPass : false}" class="relative w-full">
        <label class="block font-semibold text-gray-800 mb-2">Password </label>
          <input name="password" id="password" :type="showPass ? 'text' : 'password'" required class="w-full rounded-lg border-2 border-gray-200 px-4 py-3 pr-20 focus:outline-none focus:border-emerald-900"/> 
          <x-form.error name="password"/>
          <button type="button" @click="showPass = !showPass" x-text="showPass ? 'Hide' : 'Show'" class="absolute right-2 top-1/2 -translate-y-0.5 px-3 py-1 text-sm font-semibold text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 transition">
          </button>
      </div>

        {{-- <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
          <label class="flex items-center gap-2 text-gray-600">
            <input type="checkbox" class="h-4 w-4">
            Remember me
          </label>
          <a href="#" class="font-semibold text-emerald-900 hover:text-amber-600">Forgot Password?</a>
        </div> --}}

        <button type="submit" class="w-full rounded-lg bg-emerald-900 px-4 py-3 font-extrabold text-white hover:bg-emerald-950">
          Login
        </button>

        <p class="text-center text-sm text-gray-600">
          Don’t have an account?
          <a href="/signup" class="font-extrabold text-emerald-900 hover:text-amber-600">Sign Up</a>
        </p>
      </form>

      {{-- <div class="my-8 flex items-center gap-4">
        <div class="h-px flex-1 bg-gray-200"></div>
        <div class="text-sm text-gray-400">or</div>
        <div class="h-px flex-1 bg-gray-200"></div>
      </div> --}}

      {{-- <div class="space-y-3">
        <button type="button" class="flex w-full items-center justify-center gap-3 rounded-lg border-2 border-gray-200 px-4 py-3 font-bold text-blue-600 hover:bg-amber-50">
          <span>f</span> Login with Facebook
        </button>
        <button type="button" class="flex w-full items-center justify-center gap-3 rounded-lg border-2 border-gray-200 px-4 py-3 font-bold text-red-600 hover:bg-amber-50">
          <span>G</span> Login with Google
        </button>
      </div> --}}
    </div>
  </section>
</x-layout>