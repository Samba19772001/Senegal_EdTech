@extends('layouts.app')

@section('title', 'Paramètres — Senegal EdTech')
@section('page_label', 'CONFIGURATION')
@section('page_title', 'Paramètres')

@section('content')

    {{-- Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-2 gap-6">

        {{-- Année scolaire & Classe --}}
        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="bg-primary px-6 py-4">
                <h3 class="text-white font-semibold text-base">Nouvelle année scolaire</h3>
                <p class="text-blue-200 text-xs mt-0.5">
                    Changez l'année scolaire et la classe pour une nouvelle année
                </p>
            </div>
            <form method="POST" action="{{ route('parametres.update') }}" class="px-6 py-6 space-y-4">
                @csrf @method('PUT')

                <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs text-amber-700">
                        <b>Attention !</b> Changer l'année scolaire créera une nouvelle classe et 3 nouvelles compositions.
                        Les données de l'année précédente seront conservées en archives.
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Année scolaire actuelle
                    </label>
                    <div class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-muted bg-gray-50">
                        {{ auth()->user()->annee_scolaire }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Nouvelle année scolaire
                    </label>
                    <input type="text" name="annee_scolaire"
                        placeholder="Ex: 2025-2026"
                        pattern="\d{4}-\d{4}"
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                    <p class="text-xs text-text-muted mt-1">Format : AAAA-AAAA (ex: 2025-2026)</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Classe actuelle
                    </label>
                    <div class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-muted bg-gray-50">
                        {{ auth()->user()->niveau_enseignement }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Nouvelle classe
                    </label>
                    <select name="niveau_enseignement"
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                        <option value="">Sélectionner...</option>
                        @foreach(['CI','CP','CE1','CE2','CM1','CM2'] as $niveau)
                            <option value="{{ $niveau }}" {{ auth()->user()->niveau_enseignement == $niveau ? 'selected' : '' }}>
                                {{ $niveau }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    onclick="return confirm('Êtes-vous sûr ? Une nouvelle classe et de nouvelles compositions seront créées.')"
                    class="w-full bg-primary hover:bg-primary-light text-white py-3 rounded-xl text-sm font-medium transition-colors">
                    Démarrer la nouvelle année
                </button>
            </form>
        </div>

        {{-- Infos année actuelle --}}
        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-border shadow-sm p-6">
                <h3 class="font-bold text-base text-text-dark mb-4">Année scolaire en cours</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-border">
                        <span class="text-sm text-text-muted">Année scolaire</span>
                        <span class="text-sm font-bold text-primary">{{ auth()->user()->annee_scolaire }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-border">
                        <span class="text-sm text-text-muted">Classe</span>
                        <span class="text-sm font-bold text-primary">{{ auth()->user()->niveau_enseignement }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-border">
                        <span class="text-sm text-text-muted">Nombre d'élèves</span>
                        <span class="text-sm font-bold text-primary">{{ auth()->user()->eleves()->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-border">
                        <span class="text-sm text-text-muted">Notes saisies</span>
                        <span class="text-sm font-bold text-primary">{{ auth()->user()->notes()->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-text-muted">Bulletins générés</span>
                        <span class="text-sm font-bold text-primary">{{ auth()->user()->bulletins()->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Historique des années --}}
            <div class="bg-white rounded-2xl border border-border shadow-sm p-6">
                <h3 class="font-bold text-base text-text-dark mb-4">Historique des classes</h3>
                @php
                    $classes = auth()->user()->classes()->orderByDesc('created_at')->get();
                @endphp
                @forelse($classes as $classe)
                <div class="flex items-center justify-between py-2 border-b border-border last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary-bg rounded-lg flex items-center justify-center">
                            <span class="text-xs font-bold text-primary">{{ $classe->nom }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-text-dark">{{ $classe->nom }}</p>
                            <p class="text-xs text-text-muted">{{ $classe->annee_scolaire }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-text-muted">{{ $classe->eleves->count() }} élèves</p>
                        @if($classe->annee_scolaire == auth()->user()->annee_scolaire)
                            <span class="text-xs font-semibold bg-green-50 text-green-700 px-2 py-0.5 rounded-full">En cours</span>
                        @else
                            <span class="text-xs font-semibold bg-gray-50 text-gray-500 px-2 py-0.5 rounded-full">Archivée</span>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-sm text-text-muted text-center py-4">Aucune classe trouvée</p>
                @endforelse
            </div>

        </div>
    </div>

@endsection