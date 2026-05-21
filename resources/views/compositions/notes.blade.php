@extends('layouts.app')

@section('title', 'Saisie des notes — Senegal EdTech')
@section('page_label')COMPOSITION {{ $composition->libelle }}@endsection
@section('page_title', 'Saisie des notes')

@section('content')

    <div class="flex flex-wrap items-center gap-2 text-sm text-text-muted mb-6">
        <a href="{{ route('compositions.index') }}" class="hover:text-primary transition-colors">
            Compositions
        </a>

        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>

        <span class="text-text-dark font-medium">
            {{ $composition->libelle }} — Saisie des notes
        </span>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Colonne gauche : matières --}}
        <div class="xl:col-span-1 order-2 xl:order-1">

            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">

                <div class="px-5 py-4 border-b border-border">
                    <h3 class="text-text-dark font-semibold text-sm">Matières</h3>

                    <p class="text-text-muted text-xs mt-0.5">
                        Cliquez pour saisir les notes
                    </p>
                </div>

                <div class="p-3 space-y-1 max-h-[70vh] overflow-y-auto">

                    @foreach($matieres as $mat)

                    @php
                        $notesSaisies = $composition->notes->where('matiere_id', $mat->id)->count();
                        $totalEleves  = $eleves->count();
                        $estTermine   = $totalEleves > 0 && $notesSaisies >= $totalEleves;
                        $estActif     = isset($matiere) && $matiere->id == $mat->id;
                    @endphp

                    <a href="{{ route('notes.showMatiere', [$composition->id, $mat->id]) }}"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-left transition-all
                        {{ $estActif ? 'bg-primary-bg border border-primary' : ($estTermine ? 'bg-green-50 border border-green-200' : 'hover:bg-bg-page border border-transparent') }}">

                        <div class="flex items-center gap-3 min-w-0">

                            <div class="w-2 h-2 rounded-full flex-shrink-0
                                {{ $estActif ? 'bg-primary' : ($estTermine ? 'bg-green-500' : 'bg-gray-300') }}">
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-semibold truncate
                                    {{ $estActif ? 'text-primary' : ($estTermine ? 'text-green-700' : 'text-text-dark') }}">
                                    {{ $mat->nom }}
                                </p>

                                <p class="text-xs truncate
                                    {{ $estActif ? 'text-primary' : ($estTermine ? 'text-green-600' : 'text-text-muted') }}">
                                    Sur {{ $mat->note_sur }} pts —
                                    {{ $estTermine ? $notesSaisies.' notes' : ($estActif ? 'En cours' : 'À saisir') }}
                                </p>
                            </div>
                        </div>

                        @if($estTermine)
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"/>
                            </svg>

                        @elseif($estActif)

                            <svg class="w-4 h-4 text-primary flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"/>
                            </svg>

                        @endif
                    </a>

                    @endforeach
                </div>

                @php
                    $totalMatieres     = $matieres->count();
                    $matiересTerminees = $matieres->filter(function($m) use ($composition, $eleves) {
                        return $composition->notes->where('matiere_id', $m->id)->count() >= $eleves->count();
                    })->count();

                    $progressionGlobal = $totalMatieres > 0
                        ? round($matiересTerminees / $totalMatieres * 100)
                        : 0;
                @endphp

                <div class="px-5 py-4 border-t border-border">

                    <div class="flex items-center justify-between text-xs text-text-muted mb-2">
                        <span>Progression</span>

                        <span class="font-semibold text-primary">
                            {{ $matiересTerminees }} / {{ $totalMatieres }} matières
                        </span>
                    </div>

                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full transition-all"
                            style="width: {{ $progressionGlobal }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Colonne droite : saisie --}}
        <div class="xl:col-span-2 order-1 xl:order-2">

            @isset($matiere)

            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">

                {{-- HEADER --}}
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 px-4 sm:px-6 py-4 border-b border-border bg-primary-bg">

                    <div>
                        <h3 class="text-text-dark font-bold text-base">
                            {{ $matiere->nom }}
                        </h3>

                        <p class="text-text-muted text-xs mt-0.5">
                            Notes sur
                            <span class="font-bold text-primary">
                                {{ $matiere->note_sur }}
                            </span>
                            points — {{ $composition->libelle }}
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">

                        <button type="button"
                            onclick="toutMettre0()"
                            class="w-full sm:w-auto px-3 py-2 border border-border rounded-lg text-xs text-text-muted hover:bg-white transition-colors">

                            Tout à 0
                        </button>

                        <button type="button"
                            onclick="document.getElementById('formNotes').submit()"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">

                            <svg class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"/>
                            </svg>

                            Valider et continuer
                        </button>
                    </div>
                </div>

                <form id="formNotes"
                    method="POST"
                    action="{{ route('notes.storeMatiere', [$composition->id, $matiere->id]) }}">

                    @csrf

                    {{-- TABLE RESPONSIVE --}}
                    <div class="w-full overflow-x-auto">

                        <table class="w-full min-w-[700px] lg:min-w-full">

                            <thead>
                                <tr class="bg-bg-page">

                                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest w-8">
                                        #
                                    </th>

                                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">
                                        Élève
                                    </th>

                                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">
                                        Matricule
                                    </th>

                                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">
                                        Note /{{ $matiere->note_sur }}
                                    </th>

                                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">
                                        Sur 10
                                    </th>

                                    <th class="text-center px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">
                                        Absent
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-border">

                                @foreach($eleves as $i => $eleve)

                                @php
                                    $ligneExiste   = $notesExistantes->has($eleve->id);
                                    $noteExistante = $ligneExiste ? $notesExistantes[$eleve->id] : 'NON_SAISIE';
                                    $estAbsent     = $ligneExiste && $noteExistante === null;
                                    $initiales     = strtoupper(substr($eleve->prenom, 0, 1) . substr($eleve->nom, 0, 1));
                                    $couleurs      = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                                    $couleur       = $couleurs[$eleve->id % count($couleurs)];
                                @endphp

                                <tr class="hover:bg-bg-page transition-colors"
                                    id="row-{{ $eleve->id }}">

                                    <td class="px-4 sm:px-6 py-3 text-sm text-text-muted">
                                        {{ $i + 1 }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-3">

                                        <div class="flex items-center gap-3 min-w-[180px]">

                                            <div class="w-8 h-8 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                                {{ $initiales }}
                                            </div>

                                            <span class="text-sm font-medium text-text-dark whitespace-nowrap">
                                                {{ $eleve->prenom }} {{ $eleve->nom }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-3 text-sm text-text-muted font-mono whitespace-nowrap">
                                        {{ $eleve->matricule ?? '—' }}
                                    </td>

                                    {{-- Champ note --}}
                                    <td class="px-4 sm:px-6 py-3">

                                        <input type="number"
                                            id="input-{{ $eleve->id }}"
                                            name="notes[{{ $eleve->id }}]"
                                            value="{{ !$estAbsent && $ligneExiste ? $noteExistante : '' }}"
                                            min="0"
                                            max="{{ $matiere->note_sur }}"
                                            step="0.25"
                                            placeholder="{{ $estAbsent ? 'Absent' : '—' }}"
                                            {{ $estAbsent ? 'disabled' : '' }}
                                            onchange="calculerSur10(this, {{ $eleve->id }}, {{ $matiere->note_sur }})"
                                            class="note-input w-16 sm:w-20 mx-auto block border rounded-xl px-2 sm:px-3 py-2 text-sm text-center text-text-dark focus:outline-none focus:ring-2 focus:ring-primary transition-colors
                                            {{ $estAbsent ? 'border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed' : 'border-border bg-bg-page' }}"/>

                                        @if($estAbsent)
                                            <input type="hidden"
                                                id="hidden-{{ $eleve->id }}"
                                                name="notes[{{ $eleve->id }}]"
                                                value="">
                                        @endif
                                    </td>

                                    {{-- Sur 10 --}}
                                    <td class="px-4 sm:px-6 py-3 text-center whitespace-nowrap">

                                        <span id="sur10-{{ $eleve->id }}"
                                            class="text-sm font-semibold
                                            {{ $estAbsent ? 'text-gray-400' : ($ligneExiste && $noteExistante !== null ? 'text-primary' : 'text-text-muted') }}">

                                            @if($estAbsent)
                                                Absent

                                            @elseif($ligneExiste && $noteExistante !== null)

                                                {{ number_format($noteExistante * 10 / $matiere->note_sur, 2) }}/10

                                            @else
                                                —
                                            @endif
                                        </span>
                                    </td>

                                    {{-- Absent --}}
                                    <td class="px-4 py-3 text-center whitespace-nowrap">

                                        <button type="button"
                                            id="btn-absent-{{ $eleve->id }}"
                                            onclick="toggleAbsent({{ $eleve->id }}, {{ $matiere->note_sur }})"
                                            class="px-3 py-1.5 rounded-lg text-xs font-medium border transition-colors
                                            {{ $estAbsent
                                                ? 'bg-amber-100 border-amber-300 text-amber-700 hover:bg-white hover:text-text-muted'
                                                : 'bg-white border-gray-200 text-gray-400 hover:bg-amber-50 hover:border-amber-300 hover:text-amber-600' }}">

                                            {{ $estAbsent ? '↩ Remettre' : '— Absent' }}
                                        </button>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- FOOTER --}}
                    <div class="px-4 sm:px-6 py-4 border-t border-border flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between bg-bg-page">

                        <p class="text-sm text-text-muted">
                            <span id="notes-saisies">
                                {{ $notesExistantes->count() }}
                            </span>

                            / {{ $eleves->count() }} élèves traités
                        </p>

                        <button type="submit"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">

                            Valider et passer à la matière suivante

                            <svg class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            @else

            <div class="bg-white rounded-2xl border border-border p-6 sm:p-12 text-center shadow-sm">

                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>

                <p class="font-medium text-text-dark">
                    Sélectionnez une matière
                </p>

                <p class="text-sm text-text-muted mt-1">
                    Cliquez sur une matière à gauche pour commencer la saisie
                </p>
            </div>

            @endisset
        </div>
    </div>

@endsection