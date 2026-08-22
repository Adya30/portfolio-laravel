@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-5 mb-8">
        @php
            $stats = [
                ['label' => 'Total Project', 'value' => $projectsCount, 'icon' => 'ri-folder-open-line', 'route' => 'admin.projects.index', 'color' => 'text-accent bg-accent/10'],
                ['label' => 'Total Tools', 'value' => $toolsCount, 'icon' => 'ri-tools-line', 'route' => 'admin.tools.index', 'color' => 'text-cyan-600 bg-cyan-500/10'],
                ['label' => 'Total Sertifikat', 'value' => $certificatesCount, 'icon' => 'ri-award-line', 'route' => 'admin.certificates.index', 'color' => 'text-amber-600 bg-amber-500/10'],
                ['label' => 'Total Pengalaman', 'value' => $experiencesCount, 'icon' => 'ri-briefcase-line', 'route' => 'admin.experiences.index', 'color' => 'text-purple-600 bg-purple-500/10'],
                ['label' => 'Total Materi', 'value' => $coursesCount, 'icon' => 'ri-book-open-line', 'route' => 'admin.courses.index', 'color' => 'text-emerald-600 bg-emerald-500/10'],
            ];
        @endphp

        @foreach ($stats as $stat)
            <a href="{{ route($stat['route']) }}"
               class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:border-accent/30 hover:-translate-y-0.5 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-xl {{ $stat['color'] }} flex items-center justify-center">
                        <i class="{{ $stat['icon'] }} text-xl"></i>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $stat['value'] }}</p>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-0.5">{{ $stat['label'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-poppins font-bold text-slate-800">Project Terbaru</h3>
                <a href="{{ route('admin.projects.index') }}" class="text-xs font-semibold text-accent hover:underline">Lihat semua</a>
            </div>
            <ul class="divide-y divide-slate-100">
                @forelse ($recentProjects as $project)
                    <li class="px-5 py-3.5 flex items-center gap-3">
                        <img src="{{ img_url($project->gambar) }}" alt="{{ $project->nama }}"
                             class="w-11 h-8 rounded-lg object-cover bg-slate-50" loading="lazy">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $project->nama }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $project->desk }}</p>
                        </div>
                        <a href="{{ route('admin.projects.edit', $project) }}"
                           class="p-2 rounded-lg text-slate-400 hover:text-accent hover:bg-accent/10 transition-colors">
                            <i class="ri-edit-line"></i>
                        </a>
                    </li>
                @empty
                    <li class="px-5 py-10 text-center text-slate-400 text-sm">Belum ada project.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h3 class="font-poppins font-bold text-slate-800 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-3">
                @php
                    $actions = [
                        ['label' => 'Tambah Project', 'icon' => 'ri-add-circle-line', 'route' => 'admin.projects.create'],
                        ['label' => 'Tambah Tool', 'icon' => 'ri-add-circle-line', 'route' => 'admin.tools.create'],
                        ['label' => 'Tambah Sertifikat', 'icon' => 'ri-add-circle-line', 'route' => 'admin.certificates.create'],
                        ['label' => 'Tambah Pengalaman', 'icon' => 'ri-add-circle-line', 'route' => 'admin.experiences.create'],
                        ['label' => 'Tambah Materi', 'icon' => 'ri-add-circle-line', 'route' => 'admin.courses.create'],
                        ['label' => 'Edit Profil', 'icon' => 'ri-user-settings-line', 'route' => 'admin.profile.edit'],
                        ['label' => 'Lihat Website', 'icon' => 'ri-eye-line', 'route' => 'landing', 'external' => true],
                    ];
                @endphp
                @foreach ($actions as $action)
                    <a href="{{ route($action['route']) }}" {{ isset($action['external']) ? 'target="_blank"' : '' }}
                       class="flex items-center gap-2.5 px-4 py-3 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:border-accent/40 hover:text-accent hover:bg-accent/5 transition-all">
                        <i class="{{ $action['icon'] }} text-lg"></i>{{ $action['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="mt-6 rounded-xl bg-slate-50 border border-slate-200 p-4 text-sm text-slate-500 leading-relaxed">
                <p class="font-semibold text-slate-700 mb-1 flex items-center gap-1.5">
                    <i class="ri-information-line text-accent"></i>Tips
                </p>
                Perubahan di panel admin langsung tampil di landing page. Pastikan halaman di-refresh untuk melihat hasil terbaru.
            </div>
        </div>
    </div>
@endsection
