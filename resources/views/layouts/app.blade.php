<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Senegal EdTech')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00288e',
                        'primary-light': '#0058be',
                        'primary-bg': '#eff4ff',
                        'text-dark': '#121c2a',
                        'text-muted': '#444653',
                        border: '#c4c5d5',
                        'bg-page': '#f8f9ff',
                    },
                    fontFamily: { inter: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background-color: #eff4ff; color: #00288e; }
        .sidebar-link.active { background-color: #eff4ff; color: #00288e; border-left: 4px solid #00288e; }
        .sidebar-link.active svg { color: #00288e; }
    </style>
    @stack('styles')
</head>
<body class="bg-bg-page min-h-screen" style="font-family: 'Inter', sans-serif;">

<div class="flex h-screen overflow-hidden">

    {{-- ═══════════════════════════════════ --}}
    {{-- SIDEBAR --}}
    {{-- ═══════════════════════════════════ --}}
    <aside class="w-72 bg-white border-r border-border flex flex-col fixed h-full z-20">

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-border">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-text-dark font-bold text-sm leading-tight">Senegal EdTech</p>
                    <p class="text-text-muted text-xs">Primary Education Portal</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            {{-- Élèves --}}
            <a href="{{ route('eleves.index') }}"
                class="sidebar-link {{ request()->routeIs('eleves.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Élèves
            </a>

            {{-- Matières --}}
            <a href="{{ route('matieres.index') }}"
                class="sidebar-link {{ request()->routeIs('matieres.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Matières
            </a>

            {{-- Notes --}}
            <a href="{{ route('compositions.index') }}"
                class="sidebar-link {{ request()->routeIs('notes.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Notes
            </a>

            {{-- Compositions --}}
            <a href="{{ route('compositions.index') }}"
                class="sidebar-link {{ request()->routeIs('compositions.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Compositions
            </a>

            {{-- Bulletins --}}
            <a href="{{ route('bulletins.index') }}"
                class="sidebar-link {{ request()->routeIs('bulletins.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Bulletins
            </a>

            {{-- Profil --}}
            <a href="{{ route('profile.edit') }}"
                class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil
            </a>

        </nav>

        {{-- Bas de sidebar --}}
        <div class="px-4 py-4 border-t border-border space-y-2">

            {{-- Nouveau bulletin --}}
            <a href="{{ route('compositions.index') }}"
                class="flex items-center justify-center gap-2 w-full bg-primary hover:bg-primary-light text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Report Card
            </a>

            {{-- Settings --}}
            <a href="#"
                class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Paramètres
            </a>

            {{-- Déconnexion --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="sidebar-link w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-500 hover:bg-red-50 text-sm font-medium transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Déconnexion
                </button>
            </form>

        </div>
    </aside>

    {{-- ═══════════════════════════════════ --}}
    {{-- CONTENU PRINCIPAL --}}
    {{-- ═══════════════════════════════════ --}}
    <div class="flex-1 flex flex-col ml-72 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-border px-8 py-4 flex items-center justify-between sticky top-0 z-10">

            {{-- Titre de la page --}}
            <div>
                <p class="text-xs text-text-muted uppercase tracking-widest font-medium">@yield('page_label', 'NAVIGATION')</p>
                <h1 class="text-xl font-bold text-text-dark">@yield('page_title', 'Page')</h1>
            </div>

            {{-- Droite header --}}
            <div class="flex items-center gap-4">

                {{-- Recherche --}}
                <div class="relative">
                    <svg class="w-4 h-4 text-text-muted absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Rechercher..."
                        class="pl-9 pr-4 py-2 border border-border rounded-xl text-sm bg-bg-page text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary w-56"/>
                </div>

                {{-- Notif --}}
                <button class="relative w-9 h-9 flex items-center justify-center rounded-xl border border-border bg-bg-page hover:bg-primary-bg transition-colors">
                    <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                {{-- Aide --}}
                <button class="w-9 h-9 flex items-center justify-center rounded-xl border border-border bg-bg-page hover:bg-primary-bg transition-colors">
                    <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>

                {{-- Avatar --}}
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center text-white text-sm font-bold ring-2 ring-blue-200">
                        {{ strtoupper(substr(auth()->user()->prenom ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom ?? '', 0, 1)) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-sm font-semibold text-text-dark leading-tight">
                            {{ auth()->user()->prenom ?? '' }} {{ auth()->user()->nom ?? '' }}
                        </p>
                        <p class="text-xs text-text-muted">{{ auth()->user()->nom_ecole ?? 'Enseignant' }}</p>
                    </div>
                </div>

            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-8 overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>

@stack('scripts')
</body>
</html>