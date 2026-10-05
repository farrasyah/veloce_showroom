@php
  $t = $testimonial ?? null;
  $val = fn($field, $default = '') => old($field, $t?->$field ?? $default);
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
  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Nama Pelanggan</label>
    <input type="text" name="name" value="{{ $val('name') }}" required placeholder="Contoh: Kamin"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div>
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Unit yang Dibeli</label>
    <input type="text" name="unit" value="{{ $val('unit') }}" required placeholder="Contoh: Mitsubishi Pajero"
           class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">
  </div>

  <div class="sm:col-span-2">
    <label class="font-mono text-xs uppercase tick text-[var(--alloy)] block mb-2">Isi Testimoni</label>
    <textarea name="quote" rows="4" required maxlength="1000" placeholder="Tulis testimoni dari pelanggan di sini..."
              class="field w-full bg-[var(--titanium-2)] border hairline rounded-2xl px-5 py-3.5 text-sm">{{ $val('quote') }}</textarea>
  </div>
</div>
