@php
  $guestlinks=[
    ['href'=>'/','label'=>'Home'],
    ['href'=>'/shop','label'=>'Shop'],
    ['href'=>'/about','label'=>'About'],
  ];
  $Authlinks=[
    ['href'=>'/','label'=>'Home'],
    ['href'=>'/shop','label'=>'Shop'],
    ['href'=>'/about','label'=>'About'],
    ['href'=>'/cart','label'=>'Cart'],
    ['href'=>'/customize','label'=>'Customize'],
  ];
  $adminlinks=[
    ['href'=>'/','label'=>'Home'],
    ['href'=>'/about','label'=>'About'],
    ['href'=>'/shop','label'=>'My Shop'],
    ['href'=>'/admin','label'=>'Admin'],
  ];
@endphp

<nav class="sticky top-0 z-50 border-b-4 border-amber-400 bg-gradient-to-br from-emerald-900 to-emerald-950 shadow-lg">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4">
      <a href="/" class="flex items-center gap-3 text-white transition hover:text-amber-300">
        <span class="text-3xl">🌲</span>
        <span class="text-xl font-extrabold tracking-wide">Cedar Craft</span>
      </a>

      <div class="hidden items-center md:flex">
        @guest
        @foreach($guestlinks as $link)
        <a href="{{ $link['href'] }}" class="px-5 py-6 text-sm font-semibold uppercase tracking-wide text-white/90 hover:text-amber-300">{{$link['label']}}</a>
        @endforeach
        @endguest
        @auth
        @if (auth()->user()->is_admin())
        @foreach ($adminlinks as $link)
        <a href="{{ $link['href'] }}" class="px-5 py-6 text-sm font-semibold uppercase tracking-wide text-white/90 hover:text-amber-300">{{$link['label']}}</a>  
        @endforeach
       @else
        @foreach ($Authlinks as $link)
        <a href="{{ $link['href'] }}" class="px-5 py-6 text-sm font-semibold uppercase tracking-wide text-white/90 hover:text-amber-300">{{$link['label']}}</a>    
        @endforeach
        @endif
        @endauth

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
