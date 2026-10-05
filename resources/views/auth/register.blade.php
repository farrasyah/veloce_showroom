@extends('layouts.app')

@section('title', 'Daftar — VELOCE')

@section('content')

<section class="max-w-md mx-auto px-6 pt-16 pb-24">
  <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3 text-center">Bergabung dengan Veloce</p>
  <h1 class="font-display uppercase font-800 text-4xl mb-10 text-center">Buat Akun</h1>

  @if($errors->any())
    <div class="bg-[#3a2a1f]/40 border border-[#5a4022] text-[#d3a06a] text-sm font-mono px-4 py-3 rounded-2xl mb-6">
      @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('register.attempt') }}" class="space-y-4">
    @csrf
    <div>
      <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Nama Lengkap</label>
      <input type="text" name="name" value="{{ old('name') }}" required autofocus
             class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
    </div>
    <div>
      <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required
             class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
    </div>
    <div>
      <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Kata Sandi</label>
      <input type="password" name="password" required minlength="8"
             class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
    </div>
    <div>
      <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Konfirmasi Kata Sandi</label>
      <input type="password" name="password_confirmation" required minlength="8"
             class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
    </div>
    <button type="submit" class="btn-ignition w-full font-mono text-sm font-600 uppercase tick px-7 py-4 rounded-full mt-2 transition">Daftar</button>
  </form>

  <p class="text-center text-sm text-[var(--alloy)] mt-8">
    Sudah punya akun? <a href="{{ route('login') }}" class="text-[var(--ignition)] underline-grow">Masuk di sini</a>
  </p>
</section>

@endsection
