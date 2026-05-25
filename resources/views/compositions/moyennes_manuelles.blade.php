@extends('layouts.app')

@section('title', 'Moyennes manquantes — Senegal EdTech')
@section('page_label', 'BILAN ANNUEL')
@section('page_title', 'Moyennes des trimestres précédents')

@section('content')

    {{-- Info --}}
    <div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 mb-6 flex items-start gap-3">
        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-amber-800">Trimestres manquants détectés</p>
            <p class="text-xs text-amber-700 mt-1">
                Pour calculer la moyenne annuelle de chaque élève, veuillez saisir leurs moyennes
                pour les trimestres
                @foreach($trimestresManquants as $i => $t)
                    <b>T{{ $t }}</b>{{ $i < count($trimestresManquants) - 1 ? ' et ' : '' }}
                @endforeach
                (sur 10). Ces données ne seront utilisées que pour le bilan annuel.
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('moyennes.manuelles.store', $composition->id) }}">
        @csrf

        @foreach($trimestresManquants as $trimestre)
        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden mb-5">

            {{-- Header trimestre --}}
            <div class="bg-primary px-6 py-4">
                <h3 class="text-white font-semibold text-base">Trimestre {{ $trimestre }}</h3>
                <p class="text-blue-200 text-xs mt-0.5">
                    Saisissez la moyenne de chaque élève pour ce trimestre (sur 10)
                </p>
            </div>

            <table class="w-full">
                <thead>
                    <tr class="bg-primary-bg">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">#</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden sm:table-cell">Matricule</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Moyenne T{{ $trimestre }} / 10</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($eleves as $i => $eleve)
                    @php
                        $moyenneExistante = $moyennesExistantes->get($trimestre)?->firstWhere('eleve_id', $eleve->id)?->moyenne;
                        $initiales = strtoupper(substr($eleve->prenom, 0, 1) . substr($eleve->nom, 0, 1));
                        $couleurs = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                        $couleur = $couleurs[$eleve->id % count($couleurs)];
                    @endphp
                    <tr class="hover:bg-bg-page transition-colors">
                        <td class="px-6 py-4 text-sm text-text-muted">{{ $i + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                    {{ $initiales }}
                                </div>
                                <span class="text-sm font-medium text-text-dark">{{ $eleve->prenom }} {{ $eleve->nom }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-text-muted font-mono hidden sm:table-cell">{{ $eleve->matricule ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <input type="number"
                                name="moyennes[{{ $trimestre }}][{{ $eleve->id }}]"
                                value="{{ $moyenneExistante ?? '' }}"
                                min="0" max="10" step="0.01"
                                placeholder="0.00 — 10.00"
                                class="w-32 mx-auto block border border-border rounded-xl px-3 py-2 text-sm text-center text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

        {{-- Boutons --}}
        <div class="flex flex-col sm:flex-row items-center gap-3 justify-end">
            <a href="{{ route('compositions.index') }}"
                class="w-full sm:w-auto px-6 py-2.5 border border-border text-text-muted rounded-xl text-sm font-medium hover:bg-bg-page transition-colors text-center">
                Annuler
            </a>
            <button type="submit"
                class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer et générer les bulletins
            </button>
        </div>

    </form>

@endsection