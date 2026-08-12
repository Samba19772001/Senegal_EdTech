@extends('layouts.app')

@section('title', 'Statistiques — Senegal EdTech')
@section('page_label', 'ANALYSE')
@section('page_title', 'Statistiques')

@push('styles')
<style>
    /* =========================================================
       RESPONSIVE UNIQUEMENT
       Aucun changement du layout desktop
       ========================================================= */

    #tableau-stats {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior-x: contain;
        width: 100%;
        max-width: 100%;
    }

    #tableau-stats table {
        width: max-content;
        min-width: 100%;
    }

    /* Petits écrans */
    @media (max-width: 640px) {

        /* Évite que le contenu dépasse de l'écran */
        .stats-page,
        main {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Cartes statistiques */
        .grid.grid-cols-2 {
            width: 100%;
        }

        /* Texte des cartes */
        .text-2xl {
            line-height: 1.2;
        }

        /* Sélecteur trimestre */
        .flex.items-center.gap-2.mb-6.overflow-x-auto {
            max-width: 100%;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .flex.items-center.gap-2.mb-6.overflow-x-auto::-webkit-scrollbar {
            display: none;
        }

        /* Répartition des mentions */
        .space-y-3 .flex.items-center.gap-3 {
            min-width: 0;
        }

        .space-y-3 .flex.items-center.gap-3 > .flex-1 {
            min-width: 60px;
        }

        /* Meilleur / plus faible */
        .bg-green-50,
        .bg-red-50 {
            min-width: 0;
        }

        .bg-green-50 p,
        .bg-red-50 p {
            overflow-wrap: anywhere;
        }

        /* Légende */
        .bg-white.rounded-2xl.border.border-border.p-4 {
            min-width: 0;
        }

        /* Tableau */
        #tableau-stats {
            max-width: 100vw;
        }

        #tableau-stats table {
            min-width: 760px;
        }

        /* En-tête du tableau */
        #tableau-stats th {
            position: relative;
        }

        /* Cellules */
        #tableau-stats td,
        #tableau-stats th {
            white-space: nowrap;
        }

        /* Titre du tableau */
        #tableau-stats + * {
            max-width: 100%;
        }
    }

    /* Très petits téléphones */
    @media (max-width: 400px) {

        /* Statistiques globales */
        .grid.grid-cols-2.lg\:grid-cols-4 {
            gap: 8px;
        }

        .grid.grid-cols-2.lg\:grid-cols-4 > div {
            min-width: 0;
        }

        .grid.grid-cols-2.lg\:grid-cols-4 .text-2xl {
            font-size: 1.35rem;
        }

        /* Boutons trimestre */
        .flex.items-center.gap-2.mb-6.overflow-x-auto a {
            padding-left: 12px;
            padding-right: 12px;
            font-size: 12px;
        }

        /* Barres de répartition */
        .space-y-3 .w-20 {
            width: 65px;
        }

        .space-y-3 .w-16 {
            width: 55px;
        }

        /* Hint */
        p.sm\:hidden {
            font-size: 10px;
        }
    }

    /* Évite les problèmes sur écrans tactiles */
    @media (hover: none) {
        #tableau-stats {
            scrollbar-width: thin;
        }
    }
</style>
@endpush

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
        <div class="bg-white rounded-2xl border border-border p-3 lg:p-4 text-center">
            <p class="text-2xl font-bold text-text-dark">{{ $statsGlobales['totalEleves'] }}</p>
            <p class="text-xs text-text-muted mt-1">Total élèves</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-3 lg:p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $statsGlobales['totalGarcons'] }}</p>
            <p class="text-xs text-text-muted mt-1">Garçons</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-3 lg:p-4 text-center">
            <p class="text-2xl font-bold text-pink-600">{{ $statsGlobales['totalFilles'] }}</p>
            <p class="text-xs text-text-muted mt-1">Filles</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-3 lg:p-4 text-center">
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
        <div class="bg-primary rounded-2xl p-3 lg:p-4 text-white text-center col-span-2 lg:col-span-1">
            <p class="text-2xl font-bold">{{ $data['moyenneClasse'] ? number_format($data['moyenneClasse'], 2) : '—' }}/10</p>
            <p class="text-blue-200 text-xs mt-1">Moy. classe T{{ $trimestreActif }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-3 lg:p-4 text-center">
            <p class="text-2xl font-bold text-green-600">
                {{ $data['mentionsCount']['Très Bien'] + $data['mentionsCount']['Bien'] + $data['mentionsCount']['Assez Bien'] }}
            </p>
            <p class="text-xs text-text-muted mt-1">Au-dessus moy.</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-3 lg:p-4 text-center">
            <p class="text-2xl font-bold text-amber-600">{{ $data['mentionsCount']['Passable'] }}</p>
            <p class="text-xs text-text-muted mt-1">Passable</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-3 lg:p-4 text-center">
            <p class="text-2xl font-bold text-red-600">{{ $data['mentionsCount']['Insuffisant'] }}</p>
            <p class="text-xs text-text-muted mt-1">Insuffisant</p>
        </div>
    </div>

    {{-- Répartition mentions + Meilleur/Faible --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">

        {{-- Répartition mentions --}}
        @if($data['totalBulletins'] > 0)
        <div class="bg-white rounded-2xl border border-border shadow-sm p-4 lg:p-5">
            <h3 class="font-bold text-text-dark text-sm mb-4">
                Répartition des mentions — Trimestre {{ $trimestreActif }}
            </h3>

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
                    <span class="text-xs font-medium text-text-muted w-20 flex-shrink-0">
                        {{ $mention }}
                    </span>

                    <div class="flex-1 bg-gray-100 rounded-full h-3 overflow-hidden min-w-0">
                        <div class="{{ $barColor }} h-3 rounded-full transition-all"
                             style="width: {{ $pct }}%">
                        </div>
                    </div>

                    <span class="text-xs font-bold {{ $textColor }} w-16 text-right flex-shrink-0">
                        {{ $count }} ({{ $pct }}%)
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Meilleur / Plus faible --}}
        <div class="space-y-3">

            @if($data['meilleurEleve'])
            <div class="bg-green-50 border border-green-200 rounded-2xl p-4 flex items-center gap-4">
                <div class="min-w-0">
                    <p class="text-xs text-green-600 font-medium">Meilleur élève</p>
                    <p class="font-bold text-green-800 text-sm break-words">
                        {{ $data['meilleurEleve']->eleve->prenom }} {{ $data['meilleurEleve']->eleve->nom }}
                    </p>
                    <p class="text-xs text-green-600">
                        {{ number_format($data['meilleurEleve']->moyenne_generale, 2) }}/10
                    </p>
                </div>
            </div>
            @endif

            @if($data['plusFaible'])
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex items-center gap-4">
                <div class="min-w-0">
                    <p class="text-xs text-red-600 font-medium">Élève en difficulté</p>
                    <p class="font-bold text-red-800 text-sm break-words">
                        {{ $data['plusFaible']->eleve->prenom }} {{ $data['plusFaible']->eleve->nom }}
                    </p>
                    <p class="text-xs text-red-600">
                        {{ number_format($data['plusFaible']->moyenne_generale, 2) }}/10
                    </p>
                </div>
            </div>
            @endif

            {{-- Légende --}}
            <div class="bg-white rounded-2xl border border-border p-4">
                <h4 class="font-semibold text-text-dark text-xs uppercase tracking-wide mb-3">
                    Légende du tableau
                </h4>

                <div class="space-y-1.5">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold items-center justify-center flex-shrink-0">
                            G
                        </span>
                        <span class="text-xs text-text-muted">
                            Garçons ayant / n'ayant pas la moyenne
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex w-6 h-6 rounded-full bg-pink-100 text-pink-700 text-xs font-bold items-center justify-center flex-shrink-0">
                            F
                        </span>
                        <span class="text-xs text-text-muted">
                            Filles ayant / n'ayant pas la moyenne
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex w-6 h-6 rounded-full bg-gray-100 text-gray-500 text-xs font-bold items-center justify-center flex-shrink-0">
                            A
                        </span>
                        <span class="text-xs text-text-muted">
                            Absents (G/F)
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hint scroll mobile --}}
    <p class="text-xs text-text-muted mb-2 flex items-center gap-1 sm:hidden">
        ← Faites défiler pour voir toutes les colonnes
    </p>

    {{-- Tableau stats par matière --}}
    @if(!empty($data['statsParMatiere']))
    <div class="-mx-4 lg:mx-0 lg:rounded-2xl lg:border lg:border-border"
        style="background:white;border-top:1px solid #c4c5d5;border-bottom:1px solid #c4c5d5;box-shadow:0 1px 3px rgba(0,0,0,.06);">

        <div class="px-4 lg:px-6 py-4 border-b border-border">
            <h3 class="font-bold text-text-dark text-sm">
                Statistiques par matière — Trimestre {{ $trimestreActif }}
            </h3>

            <p class="text-xs text-text-muted mt-0.5">
                G ≥ 5 / G < 5 = Garçons avec / sans la moyenne •
                F ≥ 5 / F < 5 = Filles avec / sans la moyenne
            </p>
        </div>

        <div id="tableau-stats">
            <table style="width:max-content;min-width:100%;border-collapse:collapse;">

                <thead>
                    <tr style="background:#00288e;">
                        <th style="text-align:left;padding:10px 12px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;white-space:nowrap;min-width:120px;">Matière</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;white-space:nowrap;min-width:55px;">Moy.</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:#93c5fd;text-transform:uppercase;white-space:nowrap;min-width:40px;">G ≥5</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:#bfdbfe;text-transform:uppercase;white-space:nowrap;min-width:40px;">G &lt;5</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:#fbcfe8;text-transform:uppercase;white-space:nowrap;min-width:40px;">F ≥5</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:#fce7f3;text-transform:uppercase;white-space:nowrap;min-width:40px;">F &lt;5</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;white-space:nowrap;min-width:48px;">Abs.G</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;white-space:nowrap;min-width:48px;">Abs.F</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:#86efac;text-transform:uppercase;white-space:nowrap;min-width:70px;">Max</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:#fca5a5;text-transform:uppercase;white-space:nowrap;min-width:70px;">Min</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;white-space:nowrap;min-width:65px;">Réussite</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data['statsParMatiere'] as $stat)
                    @php
                        $tauxColor = $stat['tauxReussite'] >= 75
                            ? 'color:#166534;background:#dcfce7;'
                            : ($stat['tauxReussite'] >= 50
                                ? 'color:#92400e;background:#fef3c7;'
                                : 'color:#991b1b;background:#fee2e2;');
                    @endphp

                    <tr style="border-bottom:1px solid #e2e8f0;">

                        <td style="padding:10px 12px;background:#ffffff;">
                            <p style="font-size:12px;font-weight:600;color:#1e293b;white-space:nowrap;">
                                {{ $stat['matiere']->nom }}
                            </p>
                            <p style="font-size:10px;color:#64748b;">
                                /{{ $stat['matiere']->note_sur }} pts
                            </p>
                        </td>

                        <td style="padding:10px 8px;text-align:center;">
                            <span style="font-size:12px;font-weight:700;color:#00288e;">
                                {{ $stat['moyenne'] !== null ? number_format($stat['moyenne'], 2) : '—' }}/10
                            </span>
                        </td>

                        <td style="padding:10px 8px;text-align:center;">
                            <span style="width:28px;height:28px;border-radius:50%;background:#dbeafe;color:#1d4ed8;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;">
                                {{ $stat['garconsMoyenne'] }}
                            </span>
                        </td>

                        <td style="padding:10px 8px;text-align:center;">
                            <span style="width:28px;height:28px;border-radius:50%;background:#eff6ff;color:#082F5C;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;">
                                {{ $stat['garconsSansMoy'] }}
                            </span>
                        </td>

                        <td style="padding:10px 8px;text-align:center;">
                            <span style="width:28px;height:28px;border-radius:50%;background:#fce7f3;color:#be185d;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;">
                                {{ $stat['fillesMoyenne'] }}
                            </span>
                        </td>

                        <td style="padding:10px 8px;text-align:center;">
                            <span style="width:28px;height:28px;border-radius:50%;background:#fdf2f8;color:#580635;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;">
                                {{ $stat['fillesSansMoy'] }}
                            </span>
                        </td>

                        <td style="padding:10px 8px;text-align:center;font-size:12px;color:#64748b;">
                            {{ $stat['absentsG'] }}
                        </td>

                        <td style="padding:10px 8px;text-align:center;font-size:12px;color:#64748b;">
                            {{ $stat['absentsF'] }}
                        </td>

                        <td style="padding:10px 8px;text-align:center;">
                            @if($stat['noteMax'] !== null)
                            <span style="font-size:11px;font-weight:700;color:#166534;display:block;">
                                {{ $stat['noteMax'] }}/10
                            </span>
                            <span style="font-size:9px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:65px;display:block;">
                                {{ $stat['eleveMax'] }}
                            </span>
                            @else
                                <span style="color:#d1d5db;">—</span>
                            @endif
                        </td>

                        <td style="padding:10px 8px;text-align:center;">
                            @if($stat['noteMin'] !== null)
                            <span style="font-size:11px;font-weight:700;color:#991b1b;display:block;">
                                {{ $stat['noteMin'] }}/10
                            </span>
                            <span style="font-size:9px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:65px;display:block;">
                                {{ $stat['eleveMin'] }}
                            </span>
                            @else
                                <span style="color:#d1d5db;">—</span>
                            @endif
                        </td>

                        <td style="padding:10px 8px;text-align:center;">
                            <span style="font-size:11px;font-weight:700;padding:3px 8px;border-radius:999px;white-space:nowrap;{{ $tauxColor }}">
                                {{ $stat['tauxReussite'] }}%
                            </span>
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