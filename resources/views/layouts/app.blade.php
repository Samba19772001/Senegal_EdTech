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
        #sidebar { transition: transform 0.3s ease; }
        #overlay { transition: opacity 0.3s ease; }
    </style>
    @stack('styles')
</head>
<body class="bg-bg-page min-h-screen" style="font-family: 'Inter', sans-serif;">

<div class="flex h-screen overflow-hidden">

    {{-- OVERLAY mobile --}}
    <div id="overlay"
        class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"
        onclick="closeSidebar()"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="w-72 bg-white border-r border-border flex flex-col fixed h-full z-40
               -translate-x-full lg:translate-x-0 transition-transform duration-300">

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-border flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-text-dark font-bold text-sm leading-tight">Senegal EdTech</p>
                    <p class="text-text-muted text-xs">Portail de l'enseignement primaire</p>
                </div>
            </div>
            {{-- Bouton fermer sidebar sur mobile --}}
            <button onclick="closeSidebar()" class="lg:hidden text-text-muted hover:text-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

            <a href="{{ route('dashboard') }}" onclick="closeSidebar()"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('eleves.index') }}" onclick="closeSidebar()"
                class="sidebar-link {{ request()->routeIs('eleves.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Élèves
            </a>

            <a href="{{ route('matieres.index') }}" onclick="closeSidebar()"
                class="sidebar-link {{ request()->routeIs('matieres.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Matières
            </a>

            <a href="{{ route('notes.index') }}" onclick="closeSidebar()"
                class="sidebar-link {{ request()->routeIs('notes.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Notes
            </a>

            <a href="{{ route('compositions.index') }}" onclick="closeSidebar()"
                class="sidebar-link {{ request()->routeIs('compositions.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Compositions
            </a>

            <a href="{{ route('bulletins.index') }}" onclick="closeSidebar()"
                class="sidebar-link {{ request()->routeIs('bulletins.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Bulletins
            </a>

            <a href="{{ route('profile.edit') }}" onclick="closeSidebar()"
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

            <a href="{{ route('apropos.index') }}" onclick="closeSidebar()"
                class="sidebar-link {{ request()->routeIs('apropos.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                À propos
            </a>

            <a href="{{ route('parametres.index') }}" onclick="closeSidebar()"
                class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-text-muted text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Paramètres
            </a>

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

    {{-- CONTENU PRINCIPAL --}}
    <div class="flex-1 flex flex-col lg:ml-72 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-border px-4 lg:px-8 py-4 flex items-center justify-between sticky top-0 z-10">

            {{-- Gauche : hamburger + titre --}}
            <div class="flex items-center gap-3">
                {{-- Bouton hamburger (mobile) --}}
                <button onclick="openSidebar()"
                    class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl border border-border bg-bg-page hover:bg-primary-bg transition-colors">
                    <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-widest font-medium hidden sm:block">@yield('page_label', 'NAVIGATION')</p>
                    <h1 class="text-lg lg:text-xl font-bold text-text-dark">@yield('page_title', 'Page')</h1>
                </div>
            </div>

            {{-- Droite header --}}
            <div class="flex items-center gap-2 lg:gap-4">

                {{-- Recherche (cachée sur mobile) --}}
                <div class="relative hidden md:block" id="search-container">
                    <svg class="w-4 h-4 text-text-muted absolute left-3 top-1/2 -translate-y-1/2 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="search-input" placeholder="Rechercher un élève..."
                        autocomplete="off"
                        class="pl-9 pr-4 py-2 border border-border rounded-xl text-sm bg-bg-page text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary w-44 lg:w-56"/>
                    <div id="search-results"
                        class="absolute top-full left-0 mt-1 w-72 bg-white border border-border rounded-xl shadow-lg z-50 hidden overflow-hidden">
                        <div id="search-list"></div>
                    </div>
                </div>

                {{-- Notif --}}
                <div class="relative" id="notif-container">
                    <button onclick="toggleNotif()"
                        class="relative w-9 h-9 flex items-center justify-center rounded-xl border border-border bg-bg-page hover:bg-primary-bg transition-colors">
                        <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @php
                            $alertes = [];
                            $user    = auth()->user();
                            $niveau  = $user->niveau_enseignement;
                            $classeActive = $user->classes()
                                ->where('annee_scolaire', $user->annee_scolaire)
                                ->latest()->first();
                            if ($classeActive) {
                                $compositions = \App\Models\Composition::where('user_id', $user->id)
                                    ->where('classe_id', $classeActive->id)
                                    ->with(['notes', 'classe.eleves'])
                                    ->get();
                                $nbMatieres = \App\Models\Matiere::where(function($q) use ($niveau) {
                                    $q->where('is_default', true)->where('classe_niveau', $niveau);
                                })->orWhere(function($q) use ($niveau) {
                                    $q->where('user_id', auth()->id())
                                    ->where('is_default', false)
                                    ->where('classe_niveau', $niveau);
                                })->count();
                                foreach ($compositions as $comp) {
                                    $nbEleves       = $comp->classe->eleves->count();
                                    $notesCount     = $comp->notes->count();
                                    $notesAttendues = $nbMatieres * $nbEleves;
                                    if ($nbEleves > 0 && $notesCount < $notesAttendues) {
                                        $alertes[] = [
                                            'type'    => 'warning',
                                            'message' => "Composition T{$comp->trimestre} : notes incomplètes ({$notesCount}/{$notesAttendues})",
                                            'lien'    => route('compositions.index'),
                                        ];
                                    }
                                    $bulletinsCount = \App\Models\Bulletin::where('composition_id', $comp->id)->count();
                                    if ($nbEleves > 0 && $notesCount >= $notesAttendues && $bulletinsCount == 0) {
                                        $alertes[] = [
                                            'type'    => 'info',
                                            'message' => "Composition T{$comp->trimestre} complète — bulletins non encore générés.",
                                            'lien'    => route('bulletins.generer', $comp->id),
                                        ];
                                    }
                                }
                                if (\App\Models\Eleve::where('user_id', $user->id)->count() == 0) {
                                    $alertes[] = [
                                        'type'    => 'info',
                                        'message' => 'Aucun élève enregistré. Ajoutez vos élèves pour commencer.',
                                        'lien'    => route('eleves.index'),
                                    ];
                                }
                            }
                        @endphp
                        @if(count($alertes) > 0)
                            <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 rounded-full text-white text-xs flex items-center justify-center font-bold">
                                {{ count($alertes) }}
                            </span>
                        @endif
                    </button>
                    <div id="notif-dropdown"
                        class="hidden absolute right-0 top-full mt-2 w-72 lg:w-80 bg-white border border-border rounded-2xl shadow-xl z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-border flex items-center justify-between">
                            <h3 class="font-bold text-text-dark text-sm">Alertes</h3>
                            @if(count($alertes) > 0)
                                <span class="text-xs font-semibold bg-red-50 text-red-600 px-2 py-0.5 rounded-full">
                                    {{ count($alertes) }} alerte(s)
                                </span>
                            @endif
                        </div>
                        <div class="max-h-72 overflow-y-auto">
                            @forelse($alertes as $alerte)
                            <a href="{{ $alerte['lien'] }}"
                                class="flex items-start gap-3 px-4 py-3 hover:bg-bg-page transition-colors border-b border-border last:border-0">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5
                                    {{ $alerte['type'] == 'warning' ? 'bg-amber-50' : 'bg-blue-50' }}">
                                    @if($alerte['type'] == 'warning')
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-xs text-text-muted leading-relaxed">{{ $alerte['message'] }}</p>
                            </a>
                            @empty
                            <div class="px-4 py-8 text-center">
                                <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm font-medium text-text-dark">Tout est à jour !</p>
                                <p class="text-xs text-text-muted mt-1">Aucune alerte pour le moment</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Aide --}}
                <div class="relative hidden sm:block" id="aide-container">
                    <button onclick="toggleAide()"
                        class="w-9 h-9 flex items-center justify-center rounded-xl border border-border bg-bg-page hover:bg-primary-bg transition-colors">
                        <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </button>
                    <div id="aide-dropdown"
                        class="hidden absolute right-0 top-full mt-2 w-72 lg:w-80 bg-white border border-border rounded-2xl shadow-xl z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-border">
                            <h3 class="font-bold text-text-dark text-sm">Guide rapide</h3>
                            <p class="text-xs text-text-muted mt-0.5">Comment utiliser la plateforme</p>
                        </div>
                        <div class="p-4 space-y-3">
                            @foreach([
                                ['1', 'Ajouter vos élèves', 'Allez dans Élèves → Ajouter ou Importer Excel', 'eleves.index', 'text-blue-600 bg-blue-50'],
                                ['2', 'Configurer les matières', 'Vérifiez les matières dans Matières (déjà configurées)', 'matieres.index', 'text-green-600 bg-green-50'],
                                ['3', 'Saisir les notes', 'Allez dans Compositions → Saisir notes par matière', 'compositions.index', 'text-amber-600 bg-amber-50'],
                                ['4', 'Générer les bulletins', 'Une fois les notes saisies → Bulletins PDF', 'bulletins.index', 'text-purple-600 bg-purple-50'],
                            ] as $step)
                            <a href="{{ route($step[3]) }}"
                                class="flex items-start gap-3 p-3 rounded-xl hover:bg-bg-page transition-colors border border-border">
                                <div class="w-7 h-7 rounded-full {{ $step[4] }} flex items-center justify-center flex-shrink-0 text-xs font-bold">
                                    {{ $step[0] }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-text-dark">{{ $step[1] }}</p>
                                    <p class="text-xs text-text-muted mt-0.5">{{ $step[2] }}</p>
                                </div>
                            </a>
                            @endforeach
                            <div class="pt-2 border-t border-border">
                                <a href="{{ route('apropos.index') }}"
                                    class="flex items-center justify-center gap-2 w-full py-2 bg-primary-bg text-primary rounded-xl text-sm font-medium hover:bg-primary hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Avatar --}}
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center text-white text-sm font-bold ring-2 ring-blue-200 flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->prenom ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom ?? '', 0, 1)) }}
                    </div>
                    <div class="hidden lg:block">
                        <p class="text-sm font-semibold text-text-dark leading-tight">
                            {{ auth()->user()->prenom ?? '' }} {{ auth()->user()->nom ?? '' }}
                        </p>
                        <p class="text-xs text-text-muted">{{ auth()->user()->nom_ecole ?? 'Enseignant' }}</p>
                    </div>
                </div>

            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-4 lg:p-8 overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>

@stack('scripts')

<script>
// Sidebar mobile
function openSidebar() {
    document.getElementById('sidebar').classList.remove('-translate-x-full');
    document.getElementById('overlay').classList.remove('hidden');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.add('-translate-x-full');
    document.getElementById('overlay').classList.add('hidden');
}

// Recherche
const searchInput   = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');
const searchList    = document.getElementById('search-list');

if (searchInput) {
    let debounceTimer;
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const query = this.value.trim();
        if (query.length < 2) { searchResults.classList.add('hidden'); return; }
        debounceTimer = setTimeout(() => {
            fetch(`/search-eleves?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    searchList.innerHTML = '';
                    if (data.length === 0) {
                        searchList.innerHTML = `<div class="px-4 py-3 text-sm text-gray-400 text-center">Aucun élève trouvé</div>`;
                    } else {
                        data.forEach(eleve => {
                            const initiales = (eleve.prenom[0] + eleve.nom[0]).toUpperCase();
                            const div = document.createElement('div');
                            div.className = 'flex items-center gap-3 px-4 py-2.5 hover:bg-primary-bg cursor-pointer transition-colors border-b border-gray-50 last:border-0';
                            div.innerHTML = `
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center flex-shrink-0">${initiales}</div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">${eleve.prenom} ${eleve.nom}</p>
                                    <p class="text-xs text-gray-400">${eleve.classe ?? '—'}</p>
                                </div>`;
                            div.addEventListener('click', () => {
                                window.location.href = `/eleves/${eleve.id}/profil`;
                            });
                            searchList.appendChild(div);
                        });
                    }
                    searchResults.classList.remove('hidden');
                });
        }, 300);
    });
    document.addEventListener('click', function (e) {
        const sc = document.getElementById('search-container');
        if (sc && !sc.contains(e.target)) searchResults.classList.add('hidden');
    });
}

// Notif & Aide
function toggleNotif() {
    document.getElementById('notif-dropdown').classList.toggle('hidden');
    const aide = document.getElementById('aide-dropdown');
    if (aide) aide.classList.add('hidden');
}
function toggleAide() {
    document.getElementById('aide-dropdown').classList.toggle('hidden');
    document.getElementById('notif-dropdown').classList.add('hidden');
}
document.addEventListener('click', function(e) {
    const nc = document.getElementById('notif-container');
    const ac = document.getElementById('aide-container');
    if (nc && !nc.contains(e.target)) document.getElementById('notif-dropdown').classList.add('hidden');
    if (ac && !ac.contains(e.target)) document.getElementById('aide-dropdown').classList.add('hidden');
});
</script>

</body>
</html>