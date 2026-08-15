@props([
    'action' => '',
    'itemName' => '',
    'itemType' => 'item',
    'message' => null,
])

@php
    $messageHtml = $message ?? ('Yakin ingin menghapus <strong class="text-slate-700">' . e($itemName) . '</strong>? Tindakan ini tidak dapat dibatalkan.');
@endphp

<div x-data="{ open: false }" class="inline-flex">
    <button type="button"
            @click="open = true"
            class="p-2 rounded-lg text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors"
            title="Hapus"
            aria-label="Hapus {{ $itemName }}">
        <i class="ri-delete-bin-line"></i>
    </button>

    <div x-show="open" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         role="dialog" aria-modal="true"
         @keydown.escape.window="open = false">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="open = false"></div>

        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 p-6"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-2 scale-95">
            <div class="flex items-start gap-4">
                <span class="w-11 h-11 shrink-0 rounded-xl bg-red-50 text-red-500 flex items-center justify-center">
                    <i class="ri-delete-bin-6-line text-xl"></i>
                </span>
                <div class="min-w-0 flex-1">
                    <h3 class="font-poppins font-bold text-slate-800">Hapus {{ ucfirst($itemType) }}?</h3>
                    <p class="text-sm text-slate-500 mt-1 leading-relaxed">{!! $messageHtml !!}</p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2.5 mt-6">
                <button type="button" @click="open = false"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <form method="POST" action="{{ $action }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition-colors">
                        <i class="ri-delete-bin-line"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
