@extends('layouts.app')

@section('title', $car->name . ' — VELOCE')

@section('content')

<section class="max-w-6xl mx-auto px-6 lg:px-8 pt-14 pb-6">

  @if(session('status'))
    <div class="bg-[#1f3a24]/40 border border-[#2f5233] text-[#8fd39a] text-sm font-mono px-4 py-3 rounded-2xl mb-8">
      {{ session('status') }}
    </div>
  @endif

  <a href="{{ route('cars.index') }}" class="font-mono text-xs uppercase tick text-[var(--alloy)] hover:text-[var(--chrome)] mb-8 inline-block">← Kembali ke koleksi</a>

  <div class="grid lg:grid-cols-2 gap-10 mb-16">
    <div class="rounded-[32px] overflow-hidden aspect-[4/3] car-photo {{ empty($car->image) ? 'placeholder' : '' }} flex items-center justify-center border hairline"
         @if(!empty($car->image)) style="background-image:url('{{ asset('images/cars/'.$car->image) }}')" @endif>
      @if(empty($car->image))
      <svg class="w-20 h-20 text-[var(--alloy-dim)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M3 13l1.5-4.5A2 2 0 0 1 6.4 7h11.2a2 2 0 0 1 1.9 1.5L21 13"/><path d="M3 13h18v4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1H6v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-4Z"/><circle cx="7" cy="17.5" r="1.5"/><circle cx="17" cy="17.5" r="1.5"/></svg>
      @endif
    </div>

    <div>
      <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">{{ $car->brand }} · {{ $car->category }}</p>
      <h1 class="font-display uppercase font-800 text-4xl lg:text-5xl mb-4">{{ $car->name }}</h1>
      <p class="font-mono text-2xl mb-6">{{ $car->formatted_price }}</p>

      <div class="grid grid-cols-2 gap-4 mb-8 font-mono text-xs uppercase tick text-[var(--alloy)]">
        <div class="border hairline rounded-2xl px-4 py-3"><span class="block text-[var(--chrome)] text-sm mb-1">{{ $car->year }}</span>Tahun</div>
        <div class="border hairline rounded-2xl px-4 py-3"><span class="block text-[var(--chrome)] text-sm mb-1">{{ $car->transmission }}</span>Transmisi</div>
        <div class="border hairline rounded-2xl px-4 py-3"><span class="block text-[var(--chrome)] text-sm mb-1">{{ $car->fuel_type }}</span>Bahan Bakar</div>
        <div class="border hairline rounded-2xl px-4 py-3"><span class="block text-[var(--chrome)] text-sm mb-1">{{ $car->seat_capacity ?? '-' }} Kursi</span>Kapasitas</div>
        @if($car->engine_cc)
        <div class="border hairline rounded-2xl px-4 py-3"><span class="block text-[var(--chrome)] text-sm mb-1">{{ $car->engine_cc }} CC</span>Mesin</div>
        @endif
        @if($car->fuel_consumption_kmpl)
        <div class="border hairline rounded-2xl px-4 py-3"><span class="block text-[var(--chrome)] text-sm mb-1">{{ $car->fuel_consumption_kmpl }} KM/L</span>Konsumsi</div>
        @endif
      </div>

      @if($car->description)
        <p class="text-[var(--alloy)] leading-relaxed mb-8">{{ $car->description }}</p>
      @endif

      @auth
        @if(auth()->user()->isAdmin())
        <div class="flex flex-wrap gap-3">
          <a href="{{ route('cars.edit', $car) }}" class="btn-ghost border hairline font-mono text-sm font-600 uppercase tick px-6 py-3 rounded-full transition">Edit</a>
          <form action="{{ route('cars.destroy', $car) }}" method="POST" onsubmit="return confirm('Hapus {{ $car->name }}? Tindakan ini tidak bisa dibatalkan.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="font-mono text-sm font-600 uppercase tick px-6 py-3 rounded-full border border-[#5a2a22] text-[#e8907f] hover:bg-[#3a2a1f]/40 transition">Hapus</button>
          </form>
        </div>
        @endif
      @endauth
    </div>
  </div>

  @if($car->pros || $car->cons)
  <div class="grid md:grid-cols-2 gap-6 mb-16">
    @if(!empty($car->pros))
    <div class="border hairline rounded-[24px] p-7">
      <h3 class="font-display uppercase font-700 text-xl mb-4 text-[#8fd39a]">Kelebihan</h3>
      <ul class="space-y-2 text-sm text-[var(--alloy)]">
        @foreach($car->pros as $p)
          <li>+ {{ $p }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    @if(!empty($car->cons))
    <div class="border hairline rounded-[24px] p-7">
      <h3 class="font-display uppercase font-700 text-xl mb-4 text-[#d3a06a]">Kekurangan</h3>
      <ul class="space-y-2 text-sm text-[var(--alloy)]">
        @foreach($car->cons as $c)
          <li>− {{ $c }}</li>
        @endforeach
      </ul>
    </div>
    @endif
  </div>
  @endif

  @if($car->review)
    <div class="border hairline rounded-[24px] p-7 mb-16">
      <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">Review</p>
      <p class="text-[var(--chrome)] leading-relaxed">"{{ $car->review }}"</p>
    </div>
  @endif

  {{-- KOMENTAR --}}
  <div id="komentar" class="mb-16">
    <h2 class="font-display uppercase font-800 text-3xl mb-8">Komentar ({{ $car->comments->count() }})</h2>

    @auth
      <form method="POST" action="{{ route('comments.store', $car) }}" class="border hairline rounded-[24px] p-6 mb-8 space-y-3">
        @csrf
        <textarea name="content" required maxlength="1000" rows="3" placeholder="Tulis komentar Anda tentang mobil ini..."
                  class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">{{ old('content') }}</textarea>
        <div class="flex flex-wrap items-center gap-3">
          <select name="rating" class="field bg-[var(--titanium-2)] border hairline rounded-2xl px-4 py-2.5 text-sm">
            <option value="">Rating (opsional)</option>
            @for ($i = 5; $i >= 1; $i--)
              <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} ★</option>
            @endfor
          </select>
          <button type="submit" class="btn-ignition font-mono text-xs font-600 uppercase tick px-6 py-3 rounded-full transition">Kirim Komentar</button>
        </div>
        @error('content')<p class="text-xs text-[#e8907f]">{{ $message }}</p>@enderror
      </form>
    @else
      <p class="text-sm text-[var(--alloy)] mb-8"><a href="{{ route('login') }}" class="underline">Masuk</a> terlebih dahulu untuk menulis komentar.</p>
    @endauth

    <div class="space-y-4">
      @forelse($car->comments as $comment)
        <div class="border hairline rounded-2xl p-5" id="comment-{{ $comment->id }}">
          <div class="flex items-center justify-between mb-2 gap-3">
            <div>
              <span class="font-mono text-sm text-[var(--chrome)]">{{ $comment->user->name }}</span>
              @if($comment->rating)
                <span class="font-mono text-xs text-[var(--ignition)] ml-2">{{ str_repeat('★', $comment->rating) }}</span>
              @endif
            </div>
            <span class="font-mono text-xs text-[var(--alloy-dim)] whitespace-nowrap">{{ $comment->created_at->diffForHumans() }}</span>
          </div>

          <p class="text-sm text-[var(--alloy)] leading-relaxed">{{ $comment->content }}</p>

          @auth
            @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
              <div class="flex gap-4 mt-3">
                @if(auth()->id() === $comment->user_id)
                  <button type="button" onclick="document.getElementById('edit-comment-{{ $comment->id }}').classList.toggle('hidden')"
                          class="font-mono text-xs uppercase tick text-[var(--alloy)] hover:text-[var(--chrome)]">Edit</button>
                @endif
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="font-mono text-xs uppercase tick text-[#e8907f] hover:text-[#f0a894]">Hapus</button>
                </form>
              </div>

              @if(auth()->id() === $comment->user_id)
                <form id="edit-comment-{{ $comment->id }}" action="{{ route('comments.update', $comment) }}" method="POST" class="hidden mt-4 space-y-2">
                  @csrf
                  @method('PUT')
                  <textarea name="content" required maxlength="1000" rows="2"
                            class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-4 py-2.5 text-sm">{{ $comment->content }}</textarea>
                  <div class="flex items-center gap-3">
                    <select name="rating" class="field bg-[var(--titanium-2)] border hairline rounded-2xl px-3 py-2 text-xs">
                      <option value="">Rating (opsional)</option>
                      @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" @selected($comment->rating == $i)>{{ $i }} ★</option>
                      @endfor
                    </select>
                    <button type="submit" class="btn-ghost border hairline font-mono text-xs font-600 uppercase tick px-5 py-2.5 rounded-full transition">Simpan</button>
                  </div>
                </form>
              @endif
            @endif
          @endauth
        </div>
      @empty
        <p class="text-sm text-[var(--alloy-dim)]">Belum ada komentar. Jadilah yang pertama menulis komentar untuk mobil ini.</p>
      @endforelse
    </div>
  </div>

  @if($relatedCars->isNotEmpty())
  <div class="mb-16">
    <h2 class="font-display uppercase font-800 text-3xl mb-8">Unit sejenis lainnya</h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($relatedCars as $rc)
      <a href="{{ route('cars.show', $rc) }}" class="card border hairline rounded-[24px] overflow-hidden bg-[var(--titanium)] block">
        <div class="car-photo aspect-[4/3] {{ empty($rc->image) ? 'placeholder' : '' }}"
             @if(!empty($rc->image)) style="background-image:url('{{ asset('images/cars/'.$rc->image) }}')" @endif></div>
        <div class="p-5">
          <h4 class="font-display uppercase font-700 text-lg mb-1">{{ $rc->name }}</h4>
          <p class="font-mono text-xs text-[var(--alloy)]">{{ $rc->formatted_price }}</p>
        </div>
      </a>
      @endforeach
    </div>
  </div>
  @endif

</section>

@endsection
