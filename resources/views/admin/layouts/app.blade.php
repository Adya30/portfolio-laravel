@php
    $adminNav = [
        ['route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'ri-dashboard-line'],
        ['route' => 'admin.projects.index', 'active' => 'admin.projects', 'label' => 'Kelola Project', 'icon' => 'ri-folder-open-line'],
        ['route' => 'admin.tools.index', 'active' => 'admin.tools', 'label' => 'Tools', 'icon' => 'ri-tools-line'],
        ['route' => 'admin.certificates.index', 'active' => 'admin.certificates', 'label' => 'Sertifikat', 'icon' => 'ri-award-line'],
        ['route' => 'admin.experiences.index', 'active' => 'admin.experiences', 'label' => 'Pengalaman', 'icon' => 'ri-briefcase-line'],
        ['route' => 'admin.profile.edit', 'active' => 'admin.profile', 'label' => 'Profil', 'icon' => 'ri-user-line'],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>@yield('title', 'Admin Panel') - Adya Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: false }" class="admin-body bg-slate-100 text-slate-800 min-h-screen">

    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-30 lg:hidden"></div>

    <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0b1329] text-slate-300 flex flex-col transition-transform duration-300 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1 px-6 py-5 border-b border-white/5">
            <span class="font-poppins font-bold text-lg text-amber-500">Adya</span>
            <span class="font-poppins font-bold text-lg text-white">'s Portfolio</span>
            <span class="text-cyan-400">.</span>
        </a>

        <div class="px-5 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Menu</div>

        <nav class="flex-1 px-3 py-2 space-y-1 overflow-y-auto">
            @foreach ($adminNav as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs($item['active'] . '*') ? 'bg-accent/15 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="{{ $item['icon'] }} text-base"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="p-3 border-t border-white/5 space-y-1">
            <a href="{{ route('landing') }}" target="_blank"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white hover:bg-white/5 transition-all duration-200">
                <i class="ri-global-line text-base"></i><span>Lihat Website</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-400/80 hover:text-red-300 hover:bg-red-500/10 transition-all duration-200">
                    <i class="ri-logout-box-line text-base"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="lg:pl-64 flex flex-col min-h-screen">

        <header class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200 px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true"
                        class="lg:hidden w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors"
                        aria-label="Buka menu">
                    <i class="ri-menu-line"></i>
                </button>
                <h1 class="text-lg sm:text-xl font-bold text-slate-800 font-poppins">@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden sm:block text-sm text-slate-500">{{ auth()->user()->name }}</span>
                <div class="w-9 h-9 rounded-full bg-accent/15 text-accent flex items-center justify-center">
                    <i class="ri-user-line"></i>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6">
            @if (session('success'))
                <div class="mb-5 flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl">
                    <i class="ri-checkbox-circle-line text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
