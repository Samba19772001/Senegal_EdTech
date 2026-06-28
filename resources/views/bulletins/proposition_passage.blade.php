@extends('layouts.app')

@section('title', 'Proposition de Passage — Senegal EdTech')
@section('page_label', 'RÉSULTATS')
@section('page_title', 'Proposition de passage')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-text-muted mb-6 flex-wrap">
        <a href="{{ route('bulletins.index') }}" class="hover:text-primary">Bulletins</a>
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-text-dark font-medium">Proposition de passage</span>
    </div>

    {{-- Header --}}
    <div class="bg-primary rounded-2xl p-4 sm:p-6 mb-6 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold">Proposition de passage — {{ $composition->classe->nom }}</h2>
            <p class="text-blue-200 text-sm mt-1">
                {{ auth()->user()->annee_scolaire }} •
                {{ $resultats->count() }} élèves •
                {{ $resultats->where('decision', 'Passe en classe supérieure')->count() }} admis •
                {{ $resultats->where('decision', 'Redouble')->count() }} redoublants
            </p>
        </div>
        <a href="{{ route('bulletins.proposition.pdf', $composition->id) }}"
            class="flex items-center justify-center gap-2 px-5 py-2.5 bg-white text-primary rounded-xl text-sm font-semibold flex-shrink-0 w-full sm:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Télécharger PDF
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-text-dark">{{ $resultats->count() }}</p>
            <p class="text-xs text-text-muted mt-1">Total élèves</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $resultats->where('decision', 'Passe en classe supérieure')->count() }}</p>
            <p class="text-xs text-text-muted mt-1">Admis</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-red-600">{{ $resultats->where('decision', 'Redouble')->count() }}</p>
            <p class="text-xs text-text-muted mt-1">Redoublants</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            @php $moyClasse = $resultats->whereNotNull('moyAnnuelle')->avg('moyAnnuelle'); @endphp
            <p class="text-2xl font-bold text-primary">{{ $moyClasse ? number_format($moyClasse, 2) : '—' }}/10</p>
            <p class="text-xs text-text-muted mt-1">Moy. annuelle</p>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="-mx-4 lg:mx-0 lg:rounded-2xl lg:border lg:border-border overflow-hidden"
        style="background:white;border-top:1px solid #c4c5d5;border-bottom:1px solid #c4c5d5;">
        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
            <table class="w-full" style="min-width:650px;">
                <thead>
                    <tr class="bg-primary">
                        <th class="text-center px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest">Rang</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest">Prénom & Nom</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest">Sexe</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest">Moy. T1</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest">Moy. T2</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest">Moy. T3</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest">Moy. Annuelle</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest">Observation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($resultats as $r)
                    @php
                        $estAdmis = $r['decision'] == 'Passe en classe supérieure';
                        $initiales = strtoupper(substr($r['eleve']->prenom,0,1).substr($r['eleve']->nom,0,1));
                        $couleurs = ['blue','pink','orange','purple','green','red','indigo','amber'];
                        $couleur = $couleurs[$r['eleve']->id % count($couleurs)];
                    @endphp
                    <tr class="hover:bg-bg-page transition-colors {{ $estAdmis ? '' : 'bg-red-50' }}">
                        <td class="px-4 py-3 text-center">
                            <span class="w-7 h-7 rounded-full bg-primary-bg text-primary text-sm font-bold inline-flex items-center justify-center">
                                {{ $r['rang'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                    {{ $initiales }}
                                </div>
                                <span class="text-sm font-medium text-text-dark">{{ $r['eleve']->prenom }} {{ $r['eleve']->nom }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($r['eleve']->sexe == 'M')
                                <span class="text-xs font-bold bg-blue-50 text-blue-700 px-2 py-1 rounded-full">M</span>
                            @else
                                <span class="text-xs font-bold bg-pink-50 text-pink-700 px-2 py-1 rounded-full">F</span>
                            @endif
                        </td>
                        @foreach([1,2,3] as $t)
                        <td class="px-4 py-3 text-center text-sm font-semibold text-primary">
                            {{ $r['moyennes'][$t] !== null ? number_format($r['moyennes'][$t], 2).'/10' : '—' }}
                        </td>
                        @endforeach
                        <td class="px-4 py-3 text-center">
                            <span class="font-bold text-primary text-base">
                                {{ $r['moyAnnuelle'] !== null ? number_format($r['moyAnnuelle'], 2).'/10' : '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($estAdmis)
                                <span class="text-xs font-semibold bg-green-50 text-green-700 px-2.5 py-1 rounded-full">Passe en classe supérieure</span>
                            @else
                                <span class="text-xs font-semibold bg-red-50 text-red-700 px-2.5 py-1 rounded-full">Redouble</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection