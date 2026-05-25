@extends('layouts.app')

@section('title', 'À propos — Senegal EdTech')
@section('page_label', 'INFORMATIONS')
@section('page_title', 'À propos')

@section('content')

    {{-- Hero --}}
    <div class="bg-primary rounded-2xl p-5 lg:p-8 mb-6 text-white">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 lg:gap-6">
            <div class="w-16 h-16 lg:w-20 lg:h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-8 h-8 lg:w-10 lg:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl lg:text-2xl font-bold">Senegal EdTech</h2>
                <p class="text-blue-200 text-sm mt-1">Portail de l'enseignement primaire</p>
                <p class="text-blue-100 text-sm mt-2">
                    Une solution digitale moderne dédiée aux enseignants du primaire au Sénégal,
                    pour simplifier la gestion pédagogique et valoriser le travail des éducateurs.
                </p>
            </div>
        </div>
    </div>

    {{-- Mission / Vision / Valeurs : 1 col mobile, 3 col desktop --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm">
            <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-text-dark text-base mb-2">Notre Mission</h3>
            <p class="text-text-muted text-sm leading-relaxed">
                Digitaliser la gestion pédagogique des classes du primaire pour permettre
                aux enseignants de se concentrer sur l'essentiel : enseigner.
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm">
            <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h3 class="font-bold text-text-dark text-base mb-2">Notre Vision</h3>
            <p class="text-text-muted text-sm leading-relaxed">
                Devenir la référence des outils numériques éducatifs au Sénégal,
                accessibles à chaque enseignant, dans chaque école, partout au pays.
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm">
            <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-text-dark text-base mb-2">Nos Valeurs</h3>
            <p class="text-text-muted text-sm leading-relaxed">
                Simplicité, fiabilité et accessibilité. Nous croyons que la technologie
                doit servir l'éducation, pas la compliquer.
            </p>
        </div>

    </div>

    {{-- Fonctionnalités --}}
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden mb-6">
        <div class="px-4 lg:px-6 py-4 border-b border-border">
            <h3 class="font-bold text-text-dark text-base">Fonctionnalités principales</h3>
        </div>
        @php
        $features = [
            ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'titre' => 'Gestion des élèves', 'desc' => 'Ajout manuel ou import Excel, suivi complet de chaque élève.'],
            ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'titre' => 'Gestion des matières', 'desc' => 'Matières prédéfinies par niveau + ajout de matières personnalisées.'],
            ['icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'titre' => 'Saisie des notes', 'desc' => 'Saisie rapide par matière, calcul automatique des moyennes sur 10.'],
            ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'titre' => 'Calcul automatique', 'desc' => 'Moyennes, rangs, mentions calculés automatiquement sans erreur.'],
            ['icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'titre' => 'Bulletins PDF', 'desc' => 'Génération instantanée de bulletins professionnels téléchargeables.'],
            ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'titre' => 'Données sécurisées', 'desc' => 'Chaque enseignant accède uniquement à ses propres données.'],
        ];
        @endphp
        {{-- 1 col mobile, 2 col desktop --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0">
            @foreach($features as $i => $f)
            <div class="flex items-start gap-4 p-4 lg:p-6 border-b border-border {{ $i % 2 == 0 ? 'sm:border-r' : '' }}">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-text-dark text-sm mb-1">{{ $f['titre'] }}</h4>
                    <p class="text-text-muted text-xs leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Contact & Infos : 1 col mobile, 2 col desktop --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">

        <div class="bg-white rounded-2xl border border-border shadow-sm p-4 lg:p-6">
            <h3 class="font-bold text-text-dark text-base mb-4">Contactez-nous</h3>
            <div class="space-y-3">
                @foreach([
                    ['Téléphone', '+221 78 292 10 01', 'bg-red-50 text-red-700'],
                    ['Email', 'senegaledtech@gmail.com', 'bg-blue-50 text-blue-700'],
                    ['Adresse', 'Saint-Louis/Sénégal', 'bg-cyan-50 text-cyan-700'],
                    ['Watshap', '+221 78 292 10 01', 'bg-green-50 text-green-700'],
                    
                ] as $tech)
                <div class="flex items-center justify-between py-2 border-b border-border last:border-0">
                    <div class="flex items-center gap-2 lg:gap-3 min-w-0">
                        <span class="text-xs font-bold px-2 py-1 rounded-full {{ $tech[2] }} flex-shrink-0">{{ $tech[0] }}</span>
                        <span class="text-sm text-text-muted truncate">{{ $tech[1] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-border shadow-sm p-4 lg:p-6">
            <h3 class="font-bold text-text-dark text-base mb-4">Informations</h3>
            <div class="space-y-3">
                @foreach([
                    ['Version', 'v1.0.0'],
                    ['Statut', 'En développement actif'],
                    ['Plateforme', 'Web'],
                    ['Langue', 'Français'],
                    ['Niveaux', 'CI, CP, CE1, CE2, CM1, CM2'],
                    ['Pays cible', 'Sénégal'],
                ] as $info)
                <div class="flex items-center justify-between py-2 border-b border-border last:border-0">
                    <span class="text-sm text-text-muted">{{ $info[0] }}</span>
                    <span class="text-sm font-semibold text-text-dark text-right ml-2">{{ $info[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

@endsection