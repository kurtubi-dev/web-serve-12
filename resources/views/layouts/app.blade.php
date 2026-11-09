<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal SSO Terpadu') - Dinas PUPR Kabupaten Subang</title>
    <meta name="description" content="Single Sign-On (SSO) Web Service Dinas PUPR Kabupaten Subang - Rewire Starter Kit">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-pupr.png') }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            500: '#0284c7',
                            600: '#0369a1',
                            700: '#075985',
                            800: '#0c4a6e',
                            900: '#082f49',
                            950: '#082537',
                        },
                        pupr: {
                            blue: '#0b3954',
                            deep: '#082537',
                            yellow: '#fbc02d',
                            gold: '#f59e0b',
                            light: '#f4f7fa',
                        }
                    },
                    boxShadow: {
                        'subtle': '0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05)',
                        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05)',
                        'glow': '0 0 20px -3px rgba(11, 57, 84, 0.15)',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        code, pre, .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .sidebar-transition {
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased selection:bg-amber-400 selection:text-slate-900">

    <!-- Top Accent Bar (PUPR Signature Accent) -->
    <div class="h-1 w-full bg-gradient-to-r from-pupr-deep via-pupr-blue to-pupr-yellow z-50"></div>

    @if(request()->routeIs('sso.login', 'sso.google', 'sso.google.simulate'))
        <!-- ============================================================ -->
        <!-- REWIRE AUTHENTICATION LAYOUT (Halaman Login & Google SSO)    -->
        <!-- ============================================================ -->
        <header class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
                <!-- Brand -->
                <a href="{{ route('sso.dashboard') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo Dinas PUPR" class="w-10 h-10 object-contain drop-shadow-sm group-hover:scale-105 transition-transform">
                    <div>
                        <div class="flex items-center space-x-1.5">
                            <span class="text-xs font-black tracking-tight text-slate-900">DINAS PUPR SUBANG</span>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-blue-100 text-pupr-deep">SSO</span>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Single Sign-On & Identity Provider</span>
                    </div>
                </a>

                <!-- Nav Right -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('sso.docs') }}" class="text-xs font-bold text-slate-600 hover:text-pupr-deep transition flex items-center space-x-1.5 px-3 py-1.5 rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-code text-slate-400"></i>
                        <span>Dokumentasi API</span>
                    </a>
                    @if(request()->routeIs('sso.login'))
                        <a href="{{ route('sso.google') }}" class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-bold transition shadow-xs">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.66v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.15z"/>
                                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                                <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                            </svg>
                            <span>Google SSO</span>
                        </a>
                    @else
                        <a href="{{ route('sso.login') }}" class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-bold transition shadow-xs">
                            <i class="fa-solid fa-arrow-left text-slate-400 text-xs"></i>
                            <span>Kembali ke Login</span>
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <!-- Main Auth Content -->
        <main class="flex-grow flex items-center justify-center">
            @yield('content')
        </main>

        <!-- Auth Footer -->
        <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
            <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-2">
                <div>&copy; {{ date('Y') }} <strong>Dinas PUPR Kabupaten Subang</strong> &bull; Pemkab Subang</div>
                <div class="text-[11px] text-slate-400 flex items-center space-x-2">
                    <span class="inline-flex items-center"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span> Sistem Aktif</span>
                    <span>&bull;</span>
                    <span>Powered by Rewire Starter Kit</span>
                </div>
            </div>
        </footer>

    @else
        <!-- ============================================================ -->
        <!-- REWIRE APP SHELL (Sidebar + Topbar + Content untuk Portal/Docs) -->
        <!-- ============================================================ -->
        <div class="flex-grow flex h-[calc(100vh-4px)] overflow-hidden">

            <!-- SIDEBAR: Rewire Clean Starter Kit Style -->
            <aside id="app-sidebar"
                   class="sidebar-transition w-64 bg-slate-900 text-slate-300 flex flex-col justify-between border-r border-slate-800 z-30 fixed inset-y-0 left-0 pt-1 lg:static lg:translate-x-0 -translate-x-full">
                
                <!-- Sidebar Top -->
                <div class="flex flex-col flex-grow overflow-y-auto">
                    <!-- Brand Section -->
                    <div class="h-16 px-5 flex items-center justify-between border-b border-slate-800/80 bg-slate-950/40">
                        <a href="{{ route('sso.dashboard') }}" class="flex items-center space-x-3 group">
                            <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                                <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo Dinas PUPR" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <div class="text-xs font-black text-white tracking-wider">SSO PUPR SUBANG</div>
                                <div class="text-[10px] text-amber-400 font-mono font-semibold flex items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1 animate-pulse"></span>
                                    <span>PORTAL TERPADU</span>
                                </div>
                            </div>
                        </a>
                        <button type="button" onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white p-1">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <!-- Navigation Links Group -->
                    <nav class="p-3.5 space-y-6 flex-grow text-xs">
                        <!-- Menu Group: UTAMA -->
                        <div>
                            <div class="px-3 pb-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">
                                Navigasi Utama
                            </div>
                            <div class="space-y-1">
                                <a href="{{ route('sso.dashboard') }}"
                                   class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-bold transition-colors {{ request()->routeIs('sso.dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                    <i class="fa-solid fa-grip w-4 text-center {{ request()->routeIs('sso.dashboard') ? 'text-amber-300' : 'text-slate-400' }}"></i>
                                    <span>Portal Aplikasi</span>
                                </a>

                                <a href="{{ route('sso.docs') }}"
                                   class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-bold transition-colors {{ request()->routeIs('sso.docs') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                    <i class="fa-solid fa-code w-4 text-center {{ request()->routeIs('sso.docs') ? 'text-amber-300' : 'text-slate-400' }}"></i>
                                    <span>Dokumentasi API</span>
                                </a>
                            </div>
                        </div>

                        <!-- Menu Group: INTEGRASI & LAYANAN SSO -->
                        <div>
                            <div class="px-3 pb-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">
                                Ekosistem SSO PUPR
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center justify-between px-3 py-2 rounded-xl text-slate-400 bg-slate-800/40 border border-slate-800 text-[11px]">
                                    <span class="flex items-center space-x-2">
                                        <i class="fa-solid fa-circle-check text-emerald-400 text-xs"></i>
                                        <span class="font-medium text-slate-300">Identity Provider</span>
                                    </span>
                                    <span class="font-mono text-[10px] bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 px-1.5 py-0.5 rounded">OAuth 2.0</span>
                                </div>

                                <div class="flex items-center justify-between px-3 py-2 rounded-xl text-slate-400 bg-slate-800/40 border border-slate-800 text-[11px]">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.66v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.15z"/>
                                            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                                            <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                                            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                                        </svg>
                                        <span class="font-medium text-slate-300">Google SSO</span>
                                    </span>
                                    <span class="font-mono text-[10px] bg-blue-500/10 text-blue-300 border border-blue-500/20 px-1.5 py-0.5 rounded">Ready</span>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Group: KLIEN AKTIF -->
                        <div>
                            <div class="px-3 pb-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">
                                Aplikasi Terhubung
                            </div>
                            <div class="space-y-1 text-[11px] font-medium text-slate-400">
                                <div class="px-3 py-1.5 flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                    <span>SIM-JALAN (Bina Marga)</span>
                                </div>
                                <div class="px-3 py-1.5 flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                                    <span>SI-IRIGASI (SDA)</span>
                                </div>
                                <div class="px-3 py-1.5 flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span>SIMBG (Cipta Karya)</span>
                                </div>
                                <div class="px-3 py-1.5 flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    <span>SI-TARU (Tata Ruang)</span>
                                </div>
                            </div>
                        </div>
                    </nav>

                    <!-- Sidebar Footer: User Profile Badge -->
                    <div class="p-3 border-t border-slate-800 bg-slate-950/60">
                        @auth
                            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/60 border border-slate-700/60">
                                <div class="flex items-center space-x-2.5 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-amber-400 to-amber-500 text-slate-950 font-black text-xs flex items-center justify-center flex-shrink-0">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</div>
                                        <div class="text-[10px] text-slate-400 truncate">{{ Auth::user()->role }} &bull; {{ Auth::user()->bidang ?? 'PUPR' }}</div>
                                    </div>
                                </div>
                                <form action="{{ route('sso.logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" title="Logout" class="p-1.5 rounded-lg text-slate-400 hover:text-red-400 hover:bg-slate-700/50 transition">
                                        <i class="fa-solid fa-power-off text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('sso.login') }}" class="w-full py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center justify-center space-x-1.5 transition">
                                <i class="fa-solid fa-lock text-xs"></i>
                                <span>Masuk SSO Pegawai</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </aside>

            <!-- Backdrop untuk Mobile Drawer -->
            <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-20 hidden lg:hidden"></div>

            <!-- MAIN WRAPPER (Topbar + Page Content) -->
            <div class="flex-grow flex flex-col min-w-0 h-full overflow-hidden">

                <!-- TOPBAR: Rewire Clean Navbar -->
                <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between flex-shrink-0 z-10 shadow-2xs">
                    <!-- Left: Hamburger & Breadcrumb -->
                    <div class="flex items-center space-x-3">
                        <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none">
                            <i class="fa-solid fa-bars text-base"></i>
                        </button>

                        <div class="flex items-center space-x-2 text-xs">
                            <span class="text-slate-400 font-medium">Dinas PUPR Subang</span>
                            <span class="text-slate-300">/</span>
                            <span class="font-bold text-slate-800">
                                @if(request()->routeIs('sso.dashboard'))
                                    Portal Aplikasi Sektoral
                                @elseif(request()->routeIs('sso.docs'))
                                    Dokumentasi API SSO
                                @else
                                    Portal Terpadu
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Right: Status Badge & Actions -->
                    <div class="flex items-center space-x-3">
                        <!-- Server Health Pill -->
                        <div class="hidden sm:inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>SSO Gateway: Aktif</span>
                        </div>

                        <!-- Google SSO Quick Button -->
                        <a href="{{ route('sso.google') }}"
                           class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold shadow-2xs hover:shadow-xs transition">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.66v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.15z"/>
                                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                                <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                            </svg>
                            <span class="hidden md:inline">Google SSO</span>
                        </a>

                        @auth
                            <form action="{{ route('sso.logout') }}" method="POST" class="inline m-0">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold transition flex items-center space-x-1">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    <span class="hidden sm:inline">Keluar</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('sso.login') }}" class="px-3.5 py-1.5 rounded-lg bg-pupr-deep text-white text-xs font-bold hover:bg-blue-900 transition shadow-xs">
                                Masuk SSO
                            </a>
                        @endauth
                    </div>
                </header>

                <!-- SCROLLABLE PAGE CONTENT -->
                <div class="flex-grow overflow-y-auto">
                    <!-- Session Flash Alerts -->
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                        @if(session('success'))
                            <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                    <span>{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Main Dynamic Page Body -->
                    <main class="pb-12">
                        @yield('content')
                    </main>

                    <!-- Back Office Footer -->
                    <footer class="bg-white border-t border-slate-200 py-5 text-slate-500 text-xs">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-3">
                            <div class="flex items-center space-x-2 text-slate-600">
                                <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo Dinas PUPR" class="w-5 h-5 object-contain">
                                <span class="font-bold">Dinas Pekerjaan Umum dan Penataan Ruang Kab. Subang</span>
                            </div>
                            <div class="text-slate-400 text-[11px] flex items-center space-x-3">
                                <span>&copy; {{ date('Y') }} Sistem SSO Terintegrasi</span>
                                <span>&bull;</span>
                                <span>Template: Rewire Starter Kit</span>
                            </div>
                        </div>
                    </footer>
                </div>

            </div>
        </div>
    @endif

    <!-- Rewire App Shell Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('app-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
