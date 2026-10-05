@extends('layouts.app')

@section('title', 'Tambah Testimoni — VELOCE')

@section('content')

<section class="max-w-3xl mx-auto px-6 lg:px-8 pt-14 pb-24">
  <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">Kelola testimoni</p>
  <h1 class="font-display uppercase font-800 text-4xl lg:text-5xl mb-10">Tambah testimoni baru</h1>

  <form method="POST" action="{{ route('admin.testimonials.store') }}">
    @csrf
    @include('admin.testimonials._form')

    <div class="mt-10 flex flex-wrap gap-4">
      <button type="submit" class="btn-ignition font-mono text-sm font-600 uppercase tick px-8 py-3.5 rounded-full transition">Simpan Testimoni</button>
      <a href="{{ route('admin.testimonials.index') }}" class="btn-ghost border hairline font-mono text-sm font-600 uppercase tick px-8 py-3.5 rounded-full transition">Batal</a>
    </div>
  </form>
</section>

@endsection
