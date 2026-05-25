@extends('layouts.app')

@section('title', 'Bulletins — Senegal EdTech')
@section('page_label', 'GESTION')
@section('page_title', 'Bulletins')

@push('styles')
<style>
    .stats-grid { grid-template-columns: repeat(1, 1fr); }
    @media (min-width: 630px)  { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1024px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }
</style>
@endpush

@section('content')

    {{-- Barre d'actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <p class="text-text-muted text-sm">Générez et téléchargez les bulletins de vos élèves</p>
        @if($bulletinsComposition->count() > 0)
        <a href="{{ route('bulletins.downloadAll', $composition->id) }}"
            class="flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Télécharger ZIP
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Sélecteur trimestre --}}
    <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-1">
        @foreach([1, 2, 3] as $t)
        <a href="?trimestre={{ $t }}"
            class="px-4 py-2 rounded-xl text-sm font-medium transition-colors whitespace-nowrap flex-shrink-0
            {{ $trimestreActif == $t ? 'bg-primary text-white' : 'border border-border text-text-muted hover:bg-primary-bg hover:text-primary' }}">
            Trimestre {{ $t }}
        </a>
        @endforeach
    </div>

    @if($composition)

        {{-- Stats --}}
        <div class="stats-grid grid gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-3">
                <div class="w-9 h-9 bg-primary-bg rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-wide">Élèves</p>
                    <p class="text-xl font-bold text-text-dark">{{ $composition->classe->eleves->count() }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-3">
                <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-wide">Générés</p>
                    <p class="text-xl font-bold text-text-dark">{{ $bulletinsComposition->count() }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-3">
                <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-wide">Moy. classe</p>
                    <p class="text-xl font-bold text-text-dark">
                        {{ $bulletinsComposition->count() > 0 ? number_format($bulletinsComposition->avg('moyenne_generale'), 2) : '—' }}/10
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-wide">Meilleure</p>
                    <p class="text-xl font-bold text-text-dark">
                        {{ $bulletinsComposition->count() > 0 ? number_format($bulletinsComposition->max('moyenne_generale'), 2) : '—' }}/10
                    </p>
                </div>
            </div>
        </div>

        @if($bulletinsComposition->count() == 0)
        <div class="bg-primary-bg border border-blue-200 rounded-2xl px-4 py-4 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-primary">Les notes sont saisies. Générez les bulletins pour ce trimestre.</p>
            </div>
            <a href="{{ route('bulletins.generer', $composition->id) }}"
                class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors w-full sm:w-auto justify-center flex-shrink-0">
                Générer les bulletins
            </a>
        </div>
        @endif

        @if($bulletinsComposition->count() > 0)
        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-4 py-4 border-b border-border">
                <h3 class="text-text-dark font-semibold text-sm">Bulletins — Trimestre {{ $trimestreActif }}</h3>
                <a href="{{ route('bulletins.generer', $composition->id) }}"
                    class="flex items-center gap-1.5 px-3 py-1.5 border border-border text-text-muted rounded-xl text-xs hover:bg-primary-bg hover:text-primary transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Regénérer
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full" style="min-width: 300px;">
                    <thead>
                        <tr class="bg-primary-bg">
                            <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                            <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Moy.</th>
                            <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Rang</th>
                            <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">PDF</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach($bulletinsComposition->sortBy('rang') as $bulletin)
                        @php
                            $initiales    = strtoupper(substr($bulletin->eleve->prenom, 0, 1) . substr($bulletin->eleve->nom, 0, 1));
                            $couleurs     = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                            $couleur      = $couleurs[$bulletin->eleve->id % count($couleurs)];
                            $mentionColors = [
                                'Très Bien'   => 'bg-green-100 text-green-800 border border-green-200',
                                'Bien'        => 'bg-blue-100 text-blue-800 border border-blue-200',
                                'Assez Bien'  => 'bg-indigo-100 text-indigo-800 border border-indigo-200',
                                'Passable'    => 'bg-amber-100 text-amber-800 border border-amber-200',
                                'Insuffisant' => 'bg-red-100 text-red-800 border border-red-200',
                            ];
                            $mentionClass = $mentionColors[$bulletin->mention] ?? 'bg-gray-50 text-gray-700';
                        @endphp
                        <tr class="hover:bg-bg-page transition-colors">

                            {{-- Élève + Mention sous le nom --}}
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                        {{ $initiales }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-text-dark leading-tight">
                                            {{ $bulletin->eleve->prenom }} {{ $bulletin->eleve->nom }}
                                        </p>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $mentionClass }} mt-0.5 inline-block">
                                            {{ $bulletin->mention }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-3 py-3.5 text-center">
                                <span class="text-sm font-bold text-primary whitespace-nowrap">
                                    {{ number_format($bulletin->moyenne_generale, 2) }}/10
                                </span>
                            </td>

                            <td class="px-3 py-3.5 text-center">
                                <span class="w-7 h-7 rounded-full bg-primary-bg text-primary text-sm font-bold inline-flex items-center justify-center">
                                    {{ $bulletin->rang }}
                                </span>
                            </td>

                            <td class="px-3 py-3.5 text-center">
                                <a href="{{ route('bulletins.download', $bulletin->id) }}"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg border border-border hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition-colors text-text-muted mx-auto">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-4 border-t border-border bg-bg-page">
                <p class="text-sm text-text-muted">{{ $bulletinsComposition->count() }} bulletin(s) — Trimestre {{ $trimestreActif }}</p>
            </div>
        </div>
        @endif

    @else
        <div class="bg-white rounded-2xl border border-border p-8 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <p class="font-medium text-text-dark">Aucune composition pour ce trimestre</p>
            <p class="text-sm text-text-muted mt-1">Saisissez d'abord les notes dans la page Compositions</p>
        </div>
    @endif

@endsection