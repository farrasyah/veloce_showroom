@extends('layouts.app')

@section('title', 'Kelola Testimoni — VELOCE')

@section('content')

<section class="max-w-5xl mx-auto px-6 lg:px-8 pt-14 pb-24">
  <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">Admin</p>
  <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">
    <h1 class="font-display uppercase font-800 text-4xl lg:text-5xl">Kelola<br>Testimoni</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-ignition font-mono text-sm font-600 uppercase tick px-7 py-3.5 rounded-full transition inline-block w-fit">+ Tambah Testimoni</a>
  </div>

  @if(session('status'))
    <div class="bg-[#1f3a24]/40 border border-[#2f5233] text-[#8fd39a] text-sm font-mono px-4 py-3 rounded-2xl mb-8">
      {{ session('status') }}
    </div>
  @endif

  @if($testimonials->isEmpty())
    <div class="border hairline rounded-[28px] p-14 text-center text-[var(--alloy)]">
      Belum ada testimoni. Tambahkan yang pertama lewat tombol di atas.
    </div>
  @else
    <div class="space-y-4">
      @foreach($testimonials as $testimonial)
        <div class="border hairline rounded-[24px] p-6 grid lg:grid-cols-[1fr_auto] gap-6 items-center">
          <div>
            <p class="text-[var(--chrome)] leading-relaxed mb-3">"{{ $testimonial->quote }}"</p>
            <p class="font-mono text-xs uppercase tick text-[var(--alloy)]">{{ $testimonial->name }} — {{ $testimonial->unit }}</p>
          </div>

          <div class="flex gap-3">
            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn-ghost border hairline font-mono text-xs font-600 uppercase tick px-5 py-2.5 rounded-full transition">Edit</a>
            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Hapus testimoni dari {{ $testimonial->name }}?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="font-mono text-xs font-600 uppercase tick px-5 py-2.5 rounded-full border border-[#5a2a22] text-[#e8907f] hover:bg-[#3a2a1f]/40 transition">Hapus</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-14">
      {{ $testimonials->links() }}
    </div>
  @endif
</section>

@endsection
