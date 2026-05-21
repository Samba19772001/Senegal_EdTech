@extends('layouts.app')

@section('title', 'Dashboard — Senegal EdTech')
@section('page_label', 'TABLEAU DE BORD')
@section('page_title', 'Bienvenue')

@section('content')

    {{-- Stat Cards : 2 col mobile, 4 col desktop --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-5 mb-6 lg:mb-8">

        <div class="bg-white rounded-2xl border border-border p-4 lg:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3 lg:mb-4">
                <div class="w-9 h-9 lg:w-10 lg:h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-xs text-text-muted uppercase tracking-widest font-medium mb-1">Élèves</p>
            <p class="text-2xl lg:text-3xl font-bold text-text-dark">{{ $totalEleves }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-border p-4 lg:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3 lg:mb-4">
                <div class="w-9 h-9 lg:w-10 lg:h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Actif</span>
            </div>
            <p class="text-xs text-text-muted uppercase tracking-widest font-medium mb-1">Matières</p>
            <p class="text-2xl lg:text-3xl font-bold text-text-dark">{{ $totalMatieres }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-border p-4 lg:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3 lg:mb-4">
                <div class="w-9 h-9 lg:w-10 lg:h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-xs text-text-muted uppercase tracking-widest font-medium mb-1">Notes</p>
            <p class="text-2xl lg:text-3xl font-bold text-text-dark">{{ $totalNotes }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-border p-4 lg:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3 lg:mb-4">
                <div class="w-9 h-9 lg:w-10 lg:h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-xs text-text-muted uppercase tracking-widest font-medium mb-1">Bulletins</p>
            <p class="text-2xl lg:text-3xl font-bold text-text-dark">{{ $totalBulletins }}</p>
        </div>

    </div>

    {{-- Actions + Activités + Stats --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Gauche : Actions + Activités --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Actions Rapides : 1 col mobile, 2 col desktop --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                <a href="{{ route('eleves.index') }}"
                    class="flex items-center justify-between bg-primary hover:bg-primary-light text-white px-4 lg:px-5 py-4 rounded-xl transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-sm">Ajouter élèves</p>
                            <p class="text-xs text-blue-200">Inscrire manuellement</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('eleves.index') }}"
                    class="flex items-center justify-between bg-white hover:bg-primary-bg border border-border text-text-dark px-4 lg:px-5 py-4 rounded-xl transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-sm">Importer Excel</p>
                            <p class="text-xs text-text-muted">Chargement par lot</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-text-muted flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('compositions.index') }}"
                    class="flex items-center justify-between bg-white hover:bg-primary-bg border border-border text-text-dark px-4 lg:px-5 py-4 rounded-xl transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-sm">Saisir notes</p>
                            <p class="text-xs text-text-muted">Entrée rapide par classe</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-text-muted flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('bulletins.index') }}"
                    class="flex items-center justify-between bg-white hover:bg-primary-bg border border-border text-text-dark px-4 lg:px-5 py-4 rounded-xl transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-sm">Générer bulletins</p>
                            <p class="text-xs text-text-muted">Exportation PDF groupée</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-text-muted flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

            </div>

            {{-- Dernières Activités --}}
            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-4 lg:px-6 py-4 border-b border-border">
                    <h2 class="text-base font-bold text-text-dark">Dernières Activités</h2>
                    <a href="{{ route('notes.index') }}" class="text-sm text-primary font-medium hover:underline">Voir tout</a>
                </div>
                {{-- Tableau scrollable sur mobile --}}
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[400px]">
                        <thead>
                            <tr class="bg-primary-bg">
                                <th class="text-left px-4 lg:px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Matière</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden sm:table-cell">Trimestre</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Note</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($dernieresNotes as $note)
                            @php
                                $initiales   = strtoupper(substr($note->eleve->prenom, 0, 1) . substr($note->eleve->nom, 0, 1));
                                $couleurs    = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                                $couleur     = $couleurs[$note->eleve->id % count($couleurs)];
                                $noteRamenee = number_format($note->note * 10 / $note->matiere->note_sur, 2);
                            @endphp
                            <tr class="hover:bg-bg-page transition-colors">
                                <td class="px-4 lg:px-6 py-3.5">
                                    <div class="flex items-center gap-2 lg:gap-3">
                                        <div class="w-8 h-8 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                            {{ $initiales }}
                                        </div>
                                        <span class="text-sm font-medium text-text-dark">{{ $note->eleve->prenom }} {{ $note->eleve->nom }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-sm text-text-muted">{{ $note->matiere->nom }}</td>
                                <td class="px-4 py-3.5 hidden sm:table-cell">
                                    <span class="text-xs font-semibold bg-primary-bg text-primary px-2.5 py-1 rounded-full">
                                        T{{ $note->composition->trimestre }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-sm font-bold text-primary">{{ $noteRamenee }}/10</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-text-muted text-sm">
                                    Aucune note saisie pour l'instant
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Droite : Stats --}}
        <div class="space-y-5">

            {{-- Performance Globale --}}
            <div class="bg-primary rounded-2xl p-5 lg:p-6 text-white shadow-sm">
                <h3 class="font-bold text-base mb-1">Performance Globale</h3>
                <p class="text-blue-200 text-xs mb-4 lg:mb-5">Moyenne générale de la classe sur tous les trimestres</p>
                @php
                    $moyenneGlobale = auth()->user()->bulletins()->avg('moyenne_generale');
                    $meilleureNote  = auth()->user()->bulletins()->max('moyenne_generale');
                    $plusFaible     = auth()->user()->bulletins()->min('moyenne_generale');
                @endphp
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-blue-200 text-xs">Moyenne globale</span>
                        <span class="text-white font-bold text-lg">
                            {{ $moyenneGlobale ? number_format($moyenneGlobale, 2) : '—' }}/10
                        </span>
                    </div>
                    <div class="w-full bg-blue-800 rounded-full h-2">
                        <div class="bg-white h-2 rounded-full"
                            style="width: {{ $moyenneGlobale ? ($moyenneGlobale * 10) : 0 }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-blue-200">Meilleure : <b class="text-white">{{ $meilleureNote ? number_format($meilleureNote, 2) : '—' }}</b></span>
                        <span class="text-blue-200">Plus faible : <b class="text-white">{{ $plusFaible ? number_format($plusFaible, 2) : '—' }}</b></span>
                    </div>
                </div>
            </div>

            {{-- Résumé par trimestre --}}
            <div class="bg-white rounded-2xl border border-border p-5 lg:p-6 shadow-sm">
                <h3 class="font-bold text-base text-text-dark mb-4">Résumé par trimestre</h3>
                <div class="space-y-3">
                    @foreach([1, 2, 3] as $t)
                    @php
                        $comp = auth()->user()->compositions()->where('trimestre', $t)->first();
                        $moy  = $comp ? \App\Models\Bulletin::where('composition_id', $comp->id)->avg('moyenne_generale') : null;
                        $nb   = $comp ? \App\Models\Bulletin::where('composition_id', $comp->id)->count() : 0;
                    @endphp
                    <div class="flex items-center justify-between py-2 border-b border-border last:border-0">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full {{ $moy ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                            <span class="text-sm text-text-muted">Trimestre {{ $t }}</span>
                        </div>
                        <div class="flex items-center gap-2 lg:gap-3">
                            @if($moy)
                                <span class="text-xs text-text-muted hidden sm:inline">{{ $nb }} bulletins</span>
                                <span class="text-sm font-bold text-primary">{{ number_format($moy, 2) }}/10</span>
                            @else
                                <span class="text-xs text-gray-400">Non commencé</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Citation --}}
            <div class="bg-primary rounded-2xl p-5 lg:p-6 text-white shadow-sm">
                <p class="text-sm font-medium leading-relaxed">
                    "L'éducation est l'arme la plus puissante pour changer le monde."
                </p>
                <p class="text-blue-200 text-xs mt-3">— Nelson Mandela</p>
            </div>

        </div>
    </div>

@endsection