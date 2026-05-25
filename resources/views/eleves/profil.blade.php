@extends('layouts.app')

@section('title', 'Profil élève — Senegal EdTech')
@section('page_label', 'ÉLÈVE')
@section('page_title', 'Fiche élève')

@section('content')

    {{-- Retour --}}
    <div class="flex items-center gap-2 text-sm text-text-muted mb-6">
        <a href="{{ route('eleves.index') }}" class="hover:text-primary transition-colors">← Retour aux élèves</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Carte infos élève --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-border shadow-sm p-6 text-center">
                @php
                    $initiales = strtoupper(substr($eleve->prenom, 0, 1) . substr($eleve->nom, 0, 1));
                    $couleurs  = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                    $couleur   = $couleurs[$eleve->id % count($couleurs)];
                @endphp
                <div class="w-20 h-20 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-2xl font-bold flex items-center justify-center mx-auto mb-4">
                    {{ $initiales }}
                </div>
                <h3 class="text-text-dark font-bold text-lg">{{ $eleve->prenom }} {{ $eleve->nom }}</h3>
                <p class="text-text-muted text-sm mt-1">{{ $eleve->classe->nom ?? '—' }}</p>

                <div class="mt-4 space-y-2 text-left">
                    <div class="flex items-center justify-between bg-bg-page rounded-xl px-4 py-2.5">
                        <span class="text-xs text-text-muted">Matricule</span>
                        <span class="text-xs font-bold text-text-dark font-mono">{{ $eleve->matricule ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-bg-page rounded-xl px-4 py-2.5">
                        <span class="text-xs text-text-muted">Sexe</span>
                        <span class="text-xs font-bold text-text-dark">{{ $eleve->sexe == 'M' ? 'Garçon' : 'Fille' }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-bg-page rounded-xl px-4 py-2.5">
                        <span class="text-xs text-text-muted">Date de naissance</span>
                        <span class="text-xs font-bold text-text-dark">
                            {{ $eleve->date_naissance ? \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') : '—' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between bg-bg-page rounded-xl px-4 py-2.5">
                        <span class="text-xs text-text-muted">Inscrit le</span>
                        <span class="text-xs font-bold text-text-dark">{{ $eleve->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Moyenne annuelle --}}
            @if($moyenneAnnuelle !== null)
            <div class="bg-primary rounded-2xl p-5 mt-4 text-white text-center">
                <p class="text-blue-200 text-xs mb-1">Moyenne annuelle</p>
                <p class="text-3xl font-bold">{{ number_format($moyenneAnnuelle, 2) }}/10</p>
                @php
                    $ms = new \App\Services\MoyenneService();
                    $mention = $ms->getMention($moyenneAnnuelle);
                    $decision = $ms->getDecision($moyenneAnnuelle);
                @endphp
                <p class="text-blue-200 text-sm mt-1">{{ $mention }}</p>
                <div class="mt-3 px-3 py-2 rounded-xl {{ $decision == 'Passe en classe supérieure' ? 'bg-green-500' : 'bg-red-500' }} text-white text-xs font-bold">
                    {{ $decision }}
                </div>
            </div>
            @endif
        </div>

        {{-- Résultats par trimestre --}}
        <div class="lg:col-span-2 space-y-4">
            @foreach([1, 2, 3] as $t)
            @php $data = $trimestres[$t] ?? null; @endphp

            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="{{ $data && $data['moyenne'] !== null ? 'bg-primary' : 'bg-gray-400' }} px-5 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-white opacity-70 text-xs uppercase tracking-widest">Trimestre {{ $t }}</p>
                        <h3 class="text-white font-bold text-base mt-0.5">
                            {{ $data ? $data['composition']->libelle : 'Composition T'.$t }}
                        </h3>
                    </div>
                    @if($data && $data['moyenne'] !== null)
                        <div class="text-right">
                            <p class="text-white font-bold text-xl">{{ number_format($data['moyenne'], 2) }}/10</p>
                            <p class="text-blue-200 text-xs">Rang : {{ $data['rang'] ?? '—' }}</p>
                        </div>
                    @else
                        <span class="text-xs bg-gray-500 text-white px-2.5 py-1 rounded-full">Non saisi</span>
                    @endif
                </div>

                @if($data && $data['notes']->whereNotNull('note')->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="bg-primary-bg">
                            <th class="text-left px-4 py-2 text-xs font-semibold text-text-muted uppercase">Matière</th>
                            <th class="text-center px-4 py-2 text-xs font-semibold text-text-muted uppercase">Note</th>
                            <th class="text-center px-4 py-2 text-xs font-semibold text-text-muted uppercase">Sur</th>
                            <th class="text-center px-4 py-2 text-xs font-semibold text-text-muted uppercase">/10</th>
                            <th class="text-center px-4 py-2 text-xs font-semibold text-text-muted uppercase hidden sm:table-cell">Appréciation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach($data['notes'] as $note)
                        @php
                            $nr = $note->note !== null ? round($note->note * 10 / $note->matiere->note_sur, 2) : null;
                            if ($nr === null)    { $ac = 'text-gray-400'; $at = 'Absent'; }
                            elseif ($nr >= 9.5) { $ac = 'text-green-700'; $at = 'Excellent'; }
                            elseif ($nr >= 8)   { $ac = 'text-blue-700';  $at = 'Très Bien'; }
                            elseif ($nr >= 7)   { $ac = 'text-indigo-700';$at = 'Bien'; }
                            elseif ($nr >= 6)   { $ac = 'text-purple-700';$at = 'Assez Bien'; }
                            elseif ($nr >= 5)   { $ac = 'text-amber-700'; $at = 'Passable'; }
                            else                { $ac = 'text-red-700';   $at = 'Insuffisant'; }
                        @endphp
                        <tr class="hover:bg-bg-page">
                            <td class="px-4 py-2.5 text-sm text-text-dark">{{ $note->matiere->nom }}</td>
                            <td class="px-4 py-2.5 text-center font-bold text-primary text-sm">{{ $note->note ?? '—' }}</td>
                            <td class="px-4 py-2.5 text-center text-text-muted text-sm">{{ $note->matiere->note_sur }}</td>
                            <td class="px-4 py-2.5 text-center font-bold text-primary text-sm">{{ $nr !== null ? $nr : '—' }}</td>
                            <td class="px-4 py-2.5 text-center hidden sm:table-cell">
                                <span class="text-xs font-semibold {{ $ac }}">{{ $at }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @if($data['moyenne'] !== null)
                    <tfoot>
                        <tr class="bg-primary-bg">
                            <td colspan="3" class="px-4 py-2.5 text-sm font-bold text-text-dark">Moyenne T{{ $t }}</td>
                            <td class="px-4 py-2.5 text-center font-bold text-primary">{{ number_format($data['moyenne'], 2) }}/10</td>
                            <td class="hidden sm:table-cell px-4 py-2.5 text-center text-sm font-bold {{ $data['mention'] == 'Très Bien' ? 'text-green-600' : ($data['mention'] == 'Bien' ? 'text-blue-600' : 'text-text-muted') }}">
                                {{ $data['mention'] }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
                @elseif($data && $data['moyenne'] !== null)
                <div class="px-5 py-4 text-sm text-text-muted">
                    Moyenne saisie manuellement : <b class="text-primary">{{ number_format($data['moyenne'], 2) }}/10</b>
                </div>
                @else
                <div class="px-5 py-4 text-sm text-text-muted text-center">Aucune note saisie</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

@endsection