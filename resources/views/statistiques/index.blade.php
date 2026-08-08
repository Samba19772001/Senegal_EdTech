@extends('layouts.app')

@section('title', 'Statistiques — Senegal EdTech')
@section('page_label', 'ANALYSE')
@section('page_title', 'Statistiques')

@section('content')

    @if(empty($statsParTrimestre))
        <div class="bg-white rounded-2xl border border-border p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <p class="font-medium text-text-dark">Aucune donnée disponible</p>
            <p class="text-sm text-text-muted mt-1">Saisissez des notes pour voir les statistiques</p>
        </div>
    @else

    {{-- Stats globales --}}
    @if($statsGlobales)
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-text-dark">{{ $statsGlobales['totalEleves'] }}</p>
            <p class="text-xs text-text-muted mt-1">Total élèves</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $statsGlobales['totalGarcons'] }}</p>
            <p class="text-xs text-text-muted mt-1">Garçons</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-pink-600">{{ $statsGlobales['totalFilles'] }}</p>
            <p class="text-xs text-text-muted mt-1">Filles</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-primary">{{ $statsGlobales['moyenneGlobale'] ?? '—' }}/10</p>
            <p class="text-xs text-text-muted mt-1">Moy. globale</p>
        </div>
    </div>
    @endif

    {{-- Sélecteur trimestre --}}
    <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-1">
        @foreach($statsParTrimestre as $t => $stats)
        <a href="?trimestre={{ $t }}"
            class="px-4 py-2 rounded-xl text-sm font-medium transition-colors whitespace-nowrap flex-shrink-0
            {{ $trimestreActif == $t ? 'bg-primary text-white' : 'border border-border text-text-muted hover:bg-primary-bg hover:text-primary' }}">
            Trimestre {{ $t }}
        </a>
        @endforeach
    </div>

    @if(isset($statsParTrimestre[$trimestreActif]))
    @php $data = $statsParTrimestre[$trimestreActif]; @endphp

    {{-- Stats du trimestre --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="bg-primary rounded-2xl p-4 text-white text-center">
            <p class="text-2xl font-bold">{{ $data['moyenneClasse'] ? number_format($data['moyenneClasse'], 2) : '—' }}/10</p>
            <p class="text-blue-200 text-xs mt-1">Moy. classe T{{ $trimestreActif }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $data['mentionsCount']['Très Bien'] + $data['mentionsCount']['Bien'] + $data['mentionsCount']['Assez Bien'] }}</p>
            <p class="text-xs text-text-muted mt-1">Au-dessus de la moyenne</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-amber-600">{{ $data['mentionsCount']['Passable'] }}</p>
            <p class="text-xs text-text-muted mt-1">Passable</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 text-center">
            <p class="text-2xl font-bold text-red-600">{{ $data['mentionsCount']['Insuffisant'] }}</p>
            <p class="text-xs text-text-muted mt-1">Insuffisant</p>
        </div>
    </div>

    {{-- Répartition mentions --}}
    @if($data['totalBulletins'] > 0)
    <div class="bg-white rounded-2xl border border-border shadow-sm p-5 mb-6">
        <h3 class="font-bold text-text-dark text-sm mb-4">Répartition des mentions — Trimestre {{ $trimestreActif }}</h3>
        <div class="space-y-3">
            @foreach([
                ['Très Bien',   'bg-green-500',  'text-green-700',  'bg-green-50'],
                ['Bien',        'bg-blue-500',   'text-blue-700',   'bg-blue-50'],
                ['Assez Bien',  'bg-indigo-500', 'text-indigo-700', 'bg-indigo-50'],
                ['Passable',    'bg-amber-500',  'text-amber-700',  'bg-amber-50'],
                ['Insuffisant', 'bg-red-500',    'text-red-700',    'bg-red-50'],
            ] as [$mention, $barColor, $textColor, $bgColor])
            @php
                $count = $data['mentionsCount'][$mention];
                $pct   = $data['totalBulletins'] > 0 ? round($count / $data['totalBulletins'] * 100) : 0;
            @endphp
            <div class="flex items-center gap-3">
                <span class="text-xs font-medium text-text-muted w-20 flex-shrink-0">{{ $mention }}</span>
                <div class="flex-1 bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div class="{{ $barColor }} h-3 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                </div>
                <span class="text-xs font-bold {{ $textColor }} w-16 text-right flex-shrink-0">{{ $count }} ({{ $pct }}%)</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Meilleur / Plus faible --}}
    @if($data['meilleurEleve'] && $data['plusFaible'])
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-green-50 border border-green-200 rounded-2xl p-4 flex items-center gap-4">
            
            <div>
                <p class="text-xs text-green-600 font-medium">Meilleur élève</p>
                <p class="font-bold text-green-800 text-sm">{{ $data['meilleurEleve']->eleve->prenom }} {{ $data['meilleurEleve']->eleve->nom }}</p>
                <p class="text-xs text-green-600">{{ number_format($data['meilleurEleve']->moyenne_generale, 2) }}/10</p>
            </div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex items-center gap-4">
            
            <div>
                <p class="text-xs text-red-600 font-medium">Élève en difficulté</p>
                <p class="font-bold text-red-800 text-sm">{{ $data['plusFaible']->eleve->prenom }} {{ $data['plusFaible']->eleve->nom }}</p>
                <p class="text-xs text-red-600">{{ number_format($data['plusFaible']->moyenne_generale, 2) }}/10</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Tableau stats par matière --}}
    @if(!empty($data['statsParMatiere']))
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-border">
            <h3 class="font-bold text-text-dark text-sm">Statistiques par matière — Trimestre {{ $trimestreActif }}</h3>
            <p class="text-xs text-text-muted mt-0.5">Répartition garçons / filles selon la moyenne (≥ 5/10)</p>
        </div>
        <div class="-mx-0 overflow-x-auto">
            <table class="w-full" style="min-width: 750px;">
                <thead>
                    <tr class="bg-primary-bg">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Matière</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Moy.</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-blue-600 uppercase tracking-widest">G ≥ 5</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-blue-400 uppercase tracking-widest">G < 5</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-pink-600 uppercase tracking-widest">F ≥ 5</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-pink-400 uppercase tracking-widest">F < 5</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Abs. G</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Abs. F</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-green-600 uppercase tracking-widest">Max</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-red-500 uppercase tracking-widest">Min</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Réussite</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($data['statsParMatiere'] as $stat)
                    @php
                        $tauxColor = $stat['tauxReussite'] >= 75 ? 'text-green-600' :
                                    ($stat['tauxReussite'] >= 50 ? 'text-amber-600' : 'text-red-600');
                    @endphp
                    <tr class="hover:bg-bg-page transition-colors">
                        <td class="px-4 py-3">
                            <p class="text-sm font-medium text-text-dark">{{ $stat['matiere']->nom }}</p>
                            <p class="text-xs text-text-muted">/{{ $stat['matiere']->note_sur }} pts</p>
                        </td>
                        <td class="px-3 py-3 text-center">
                            <span class="font-bold text-primary text-sm">
                                {{ $stat['moyenne'] !== null ? number_format($stat['moyenne'], 2) : '—' }}/10
                            </span>
                        </td>
                        {{-- Garçons avec moyenne --}}
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-sm font-bold">
                                {{ $stat['garconsMoyenne'] }}
                            </span>
                        </td>
                        {{-- Garçons sans moyenne --}}
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-400 text-sm font-bold">
                                {{ $stat['garconsSansMoy'] }}
                            </span>
                        </td>
                        {{-- Filles avec moyenne --}}
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-pink-100 text-pink-700 text-sm font-bold">
                                {{ $stat['fillesMoyenne'] }}
                            </span>
                        </td>
                        {{-- Filles sans moyenne --}}
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-pink-50 text-pink-400 text-sm font-bold">
                                {{ $stat['fillesSansMoy'] }}
                            </span>
                        </td>
                        {{-- Absents --}}
                        <td class="px-3 py-3 text-center text-sm text-text-muted">{{ $stat['absentsG'] }}</td>
                        <td class="px-3 py-3 text-center text-sm text-text-muted">{{ $stat['absentsF'] }}</td>
                        {{-- Max / Min --}}
                        <td class="px-3 py-3 text-center">
                            @if($stat['noteMax'] !== null)
                            <span class="text-xs font-bold text-green-600">{{ $stat['noteMax'] }}/10</span>
                            <p class="text-xs text-text-muted truncate max-w-[70px]">{{ $stat['eleveMax'] }}</p>
                            @else <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 text-center">
                            @if($stat['noteMin'] !== null)
                            <span class="text-xs font-bold text-red-500">{{ $stat['noteMin'] }}/10</span>
                            <p class="text-xs text-text-muted truncate max-w-[70px]">{{ $stat['eleveMin'] }}</p>
                            @else <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        {{-- Taux réussite --}}
                        <td class="px-3 py-3 text-center">
                            <span class="text-sm font-bold {{ $tauxColor }}">{{ $stat['tauxReussite'] }}%</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @endif
    @endif

@endsection