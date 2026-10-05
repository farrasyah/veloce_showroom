@extends('layouts.app')

@section('title', 'Permintaan Test Drive — VELOCE')

@section('content')

<section class="max-w-6xl mx-auto px-6 lg:px-8 pt-14 pb-24">
  <p class="font-mono text-xs uppercase tick text-[var(--ignition)] mb-3">Admin</p>
  <h1 class="font-display uppercase font-800 text-4xl lg:text-5xl mb-10">Permintaan<br>Test Drive</h1>

  @if(session('status'))
    <div class="bg-[#1f3a24]/40 border border-[#2f5233] text-[#8fd39a] text-sm font-mono px-4 py-3 rounded-2xl mb-8">
      {{ session('status') }}
    </div>
  @endif

  {{-- FILTER STATUS --}}
  <div class="flex flex-wrap gap-3 mb-10 font-mono text-xs uppercase tick">
    <a href="{{ route('admin.testdrives.index') }}"
       class="px-5 py-2.5 rounded-full border hairline transition {{ request('status') ? 'text-[var(--alloy)] hover:text-[var(--chrome)]' : 'bg-[var(--ignition)] text-[var(--asphalt)] border-transparent' }}">
      Semua
    </a>
    @foreach($statuses as $value => $label)
      <a href="{{ route('admin.testdrives.index', ['status' => $value]) }}"
         class="px-5 py-2.5 rounded-full border hairline transition {{ request('status') === $value ? 'bg-[var(--ignition)] text-[var(--asphalt)] border-transparent' : 'text-[var(--alloy)] hover:text-[var(--chrome)]' }}">
        {{ $label }}
      </a>
    @endforeach
  </div>

  @if($testDrives->isEmpty())
    <div class="border hairline rounded-[28px] p-14 text-center text-[var(--alloy)]">
      Belum ada permintaan test drive yang masuk.
    </div>
  @else
    <div class="space-y-4">
      @foreach($testDrives as $testDrive)
        <div class="border hairline rounded-[24px] p-6 grid lg:grid-cols-[2fr_1fr_auto] gap-6 items-center">
          <div>
            <p class="font-display uppercase font-700 text-xl mb-1">{{ $testDrive->name }}</p>
            <p class="font-mono text-xs text-[var(--alloy)]">{{ $testDrive->phone }}</p>
            <p class="font-mono text-xs text-[var(--alloy)] mt-1">
              Unit: {{ $testDrive->car_interest ?? ($testDrive->car->name ?? '—') }}
            </p>
            @if($testDrive->preferred_date)
              <p class="font-mono text-xs text-[var(--alloy)]">Tanggal preferensi: {{ $testDrive->preferred_date->format('d M Y') }}</p>
            @endif
            <p class="font-mono text-[11px] text-[var(--alloy-dim)] mt-2">Masuk {{ $testDrive->created_at->diffForHumans() }}</p>
          </div>

          <div>
            <span class="font-mono text-[11px] uppercase tick px-3 py-1.5 rounded-full border hairline text-[var(--alloy)]">
              {{ $testDrive->status_label }}
            </span>
          </div>

          <div class="flex flex-col sm:flex-row gap-3">
            <form action="{{ route('admin.testdrives.update', $testDrive) }}" method="POST" class="flex items-center gap-2">
              @csrf
              @method('PATCH')
              <select name="status" class="field bg-[var(--titanium-2)] border hairline rounded-2xl px-4 py-2.5 text-xs font-mono uppercase tick">
                @foreach($statuses as $value => $label)
                  <option value="{{ $value }}" @selected($testDrive->status === $value)>{{ $label }}</option>
                @endforeach
              </select>
              <button type="submit" class="btn-ghost border hairline font-mono text-xs font-600 uppercase tick px-5 py-2.5 rounded-full transition">Simpan</button>
            </form>

            <form action="{{ route('admin.testdrives.destroy', $testDrive) }}" method="POST" onsubmit="return confirm('Hapus permintaan test drive dari {{ $testDrive->name }}?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="font-mono text-xs font-600 uppercase tick px-5 py-2.5 rounded-full border border-[#5a2a22] text-[#e8907f] hover:bg-[#3a2a1f]/40 transition">Hapus</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-14">
      {{ $testDrives->links() }}
    </div>
  @endif
</section>

@endsection
