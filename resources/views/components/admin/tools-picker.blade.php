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
    <div class="flex items-center justify-between">
        <span class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Tools /
            Teknologi Digunakan</span>
        <span class="text-[11px] text-slate-400">Klik untuk memilih</span>
    </div>

    @if ($tools->isEmpty())
        <p class="text-xs text-slate-400">
            Belum ada tool tersedia.
            <a href="{{ route('admin.tools.create') }}" class="text-accent font-semibold hover:underline">Tambah tool</a>
            dulu di menu "Tools".
        </p>
    @else
        <div id="{{ $name }}" class="grid grid-cols-3 gap-2 mt-1.5">
            @foreach ($tools as $tool)
                @php
                    $isChecked = $selected->contains($tool->id);
                @endphp
                <label x-data="{ checked: @js($isChecked) }"
                    :class="checked
                        ?
                        'border-2 border-blue-500 dark:border-blue-400 bg-blue-50/90 dark:bg-blue-600/30 text-blue-700 dark:text-white shadow-sm dark:shadow-[0_0_16px_rgba(59,130,246,0.4)] ring-1 ring-blue-500/20 dark:ring-blue-400/40' :
                        '{{ $hasError ? 'border-red-300' : 'border border-slate-200 dark:border-white/10' }} bg-white dark:bg-[#0c1322] text-slate-700 dark:text-slate-300 hover:border-blue-400/50 hover:bg-slate-50 dark:hover:bg-white/5'"
                    class="group relative flex flex-col items-center justify-center p-2.5 rounded-xl cursor-pointer transition-all duration-200 select-none has-[:checked]:border-2 has-[:checked]:border-blue-500 dark:has-[:checked]:border-blue-400 has-[:checked]:bg-blue-50/90 dark:has-[:checked]:bg-blue-600/30 dark:has-[:checked]:shadow-[0_0_16px_rgba(59,130,246,0.4)]"
                    title="{{ $tool->nama }}{{ $tool->ket ? ' - ' . $tool->ket : '' }}">
                    <input type="checkbox" name="{{ $name }}[]" value="{{ $tool->id }}"
                        @checked($isChecked) @change="checked = $el.checked" class="peer sr-only">

                    {{-- Icon Tengah --}}
                    <div class="w-8 h-8 flex items-center justify-center overflow-hidden shrink-0 mx-auto">
                        @if ($tool->gambar)
                            <img src="{{ img_url($tool->gambar) }}" alt="{{ $tool->nama }}"
                                class="w-6 h-6 object-contain mx-auto transition-transform duration-200 group-hover:scale-110"
                                :class="checked && 'scale-110'" loading="lazy">
                        @else
                            <i class="ri-vip-diamond-line text-lg text-accent"></i>
                        @endif
                    </div>

                    {{-- Nama Tool Terpusat --}}
                    <span
                        class="mt-1 block text-[10px] font-semibold truncate max-w-full text-center leading-tight transition-colors"
                        :class="checked ? 'text-blue-700 dark:text-white font-bold' : 'text-slate-700 dark:text-slate-300'">
                        {{ $tool->nama }}
                    </span>
                </label>
            @endforeach
        </div>
    @endif
    @if ($hasError)
        @error($name)
            <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    @endif
</div>
