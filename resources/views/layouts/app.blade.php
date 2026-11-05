<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Layanan Terpadu') &mdash; Politeknik SSO</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                        serif: ['"Newsreader"', 'Georgia', 'serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                    colors: {
                        campus: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    }
                }
            }
        }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Newsreader:ital,opsz,wght@0,6..72,500;1,6..72,400;1,6..72,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
            -webkit-font-smoothing: antialiased;
        }
        .tabular-nums {
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 min-h-screen flex flex-col font-sans selection:bg-slate-900 selection:text-white">

    <!-- Main Navigation Bar -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/90 sticky top-0 z-40 transition-shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Brand & Official Campus Emblem -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-9 h-9 rounded-md bg-[#0f172a] text-white flex items-center justify-center font-bold text-sm shadow-xs border border-slate-800 group-hover:bg-slate-800 transition-colors">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 tracking-tight text-sm uppercase flex items-center gap-2">
                            POLITEKNIK NEGERI SUBANG
                        </div>
                    </div>
                </a>

                @auth
                <!-- User Profile & Single Sign-Out -->
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2.5 pl-3 border-l border-slate-200">
                        <img src="{{ Auth::user()->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0f172a&color=fff&bold=true' }}"
                            alt="{{ Auth::user()->name }}"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0f172a&color=fff&bold=true';"
                            class="w-8 h-8 rounded-full border border-slate-300 object-cover bg-slate-100 flex-shrink-0">
                        <div class="hidden sm:block text-left">
                            <div class="text-xs font-bold text-slate-900 leading-tight truncate max-w-[150px]">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-[10px] text-slate-500 font-mono truncate max-w-[150px]">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                    </div>

                    <!-- Single Sign-Out Action -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Single Sign-Out: Anda akan keluar dari seluruh layanan kampus yang terhubung.')"
                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold rounded-md text-slate-700 hover:text-rose-700 bg-slate-100 hover:bg-rose-50 border border-slate-200 hover:border-rose-200 transition-colors"
                            title="Single Sign-Out dari seluruh layanan">
                            <i class="fa-solid fa-arrow-right-from-bracket sm:mr-1.5 text-xs"></i>
                            <span class="hidden sm:inline">Logout SSO</span>
                        </button>
                    </form>
                </div>
                @else
                <div>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-bold rounded-md text-white bg-[#0f172a] hover:bg-slate-800 transition-colors shadow-xs">
                        <i class="fa-solid fa-lock mr-2 text-xs"></i> SSO Gateway
                    </a>
                </div>
                @endauth

            </div>
        </div>
    </header>

    <!-- Mobile Subnav Bar -->
    @auth
    <div class="md:hidden bg-white border-b border-slate-200 px-4 py-2 overflow-x-auto flex space-x-1.5 text-xs">
        <a href="{{ route('portal') }}" class="px-2.5 py-1 rounded text-xs whitespace-nowrap {{ request()->routeIs('portal') ? 'bg-slate-900 text-white font-bold' : 'text-slate-600 bg-slate-100' }}">Portal</a>
        <a href="{{ route('services.akademik') }}" class="px-2.5 py-1 rounded text-xs whitespace-nowrap {{ request()->routeIs('services.akademik') ? 'bg-indigo-900 text-white font-bold' : 'text-slate-600 bg-slate-100' }}">Akademik</a>
        <a href="{{ route('services.elearning') }}" class="px-2.5 py-1 rounded text-xs whitespace-nowrap {{ request()->routeIs('services.elearning') ? 'bg-emerald-900 text-white font-bold' : 'text-slate-600 bg-slate-100' }}">E-Learning</a>
        <a href="{{ route('services.perpustakaan') }}" class="px-2.5 py-1 rounded text-xs whitespace-nowrap {{ request()->routeIs('services.perpustakaan') ? 'bg-amber-900 text-white font-bold' : 'text-slate-600 bg-slate-100' }}">Perpustakaan</a>
    </div>
    @endauth

    <!-- Alert / Toast Messages -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            @if(session('success'))
            <div class="mb-4 p-3 rounded-md bg-emerald-50 border border-emerald-200/90 text-emerald-900 text-xs flex items-center justify-between shadow-xs">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 p-3 rounded-md bg-rose-50 border border-rose-200/90 text-rose-900 text-xs flex items-center justify-between shadow-xs">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-950">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            @if(session('warning'))
            <div class="mb-4 p-3 rounded-md bg-amber-50 border border-amber-200/90 text-amber-900 text-xs flex items-center justify-between shadow-xs">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-circle-info text-amber-600 text-sm"></i>
                    <span class="font-medium">{{ session('warning') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-amber-700 hover:text-amber-950">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-4 p-3 rounded-md bg-slate-100 border border-slate-200/90 text-slate-800 text-xs flex items-center justify-between shadow-xs">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-info text-slate-600 text-sm"></i>
                    <span class="font-medium">{{ session('info') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-slate-600 hover:text-slate-900">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16 py-6 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center space-x-2">
                <span class="font-medium">Politeknik Negeri Subang &copy; {{ date('Y') }}</span>
            </div>
        </div>
    </footer>

</body>
</html>
