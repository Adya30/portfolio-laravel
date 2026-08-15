@props([
    'name' => 'tools',
    'tools' => collect(),
    'selected' => [],
])

@php
    $selected = collect($selected);
    $hasError = $errors->has($name);
@endphp

<div class="space-y-1.5">
    <span class="block text-sm font-semibold text-slate-700">Teknologi (Tools)</span>

    @if ($tools->isEmpty())
        <p class="text-sm text-slate-400">
            Belum ada tool tersedia.
            <a href="{{ route('admin.tools.create') }}" class="text-accent font-semibold hover:underline">Tambah tool</a>
            dulu di menu "Tools".
        </p>
    @else
        <div id="{{ $name }}" class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 mt-1.5">
            @foreach ($tools as $tool)
                <label class="relative flex items-center gap-2.5 rounded-xl border p-2.5 cursor-pointer transition-all duration-200
                              {{ $hasError ? 'border-red-300' : 'border-slate-200' }}
                              hover:border-accent/40 hover:bg-accent/5
                              has-checked:border-accent has-checked:bg-accent/10">
                    <input type="checkbox" name="{{ $name }}[]" value="{{ $tool->id }}"
                           @checked($selected->contains($tool->id))
                           class="peer sr-only">
                    <span class="w-8 h-8 shrink-0 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center overflow-hidden">
                        @if ($tool->gambar)
                            <img src="{{ img_url($tool->gambar) }}" alt="{{ $tool->nama }}" class="w-5 h-5 object-contain">
                        @else
                            <i class="ri-vip-diamond-line text-sm text-accent/60"></i>
                        @endif
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-sm font-medium text-slate-700 truncate">{{ $tool->nama }}</span>
                        @if ($tool->ket)
                            <span class="block text-[11px] text-slate-400 truncate">{{ $tool->ket }}</span>
                        @endif
                    </span>
                    <span class="w-5 h-5 shrink-0 rounded-full border border-slate-200 bg-white flex items-center justify-center transition-all duration-200 peer-checked:bg-accent peer-checked:border-accent">
                        <i class="ri-check-line text-[11px] text-white opacity-0 peer-checked:opacity-100"></i>
                    </span>
                </label>
            @endforeach
        </div>
    @endif

    <p class="text-xs text-slate-400">Pilih teknologi / skill yang digunakan pada project. Kelola daftar pilihan di menu "Tools".</p>

    @if ($hasError)
        @error($name)
            <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    @endif
</div>
