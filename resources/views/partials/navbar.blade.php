<div class="sticky top-4 z-50 px-4 sm:px-6">
  <header class="max-w-6xl mx-auto bg-[var(--titanium)]/85 backdrop-blur-md border hairline rounded-full">
    <div class="px-5 sm:px-7 h-16 flex items-center justify-between">
      <a href="{{ url('/') }}" class="font-display text-xl font-800 tracking-tight uppercase">VELOCE<span class="text-[var(--ignition)]">.</span></a>
      <nav class="hidden md:flex items-center gap-8 text-sm font-mono uppercase tick text-[var(--alloy)]">
        @if(auth()->check() && auth()->user()->isAdmin())
          <a href="{{ route('cars.index') }}" class="underline-grow hover:text-[var(--chrome)]">Kelola Mobil</a>
          <a href="{{ route('admin.testdrives.index') }}" class="underline-grow hover:text-[var(--chrome)]">Test Drive</a>
          <a href="{{ route('admin.testimonials.index') }}" class="underline-grow hover:text-[var(--chrome)]">Testimoni</a>
        @else
          <a href="{{ route('cars.index') }}" class="underline-grow hover:text-[var(--chrome)]">Koleksi</a>
          <a href="{{ url('/#kenapa') }}" class="underline-grow hover:text-[var(--chrome)]">Benefit</a>
          <a href="{{ url('/#kontak') }}" class="underline-grow hover:text-[var(--chrome)]">Kontak</a>
        @endif
      </nav>
      <div class="flex items-center gap-3">
        @guest
          <a href="{{ route('login') }}" class="font-mono text-xs uppercase tick text-[var(--alloy)] hover:text-[var(--chrome)]">Masuk</a>
          <a href="{{ url('/#kontak') }}" class="btn-ignition font-mono text-xs font-600 uppercase tick px-5 py-2.5 rounded-full transition">Test Drive</a>
        @endguest
        @auth
          <span class="hidden sm:inline font-mono text-xs uppercase tick text-[var(--alloy)]">
            {{ auth()->user()->name }} @if(auth()->user()->isAdmin())<span class="text-[var(--ignition)]">· Admin</span>@endif
          </span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-ghost border hairline font-mono text-xs font-600 uppercase tick px-5 py-2.5 rounded-full transition">Keluar</button>
          </form>
        @endauth
      </div>
    </div>
  </header>
</div>
