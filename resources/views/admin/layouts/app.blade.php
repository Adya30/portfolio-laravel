@php
    $adminNav = [
        ['route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'ri-dashboard-fill'],
        ['route' => 'admin.courses.index', 'active' => 'admin.courses', 'label' => 'Materi', 'icon' => 'ri-book-open-line'],
        ['route' => 'admin.certificates.index', 'active' => 'admin.certificates', 'label' => 'Certificate', 'icon' => 'ri-article-line'],
        ['route' => 'admin.projects.index', 'active' => 'admin.projects', 'label' => 'Kelola Project', 'icon' => 'ri-folder-open-line'],
        ['route' => 'admin.categories.index', 'active' => 'admin.categories', 'label' => 'Kategori', 'icon' => 'ri-price-tag-3-line'],
        ['route' => 'admin.tools.index', 'active' => 'admin.tools', 'label' => 'Tools', 'icon' => 'ri-tools-line'],
        ['route' => 'admin.experiences.index', 'active' => 'admin.experiences', 'label' => 'Pengalaman', 'icon' => 'ri-briefcase-line'],
        ['route' => 'admin.users.index', 'active' => 'admin.users', 'label' => 'Kelola User', 'icon' => 'ri-user-settings-line'],
        ['route' => 'admin.profile.edit', 'active' => 'admin.profile', 'label' => 'Profil', 'icon' => 'ri-user-line'],
    ];

    if (auth()->check() && auth()->user()->isMateriOnly()) {
        $adminNav = array_filter($adminNav, fn($item) => $item['active'] === 'admin.courses');
    }

    $isSidebarCollapsed = request()->cookie('admin_sidebar_collapsed') === 'true';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Adya Portfolio</title>

    <script>
        (function () {
            try {
                var t = localStorage.getItem('theme');
                document.documentElement.classList.toggle('dark', t === 'dark');

                var c = localStorage.getItem('admin_sidebar_collapsed');
                if (c === null) {
                    var match = document.cookie.match(new RegExp('(^| )admin_sidebar_collapsed=([^;]+)'));
                    if (match) c = match[2];
                }
                if (c === 'true') {
                    document.documentElement.classList.add('sidebar-collapsed');
                } else if (c === 'false') {
                    document.documentElement.classList.remove('sidebar-collapsed');
                }
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.25);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.45);
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        .no-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }

        .admin-shell {
            padding-top: 14px !important;
            padding-bottom: 14px !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        @media (max-width: 640px) {
            .admin-shell {
                padding-top: 10px !important;
                padding-bottom: 10px !important;
                padding-left: 8px !important;
                padding-right: 8px !important;
            }
        }

        @media (min-width: 1024px) {
            aside.admin-sidebar {
                width: 16rem !important;
                padding: 1.25rem !important;
                transition: none !important;
            }
            @media (min-width: 1280px) {
                aside.admin-sidebar {
                    width: 18rem !important;
                    padding: 1.5rem !important;
                }
            }
            aside.admin-sidebar .sidebar-link {
                gap: 0.875rem !important;
                padding: 0.75rem 1rem !important;
                justify-content: flex-start !important;
            }

            html.sidebar-collapsed aside.admin-sidebar {
                width: 74px !important;
                min-width: 74px !important;
                max-width: 74px !important;
                padding: 0.75rem !important;
                transition: none !important;
            }
            html.sidebar-collapsed aside.admin-sidebar * {
                transition: none !important;
            }
            html.sidebar-collapsed aside.admin-sidebar .sidebar-brand {
                display: none !important;
            }
            html.sidebar-collapsed aside.admin-sidebar .sidebar-text {
                display: none !important;
            }
            html.sidebar-collapsed aside.admin-sidebar .sidebar-link {
                justify-content: center !important;
                padding: 0.75rem !important;
                gap: 0 !important;
            }

            html.sidebar-collapsed .sidebar-toggle-fold {
                display: none !important;
            }
            html:not(.sidebar-collapsed) .sidebar-toggle-unfold {
                display: none !important;
            }

            html.sidebar-collapsed main .max-w-4xl,
            html.sidebar-collapsed main .max-w-3xl,
            html.sidebar-collapsed main .max-w-2xl,
            html.sidebar-collapsed main .max-w-5xl,
            html.sidebar-collapsed main .max-w-xl {
                max-width: 100% !important;
                width: 100% !important;
                transition: max-width 0.2s ease;
            }
            html.sidebar-collapsed main [role="dialog"] .max-w-2xl,
            html.sidebar-collapsed main [role="dialog"] .max-w-xl,
            html.sidebar-collapsed main [role="dialog"] .max-w-lg {
                max-width: 42rem !important;
            }
        }
    </style>
</head>
<body x-data="{
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('admin_sidebar_collapsed') !== null
            ? localStorage.getItem('admin_sidebar_collapsed') === 'true'
            : {{ $isSidebarCollapsed ? 'true' : 'false' }},
        toggleDesktopSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('admin_sidebar_collapsed', this.sidebarCollapsed ? 'true' : 'false');
            document.cookie = 'admin_sidebar_collapsed=' + (this.sidebarCollapsed ? 'true' : 'false') + '; path=/; max-age=31536000; SameSite=Lax';
            document.documentElement.classList.toggle('sidebar-collapsed', this.sidebarCollapsed);
        },
        dark: localStorage.getItem('theme') === 'dark',
        toggleTheme() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.dark);
        }
    }"
    class="admin-body admin-shell h-screen max-h-screen overflow-hidden bg-[#eceff3] dark:bg-[#070b14] text-slate-800 dark:text-slate-100 flex flex-col antialiased transition-colors duration-300 select-none">

    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-xs z-40 lg:hidden"></div>

    <div class="flex-1 h-full max-h-full min-h-0 flex flex-col lg:flex-row gap-2.5 sm:gap-3 lg:gap-3 overflow-hidden">

        <aside class="admin-sidebar fixed inset-y-3 left-2.5 z-50 max-w-[calc(100vw-1.5rem)]
                      bg-[#0f172a] text-slate-300 rounded-[24px] sm:rounded-[28px] shadow-2xl flex flex-col border border-white/5
                      lg:static lg:inset-auto lg:z-10 lg:shrink-0 lg:h-full lg:max-h-full lg:overflow-hidden
                      {{ $isSidebarCollapsed ? 'w-[74px] p-3' : 'w-72 lg:w-64 xl:w-72 p-5 sm:p-6' }}"
               :class="[
                   sidebarOpen ? 'translate-x-0' : '-translate-x-[110%] lg:translate-x-0',
                   sidebarCollapsed ? 'w-72 lg:w-[74px] p-5 lg:p-3' : 'w-72 lg:w-64 xl:w-72 p-5 sm:p-6'
               ]">

            <div class="sidebar-brand shrink-0 pb-3.5 mb-3.5 border-b border-white/10 {{ $isSidebarCollapsed ? 'lg:hidden' : '' }}"
                 :class="sidebarCollapsed ? 'lg:hidden' : ''">
                <div class="flex items-center justify-between w-full">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1 group">
                        <span class="font-poppins font-extrabold text-xl text-orange-500">Adya</span>
                        <span class="font-poppins font-bold text-xl text-white">’s Portoflio</span>
                    </a>
                    <button @click="sidebarOpen = false"
                            class="lg:hidden w-8 h-8 rounded-lg bg-white/10 text-slate-300 hover:text-white flex items-center justify-center cursor-pointer"
                            aria-label="Tutup menu">
                        <i class="ri-close-line text-lg"></i>
                    </button>
                </div>
            </div>

            <nav class="flex-1 min-h-0 overflow-y-auto no-scrollbar space-y-1.5">
                @foreach ($adminNav as $item)
                    @php
                        $isActive = request()->routeIs($item['active'] . '*');
                    @endphp
                    <a href="{{ route($item['route']) }}"
                       title="{{ $item['label'] }}"
                       class="sidebar-link flex items-center rounded-xl text-sm font-semibold transition-colors duration-200
                              {{ $isActive
                                  ? 'bg-orange-500 text-white shadow-md shadow-orange-500/20'
                                  : 'text-slate-300/90 hover:text-white hover:bg-white/5' }}
                              {{ $isSidebarCollapsed ? 'justify-center p-3' : 'gap-3.5 px-4 py-3' }}"
                       :class="sidebarCollapsed ? 'justify-center p-3' : 'gap-3.5 px-4 py-3'">
                        <i class="{{ $item['icon'] }} text-lg shrink-0"></i>
                        <span class="sidebar-text truncate {{ $isSidebarCollapsed ? 'hidden' : '' }}" x-show="!sidebarCollapsed">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="shrink-0 pt-3 mt-3 border-t border-white/10 flex flex-col gap-2">
                <a href="{{ route('landing') }}" target="_blank"
                   title="Lihat Website"
                   class="sidebar-link w-full text-slate-200 hover:text-white hover:bg-white/5 border border-white/10 font-semibold text-sm rounded-xl flex items-center justify-center transition-colors
                          {{ $isSidebarCollapsed ? 'p-3' : 'gap-2 py-2.5 px-3' }}"
                   :class="sidebarCollapsed ? 'p-3' : 'gap-2 py-2.5 px-3'">
                    <i class="ri-external-link-line text-base shrink-0"></i>
                    <span class="sidebar-text {{ $isSidebarCollapsed ? 'hidden' : '' }}" x-show="!sidebarCollapsed">Lihat Website</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full m-0" onsubmit="handleLogoutSubmit(this)">
                    @csrf
                    <button type="submit" id="btn-admin-logout"
                            title="Logout"
                            class="sidebar-link w-full bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-bold text-sm rounded-xl flex items-center justify-center shadow-sm shadow-red-600/30 transition-colors cursor-pointer
                                   {{ $isSidebarCollapsed ? 'p-3' : 'gap-2 py-2.5 px-3' }}"
                            :class="sidebarCollapsed ? 'p-3' : 'gap-2 py-2.5 px-3'">
                        <i class="ri-logout-box-r-line text-base shrink-0"></i>
                        <span class="sidebar-text {{ $isSidebarCollapsed ? 'hidden' : '' }}" x-show="!sidebarCollapsed">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 bg-white dark:bg-[#0f172a] rounded-[24px] sm:rounded-[28px] shadow-sm border border-slate-200/80 dark:border-white/10 flex flex-col min-w-0 h-full max-h-full overflow-hidden transition-colors duration-300">

            <header class="px-5 sm:px-7 lg:px-8 py-5 border-b border-slate-100 dark:border-white/10 flex items-center justify-between gap-3 shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <button @click="sidebarOpen = true"
                            class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors cursor-pointer"
                            aria-label="Buka menu">
                        <i class="ri-menu-2-line text-lg"></i>
                    </button>

                    <button @click="toggleDesktopSidebar()" type="button"
                            class="hidden lg:flex w-9 h-9 items-center justify-center rounded-xl border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors cursor-pointer active:scale-95"
                            :title="sidebarCollapsed ? 'Munculkan Panel Sidebar' : 'Sembunyikan Panel Sidebar'"
                            :aria-label="sidebarCollapsed ? 'Munculkan Panel Sidebar' : 'Sembunyikan Panel Sidebar'">
                        <i class="sidebar-toggle-fold text-lg ri-menu-fold-line" x-show="!sidebarCollapsed"></i>
                        <i class="sidebar-toggle-unfold text-lg ri-menu-unfold-line" x-show="sidebarCollapsed"></i>
                    </button>

                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white font-poppins tracking-tight truncate">
                        @yield('page_title', 'Dashboard')
                    </h1>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <button @click="toggleTheme" type="button"
                            class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors cursor-pointer active:scale-95"
                            :aria-label="dark ? 'Ganti ke tema terang' : 'Ganti ke tema gelap'"
                            :title="dark ? 'Ganti ke tema terang' : 'Ganti ke tema gelap'">
                        <i class="text-xl leading-none"
                           :class="dark ? 'ri-sun-line text-amber-400' : 'ri-moon-line text-slate-800 dark:text-white'"
                           aria-hidden="true"></i>
                    </button>
                </div>
            </header>

            <div class="p-5 sm:p-7 lg:p-8 flex-1 min-h-0 overflow-y-auto custom-scrollbar select-text">
                @if (session('success'))
                    <div class="mb-5 flex items-center gap-2.5 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-300 text-sm font-medium px-4 py-3 rounded-xl shadow-xs">
                        <i class="ri-checkbox-circle-line text-lg shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 flex items-center gap-2.5 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/40 text-red-700 dark:text-red-300 text-sm font-medium px-4 py-3 rounded-xl shadow-xs">
                        <i class="ri-error-warning-line text-lg shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>

        </main>

    </div>

<script>
function handleLogoutSubmit(form) {
    const btn = form.querySelector('#btn-admin-logout') || form.querySelector('button[type="submit"]');
    if (btn) {
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed', 'pointer-events-none');
    }
}
</script>
</body>
</html>
