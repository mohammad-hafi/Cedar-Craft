  <nav class="sticky top-0 z-50 border-b-4 border-amber-400 bg-gradient-to-br from-emerald-900 to-emerald-950 shadow-lg">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4">
      <a href="index" class="flex items-center gap-3 text-white transition hover:text-amber-300">
        <span class="text-3xl">🌲</span>
        <span class="text-xl font-extrabold tracking-wide">Cedar Craft</span>
      </a>

      <div class="hidden items-center md:flex">
        <a href="/" class="px-5 py-6 text-sm font-semibold uppercase tracking-wide text-white/90 hover:text-amber-300">home</a>
        <a href="/shop" class="px-5 py-6 text-sm font-semibold uppercase tracking-wide text-white/90 hover:text-amber-300">Shop</a>
        <a href="/about" class="px-5 py-6 text-sm font-semibold uppercase tracking-wide text-white/90 hover:text-amber-300">About</a>
        <a href="/cart" class="px-5 py-6 text-sm font-semibold uppercase tracking-wide text-white/90 hover:text-amber-300">Cart</a>
        <a href="/customize" class="px-5 py-6 text-sm font-semibold uppercase tracking-wide text-white/90 hover:text-amber-300">Customize</a>
        <a href="/admin" class="px-5 py-6 text-sm font-semibold uppercase tracking-wide text-white/90 hover:text-amber-300">Admin</a>
        @guest
          <a href="/login" class="ml-3 rounded-full bg-white/10 px-5 py-2 font-extrabold text-white hover:bg-white/20">Login</a>
        <a href="/signup" class="ml-2 rounded-full bg-gradient-to-r from-amber-400 to-amber-200 px-6 py-2 font-extrabold text-emerald-950 shadow hover:from-amber-200 hover:to-amber-400">Sign Up</a>
        @endguest
        @auth
        <form action="/logout" method="POST">
          @csrf
          @method('DELETE')
        <button class="ml-3 rounded-full bg-white/10 px-5 py-2 font-extrabold text-white hover:bg-white/20">Logout</button>  
       </form>
       @endauth
      </div>
    </div>
  </nav>
