@extends('layouts.app')

@section('title', 'VELOCE — Showroom Mobil Premium')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden pt-10">
  <div class="max-w-6xl mx-auto px-6 lg:px-8 pt-14 pb-10">
    <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-6 text-center">Showroom Veloce</p>
    <h1 class="font-display uppercase font-800 leading-[0.92] text-[12vw] sm:text-[8vw] lg:text-[5.2vw] text-center">
      Mobil Bekas,<br>Kualitas kelas atas.
    </h1>
    <p class="mt-7 max-w-lg mx-auto text-center text-[var(--alloy)] text-base leading-relaxed">
      Setiap unit melewati inspeksi 150 titik sebelum kami berani memajangnya. Kami bukan menjual mobil bekas — kami menyeleksi mobil terbaik yang layak jadi milik Anda berikutnya.
    </p>
    <div class="mt-9 flex flex-wrap items-center justify-center gap-4">
      <a href="#koleksi" class="btn-ignition font-mono text-sm font-600 uppercase tick px-7 py-3.5 rounded-full transition">Lihat Koleksi</a>
      <a href="#kontak" class="btn-ghost border hairline font-mono text-sm font-600 uppercase tick px-7 py-3.5 rounded-full text-[var(--chrome)] transition">Jadwalkan Test Drive</a>
    </div>
  </div>

  {{-- HERO SHOWCASE PANEL --}}
  <div class="max-w-6xl mx-auto px-4 sm:px-6 pb-4">
    <div class="relative rounded-[36px] overflow-hidden aspect-[16/8] border hairline flex items-center justify-center bg-cover bg-center"
         style="background-image:url('{{ asset('images/hero-featured.webp') }}')">
    </div>
  </div>

  {{-- SPEC TICKER --}}
  <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-4 mb-2">
    <div class="ticker-wrap border hairline bg-[var(--titanium)] rounded-full overflow-hidden">
      <div class="ticker-track inline-block py-3 font-mono text-xs uppercase tick text-[var(--alloy)]">
        @for($i = 0; $i < 2; $i++)
          <span class="mx-6">0–100 KM/J : 3.4 DETIK</span>
          <span class="mx-6 text-[var(--ignition)]">•</span>
          <span class="mx-6">TENAGA HINGGA : 640 HP</span>
          <span class="mx-6 text-[var(--ignition)]">•</span>
          <span class="mx-6">UNIT TERSEDIA : {{ count($cars) }}</span>
          <span class="mx-6 text-[var(--ignition)]">•</span>
          <span class="mx-6">GARANSI : 24 BULAN</span>
          <span class="mx-6 text-[var(--ignition)]">•</span>
          <span class="mx-6">INSPEKSI : 150 TITIK PEMERIKSAAN</span>
          <span class="mx-6 text-[var(--ignition)]">•</span>
        @endfor
      </div>
    </div>
  </div>
</section>

{{-- KOLEKSI --}}
<section id="koleksi" class="max-w-6xl mx-auto px-6 lg:px-8 py-20 lg:py-28">
  <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14">
    <div>
      <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">Koleksi terkini</p>
      <h2 class="font-display uppercase font-800 text-4xl lg:text-5xl">Unit siap diantar<br>minggu ini</h2>
    </div>
  </div>

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($cars as $index => $car)
    <article class="card border hairline rounded-[28px] overflow-hidden bg-[var(--titanium)]">
      <a href="{{ route('cars.show', $car) }}" class="car-photo aspect-[4/3] flex items-center justify-center relative {{ empty($car->image) ? 'placeholder' : '' }}"
           @if(!empty($car->image)) style="background-image:url('{{ asset('images/cars/'.$car->image) }}')" @endif>
        <span class="absolute top-4 left-4 font-mono text-[10px] uppercase tick bg-[var(--asphalt)]/80 backdrop-blur px-3 py-1.5 rounded-full text-[var(--alloy)]">
          Lot {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
        </span>
        <span class="absolute top-4 right-4 font-mono text-[10px] uppercase tick px-3 py-1.5 rounded-full
          {{ $car->is_featured ? 'bg-[#1f3a24]/90 text-[#8fd39a]' : 'bg-[#3a2a1f]/90 text-[#d3a06a]' }}">
          {{ $car->is_featured ? 'Unggulan' : 'Tersedia' }}
        </span>
        @if(empty($car->image))
        <svg class="w-14 h-14 text-[var(--alloy-dim)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M3 13l1.5-4.5A2 2 0 0 1 6.4 7h11.2a2 2 0 0 1 1.9 1.5L21 13"/><path d="M3 13h18v4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1H6v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-4Z"/><circle cx="7" cy="17.5" r="1.5"/><circle cx="17" cy="17.5" r="1.5"/></svg>
        @endif
      </a>
      <div class="p-6">
        <h3 class="font-display uppercase font-700 text-2xl leading-none mb-2">{{ $car->name }}</h3>
        <p class="font-mono text-[11px] uppercase tick text-[var(--alloy)] mb-5">{{ $car->brand }} · {{ $car->year }} · {{ $car->transmission }} · {{ $car->fuel_type }}</p>
        <div class="flex items-center justify-between border-t hairline pt-4">
          <span class="font-mono text-sm">{{ $car->formatted_price }}</span>
          <a href="{{ route('cars.show', $car) }}" class="font-mono text-xs uppercase tick text-[var(--ignition)] underline-grow">Lihat detail →</a>
        </div>
      </div>
    </article>
    @empty
    <p class="text-[var(--alloy)] text-sm sm:col-span-2 lg:col-span-3">Belum ada mobil di database. Tambahkan lewat menu Kelola Mobil.</p>
    @endforelse
  </div>

  <div class="mt-12 text-center">
    <a href="{{ route('cars.index') }}" class="btn-ghost border hairline font-mono text-sm font-600 uppercase tick px-8 py-3.5 rounded-full inline-block transition">Lihat Semua Unit</a>
  </div>
</section>

{{-- KENAPA VELOCE --}}
<section id="kenapa" class="max-w-6xl mx-auto px-6 lg:px-8 py-4">
  <div class="bg-[var(--titanium)] border hairline rounded-[36px] px-8 py-16 lg:px-16 lg:py-20">
    <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">Kenapa Veloce</p>
    <h2 class="font-display uppercase font-800 text-4xl lg:text-5xl mb-14 max-w-2xl">Bukan sekadar menjual, kami menjamin</h2>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
      @php
        $keunggulan = [
          ['no' => '01', 'title' => 'Inspeksi 150 titik', 'desc' => 'Mesin, kelistrikan, hingga cat diperiksa teknisi bersertifikat sebelum unit naik display.', 'icon' => '<path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/>'],
          ['no' => '02', 'title' => 'Garansi resmi', 'desc' => 'Setiap unit dibekali garansi mesin dan transmisi hingga 24 bulan tanpa syarat rumit.', 'icon' => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3Z"/>'],
          ['no' => '03', 'title' => 'Kredit & trade-in', 'desc' => 'Simulasi cicilan transparan dan penawaran tukar tambah dihitung di tempat, hari itu juga.', 'icon' => '<rect x="3" y="6" width="18" height="12" rx="1"/><path d="M3 10h18M7 14h4"/>'],
          ['no' => '04', 'title' => 'Layanan purna jual', 'desc' => 'Servis berkala dan suku cadang tersedia di bengkel rekanan kami di seluruh kota.', 'icon' => '<path d="M4 20v-6a8 8 0 0 1 16 0v6"/><path d="M4 20h4v-4H4v4Zm12-4h4v4h-4v-4Z"/>'],
        ];
      @endphp
      @foreach($keunggulan as $item)
      <div class="perk bg-[var(--titanium-2)] border hairline rounded-[24px] p-7">
        <p class="font-mono text-xs text-[var(--ignition)] mb-4">{{ $item['no'] }}</p>
        <svg class="w-8 h-8 mb-5 text-[var(--chrome)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3">{!! $item['icon'] !!}</svg>
        <h3 class="font-display uppercase font-700 text-xl mb-2">{{ $item['title'] }}</h3>
        <p class="text-sm text-[var(--alloy)] leading-relaxed">{{ $item['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- TESTIMONI --}}
<section id="testimoni" class="max-w-6xl mx-auto px-6 lg:px-8 py-20 lg:py-28">
  <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">Testimoni</p>
  <h2 class="font-display uppercase font-800 text-4xl lg:text-5xl mb-14 max-w-2xl">Kata mereka yang sudah membawa pulang unitnya</h2>

  @if($testimonials->isEmpty())
    <p class="text-sm text-[var(--alloy-dim)]">Belum ada testimoni.</p>
  @else
    <div class="grid md:grid-cols-3 gap-6">
      @foreach($testimonials as $t)
      <div class="border hairline rounded-[24px] p-7">
        <p class="text-[var(--chrome)] leading-relaxed mb-6">"{{ $t->quote }}"</p>
        <p class="font-mono text-xs uppercase tick text-[var(--alloy)]">{{ $t->name }} — {{ $t->unit }}</p>
      </div>
      @endforeach
    </div>
  @endif
</section>

{{-- CTA / KONTAK --}}
<section id="kontak" class="max-w-6xl mx-auto px-6 lg:px-8 pb-24">
  <div class="bg-[var(--titanium)] border hairline rounded-[36px] px-8 py-16 lg:px-16 lg:py-20 grid lg:grid-cols-2 gap-16">
    <div>
      <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">Jadwalkan test drive</p>
      <h2 class="font-display uppercase font-800 text-4xl lg:text-5xl mb-6">Coba dulu,<br>baru putuskan.</h2>
      <p class="text-[var(--alloy)] leading-relaxed max-w-md mb-8">Isi form di samping, tim kami akan menghubungi Anda dalam 1x24 jam untuk mengatur jadwal test drive di showroom atau lokasi Anda.</p>
      <div class="space-y-3 font-mono text-sm text-[var(--alloy)]">
        <p>Jl. Hertasning Baru Blok A7 No.4, Makassar</p>
        <p>+62 821 9466 9883</p>
        <p>Farras@veloce-motors.id</p>
        <p>Senin–Sabtu · 09.00–18.00</p>
      </div>
    </div>

    @if(session('status'))
      <div class="lg:col-span-1 bg-[#1f3a24]/40 border border-[#2f5233] text-[#8fd39a] text-sm font-mono px-4 py-3 rounded-2xl mb-2">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('testdrive.store') }}" class="space-y-4">
      @csrf
      <div>
        <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Nama lengkap</label>
        <input type="text" name="name" required placeholder="Nama Anda" class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
      </div>
      <div>
        <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Nomor WhatsApp</label>
        <input type="text" name="phone" required placeholder="08xx-xxxx-xxxx" class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
      </div>
      <div>
        <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Unit yang diminati</label>
        <input type="text" name="car_interest" placeholder="Contoh: Grand Tourer 4.0 V8" class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
      </div>
      <div>
        <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Tanggal preferensi</label>
        <input type="date" name="preferred_date" class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
      </div>
      <button type="submit" class="btn-ignition w-full font-mono text-sm font-600 uppercase tick px-7 py-4 rounded-full mt-2 transition">Kirim Permintaan</button>
    </form>
  </div>
</section>

@endsection
