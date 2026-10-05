@extends('layouts.app')

@section('title', 'Masuk — VELOCE')

@section('content')

<section class="max-w-md mx-auto px-6 pt-16 pb-24">
  <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3 text-center">Selamat datang kembali</p>
  <h1 class="font-display uppercase font-800 text-4xl mb-10 text-center">Masuk</h1>

  @if($errors->any())
    <div class="bg-[#3a2a1f]/40 border border-[#5a4022] text-[#d3a06a] text-sm font-mono px-4 py-3 rounded-2xl mb-6">
      @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
    @csrf
    <div>
      <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required autofocus
             class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
    </div>
    <div>
      <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Kata Sandi</label>
      <input type="password" name="password" required
             class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
    </div>
    <div class="flex items-center gap-3">
      <input type="checkbox" name="remember" id="remember" class="w-4 h-4">
      <label for="remember" class="font-mono text-xs uppercase tick text-[var(--alloy)]">Ingat saya</label>
    </div>
    <button type="submit" class="btn-ignition w-full font-mono text-sm font-600 uppercase tick px-7 py-4 rounded-full mt-2 transition">Masuk</button>
  </form>

  <p class="text-center text-sm text-[var(--alloy)] mt-8">
    Belum punya akun? <a href="{{ route('register') }}" class="text-[var(--ignition)] underline-grow">Daftar di sini</a>
  </p>
</section>

@endsection
