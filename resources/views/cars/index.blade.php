@extends('layouts.app')

@section('title', 'Koleksi Mobil — VELOCE')

@section('content')

<section class="max-w-6xl mx-auto px-6 lg:px-8 pt-14 pb-6">
  <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">Koleksi</p>
  <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">
    <h1 class="font-display uppercase font-800 text-4xl lg:text-5xl">Semua unit<br>tersedia</h1>
    @auth
      @if(auth()->user()->isAdmin())
        <a href="{{ route('cars.create') }}" class="btn-ignition font-mono text-sm font-600 uppercase tick px-7 py-3.5 rounded-full transition inline-block w-fit">+ Tambah Mobil</a>
      @endif
    @endauth
  </div>

  @if(session('status'))
    <div class="bg-[#1f3a24]/40 border border-[#2f5233] text-[#8fd39a] text-sm font-mono px-4 py-3 rounded-2xl mb-8">
      {{ session('status') }}
    </div>
  @endif

  {{-- FILTER --}}
  <form method="GET" action="{{ route('cars.index') }}" class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-12">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mobil..."
           class="field lg:col-span-2 bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3 text-sm">

    <select name="brand" class="field bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3 text-sm">
      <option value="">Semua Brand</option>
      @foreach($brands as $brand)
        <option value="{{ $brand }}" @selected(request('brand') === $brand)>{{ $brand }}</option>
      @endforeach
    </select>

    <select name="category" class="field bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3 text-sm">
      <option value="">Semua Kategori</option>
      @foreach($categories as $category)
        <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
      @endforeach
    </select>

    <select name="sort" class="field bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3 text-sm">
      <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Terbaru</option>
      <option value="harga_asc" @selected(request('sort') === 'harga_asc')>Harga Terendah</option>
      <option value="harga_desc" @selected(request('sort') === 'harga_desc')>Harga Tertinggi</option>
      <option value="rating" @selected(request('sort') === 'rating')>Rating Tertinggi</option>
    </select>

    <button type="submit" class="btn-ghost border hairline font-mono text-xs font-600 uppercase tick px-5 py-3 rounded-2xl transition sm:col-span-2 lg:col-span-5 lg:w-fit lg:justify-self-end">Terapkan Filter</button>
  </form>

  {{-- GRID --}}
  @if($cars->isEmpty())
    <div class="border hairline rounded-[28px] p-14 text-center text-[var(--alloy)]">
      Belum ada mobil yang cocok dengan filter ini.
    </div>
  @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($cars as $car)
      <article class="card border hairline rounded-[28px] overflow-hidden bg-[var(--titanium)]">
        <a href="{{ route('cars.show', $car) }}" class="block car-photo aspect-[4/3] flex items-center justify-center relative {{ empty($car->image) ? 'placeholder' : '' }}"
           @if(!empty($car->image)) style="background-image:url('{{ asset('images/cars/'.$car->image) }}')" @endif>
          <span class="absolute top-4 left-4 font-mono text-[10px] uppercase tick bg-[var(--asphalt)]/80 backdrop-blur px-3 py-1.5 rounded-full text-[var(--alloy)]">{{ $car->brand }}</span>
          @if($car->is_featured)
          <span class="absolute top-4 right-4 font-mono text-[10px] uppercase tick px-3 py-1.5 rounded-full bg-[#1f3a24]/90 text-[#8fd39a]">Unggulan</span>
          @endif
          @if(empty($car->image))
          <svg class="w-14 h-14 text-[var(--alloy-dim)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M3 13l1.5-4.5A2 2 0 0 1 6.4 7h11.2a2 2 0 0 1 1.9 1.5L21 13"/><path d="M3 13h18v4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1H6v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-4Z"/><circle cx="7" cy="17.5" r="1.5"/><circle cx="17" cy="17.5" r="1.5"/></svg>
          @endif
        </a>
        <div class="p-6">
          <h3 class="font-display uppercase font-700 text-2xl leading-none mb-2">{{ $car->name }}</h3>
          <p class="font-mono text-[11px] uppercase tick text-[var(--alloy)] mb-5">{{ $car->category }} · {{ $car->year }} · {{ $car->transmission }}</p>
          <div class="flex items-center justify-between border-t hairline pt-4">
            <span class="font-mono text-sm">{{ $car->formatted_price }}</span>
            <div class="flex items-center gap-3">
              <a href="{{ route('cars.show', $car) }}" class="font-mono text-xs uppercase tick text-[var(--ignition)] underline-grow">Detail →</a>
              @auth
                @if(auth()->user()->isAdmin())
                  <a href="{{ route('cars.edit', $car) }}" class="font-mono text-xs uppercase tick text-[var(--alloy)] hover:text-[var(--chrome)]">Edit</a>
                @endif
              @endauth
            </div>
          </div>
        </div>
      </article>
      @endforeach
    </div>

    <div class="mt-14">
      {{ $cars->links() }}
    </div>
  @endif
</section>

@endsection
