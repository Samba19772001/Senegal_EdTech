@extends('layouts.app')

@section('title', 'Classement — Senegal EdTech')
@section('page_label', 'RÉSULTATS')
@section('page_title', 'Classement par ordre de mérite')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-text-muted mb-6 flex-wrap">
        <a href="{{ route('bulletins.index') }}" class="hover:text-primary transition-colors">Bulletins</a>
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-text-dark font-medium">Classement {{ $composition->libelle }}</span>
    </div>

    {{-- Header --}}
    <div class="bg-primary rounded-2xl p-6 mb-6 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            @php
                $libelle = strtoupper($composition->libelle);
            @endphp

            <h2 class="text-xl font-bold">
                BULLETIN DE COMPOSITION — 
                @if(str_contains($libelle, 'T3'))
                    3em TRIMESTRE
                @elseif(str_contains($libelle, 'T2'))
                    2em TRIMESTRE
                @elseif(str_contains($libelle, 'T1'))
                    1er TRIMESTRE
                @else
                    {{ $libelle }}
                @endif
                — {{ $composition->classe->nom }}
            </h2>
            <p class="text-blue-200 text-sm mt-1">
                Année scolaire : {{ auth()->user()->annee_scolaire }} •
                {{ $resultats->count() }} élèves •
                Moyenne classe : {{ number_format($moyenneClasse, 2) }}/10
            </p>
        </div>
        <a href="{{ route('bulletins.classement.pdf', $composition->id) }}"
            class="flex items-center gap-2 px-5 py-2.5 bg-white text-primary hover:bg-primary-bg rounded-xl text-sm font-semibold transition-colors flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Télécharger PDF
        </a>
    </div>

    {{-- Tableau classement --}}
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
        <div class="overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 900px; border-collapse: collapse;">

                <thead>
                    <tr class="bg-primary">

                        <th class="text-left px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest whitespace-nowrap">
                            Rang
                        </th>

                        <th class="text-left px-4 py-3 text-xs font-semibold text-white uppercase tracking-widest whitespace-nowrap">
                            Élève
                        </th>

                        {{-- ✅ Sexe --}}
                        <th class="text-center px-3 py-3 text-xs font-semibold text-white uppercase tracking-widest whitespace-nowrap">
                            Sexe
                        </th>

                        {{-- Matières en vertical --}}
                        @foreach($matieres as $matiere)
                        <th class="px-2 text-white uppercase tracking-widest font-semibold"
                            style="height: 90px; vertical-align: bottom; text-align: center; white-space: nowrap;">
                            <div style="display: inline-flex; flex-direction: column; align-items: center;
                                        writing-mode: vertical-rl; transform: rotate(180deg);
                                        font-size: 10px; line-height: 1.2; padding-bottom: 6px;">
                                <span>{{ $matiere->nom }}</span>
                                <span style="color: #93c5fd; font-weight: 400; font-size: 9px;">/{{ $matiere->note_sur }}</span>
                            </div>
                        </th>
                        @endforeach

                        <th class="text-center px-3 py-3 text-xs font-semibold text-white uppercase tracking-widest">Total</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-white uppercase tracking-widest">Moy/10</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-white uppercase tracking-widest">Mention</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-border">
                    @foreach($resultats as $resultat)
                    @php
                        $eleve     = $resultat['eleve'];
                        $initiales = strtoupper(substr($eleve->prenom, 0, 1) . substr($eleve->nom, 0, 1));
                        $couleurs  = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                        $couleur   = $couleurs[$eleve->id % count($couleurs)];
                        $mentionColors = [
                            'Très Bien'   => 'bg-green-50 text-green-700',
                            'Bien'        => 'bg-blue-50 text-blue-700',
                            'Assez Bien'  => 'bg-indigo-50 text-indigo-700',
                            'Passable'    => 'bg-amber-50 text-amber-700',
                            'Insuffisant' => 'bg-red-50 text-red-700',
                        ];
                        $mentionClass = $mentionColors[$resultat['mention']] ?? 'bg-gray-50 text-gray-700';
                        $rowBg = $resultat['rang'] == 1 ? 'bg-amber-50'
                               : ($resultat['rang'] == 2 ? 'bg-gray-50'
                               : ($resultat['rang'] == 3 ? 'bg-orange-50' : ''));
                    @endphp
                    <tr class="hover:bg-bg-page transition-colors {{ $rowBg }}">

                        {{-- Rang --}}
                        <td class="px-4 py-3 text-center">
                            <span class="w-7 h-7 rounded-full bg-primary-bg text-primary text-sm font-bold inline-flex items-center justify-center">
                                {{ $resultat['rang'] }}
                            </span>
                        </td>

                        {{-- Élève --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                    {{ $initiales }}
                                </div>
                                <span class="text-sm font-medium text-text-dark whitespace-nowrap">
                                    {{ $eleve->prenom }} {{ $eleve->nom }}
                                </span>
                            </div>
                        </td>

                        {{-- ✅ Sexe --}}
                        <td class="px-3 py-3 text-center">
                            @if($eleve->sexe === 'M')
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-50 text-blue-700">M</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-pink-50 text-pink-700">F</span>
                            @endif
                        </td>

                        {{-- Notes par matière --}}
                        @foreach($matieres as $matiere)
                        @php $noteData = $resultat['notes'][$matiere->id] ?? null; @endphp
                        <td class="px-2 py-3 text-center text-sm">
                            @if($noteData && $noteData['note'] !== null)
                                <span class="font-semibold text-text-dark">{{ $noteData['note'] }}</span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        @endforeach

                        {{-- Total --}}
                        <td class="px-3 py-3 text-center">
                            <span class="font-bold text-text-dark text-sm">{{ number_format($resultat['totalPoints'], 2) }}</span>
                        </td>

                        {{-- Moyenne --}}
                        <td class="px-3 py-3 text-center">
                            <span class="font-bold text-primary text-sm">{{ number_format($resultat['moyenne'], 2) }}</span>
                        </td>

                        {{-- Mention --}}
                        <td class="px-3 py-3 text-center">
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $mentionClass }}">
                                {{ $resultat['mention'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

                {{-- Footer stats --}}
                <tfoot>
                    <tr class="bg-primary-bg border-t-2 border-primary">
                        {{-- ✅ colspan 3 pour couvrir Rang + Élève + Sexe --}}
                        <td colspan="3" class="px-4 py-3 text-xs font-bold text-text-dark uppercase">
                            Moyenne de la classe
                        </td>
                        @foreach($matieres as $matiere)
                        @php
                            $moyMat = $resultats->avg(function($r) use ($matiere) {
                                $n = $r['notes'][$matiere->id] ?? null;
                                return $n && $n['note'] !== null ? $n['note_ramenee'] : null;
                            });
                        @endphp
                        <td class="px-2 py-3 text-center text-xs font-semibold text-primary">
                            {{ $moyMat ? number_format($moyMat, 2) : '—' }}
                        </td>
                        @endforeach
                        <td class="px-3 py-3 text-center text-xs font-bold text-text-dark">—</td>
                        <td class="px-3 py-3 text-center text-sm font-bold text-primary">{{ number_format($moyenneClasse, 2) }}/10</td>
                        <td></td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>

@endsection