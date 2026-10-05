@php
  $c = $car ?? null;
  $val = fn($field, $default = '') => old($field, $c?->$field ?? $default);
@endphp

@if($errors->any())
  <div class="bg-[#3a2a1f]/40 border border-[#5a4022] text-[#d3a06a] text-sm font-mono px-4 py-3 rounded-2xl mb-8">
    <p class="mb-2 uppercase tick text-xs">Periksa kembali isian berikut:</p>
    <ul class="list-disc list-inside space-y-1">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="grid sm:grid-cols-2 gap-5">
  <div class="sm:col-span-2">
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Nama Mobil</label>
    <input type="text" name="name" value="{{ $val('name') }}" required placeholder="Contoh: Grand Tourer 4.0 V8"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Brand</label>
    <input type="text" name="brand" value="{{ $val('brand') }}" required
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Kategori</label>
    <input type="text" name="category" value="{{ $val('category') }}" required placeholder="Sedan, SUV, Coupe, dst."
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Tahun</label>
    <input type="number" name="year" value="{{ $val('year', date('Y')) }}" required min="1980" max="{{ date('Y') + 1 }}"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Harga (Rp)</label>
    <input type="number" name="price" value="{{ $val('price') }}" required min="0" step="1"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Transmisi</label>
    <select name="transmission" required class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
      @foreach(['Automatic','Manual','CVT'] as $t)
        <option value="{{ $t }}" @selected($val('transmission') === $t)>{{ $t }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Bahan Bakar</label>
    <select name="fuel_type" required class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
      @foreach(['Bensin','Diesel','Hybrid','Listrik'] as $f)
        <option value="{{ $f }}" @selected($val('fuel_type') === $f)>{{ $f }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Kapasitas Mesin (CC)</label>
    <input type="number" name="engine_cc" value="{{ $val('engine_cc') }}" min="0"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Kapasitas Kursi</label>
    <input type="number" name="seat_capacity" value="{{ $val('seat_capacity') }}" min="1" max="20"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Konsumsi BBM (KM/L)</label>
    <input type="number" step="0.1" name="fuel_consumption_kmpl" value="{{ $val('fuel_consumption_kmpl') }}" min="0"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Rating (0–5)</label>
    <input type="number" step="0.1" name="rating" value="{{ $val('rating') }}" min="0" max="5"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div class="sm:col-span-2">
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Foto Mobil</label>
    <input type="file" name="image" accept="image/*"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm file:mr-4 file:font-mono file:text-xs file:uppercase file:bg-[var(--titanium)] file:border-0 file:rounded-full file:px-4 file:py-2 file:text-[var(--chrome)]">
    @if($c?->image)
      <p class="font-mono text-[11px] text-[var(--alloy-dim)] mt-2">Foto saat ini: {{ $c->image }} — upload file baru untuk mengganti.</p>
    @endif
  </div>

  <div class="sm:col-span-2">
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Deskripsi</label>
    <textarea name="description" rows="3" class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">{{ $val('description') }}</textarea>
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Kelebihan (satu per baris)</label>
    <textarea name="pros" rows="4" class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">{{ old('pros', $c?->pros ? implode("\n", $c->pros) : '') }}</textarea>
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Kekurangan (satu per baris)</label>
    <textarea name="cons" rows="4" class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">{{ old('cons', $c?->cons ? implode("\n", $c->cons) : '') }}</textarea>
  </div>

  <div class="sm:col-span-2">
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Review Singkat</label>
    <textarea name="review" rows="2" class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">{{ $val('review') }}</textarea>
  </div>

  <div class="sm:col-span-2 flex items-center gap-3">
    <input type="checkbox" name="is_featured" id="is_featured" value="1" @checked($val('is_featured')) class="w-4 h-4">
    <label for="is_featured" class="font-mono text-xs uppercase tick text-[var(--alloy)]">Tampilkan sebagai unit unggulan</label>
  </div>
</div>
