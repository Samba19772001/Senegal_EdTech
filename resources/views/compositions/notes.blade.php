@extends('layouts.app')

@section('title', 'Saisie des notes — Senegal EdTech')
@section('page_label', 'COMPOSITION T2')
@section('page_title', 'Saisie des notes')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-text-muted mb-6">
        <a href="/compositions" class="hover:text-primary transition-colors">Compositions</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-text-dark font-medium">Composition T2 — Saisie des notes</span>
    </div>

    <div class="grid grid-cols-3 gap-6">

        {{-- Colonne gauche : liste des matières --}}
        <div class="col-span-1">
            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h3 class="text-text-dark font-semibold text-sm">Matières</h3>
                    <p class="text-text-muted text-xs mt-0.5">Cliquez pour saisir les notes</p>
                </div>
                <div class="p-3 space-y-1">

                    {{-- Matière terminée --}}
                    <button class="w-full flex items-center justify-between px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-left transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <div>
                                <p class="text-sm font-semibold text-green-700">Français</p>
                                <p class="text-xs text-green-600">Sur 40 pts — 42 notes</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>

                    <button class="w-full flex items-center justify-between px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-left transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <div>
                                <p class="text-sm font-semibold text-green-700">Mathématiques</p>
                                <p class="text-xs text-green-600">Sur 40 pts — 42 notes</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>

                    {{-- Matière active --}}
                    <button onclick="changerMatiere('Histoire-Géographie', 20)" class="w-full flex items-center justify-between px-4 py-3 rounded-xl bg-primary-bg border border-primary text-left transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-primary"></div>
                            <div>
                                <p class="text-sm font-semibold text-primary">Histoire-Géographie</p>
                                <p class="text-xs text-primary">Sur 20 pts — En cours</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    {{-- Matières à faire --}}
                    <button onclick="changerMatiere('Sciences', 20)" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-bg-page border border-transparent text-left transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                            <div>
                                <p class="text-sm font-medium text-text-dark">Sciences</p>
                                <p class="text-xs text-text-muted">Sur 20 pts — À saisir</p>
                            </div>
                        </div>
                    </button>

                    <button onclick="changerMatiere('Éducation Civique', 10)" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-bg-page border border-transparent text-left transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                            <div>
                                <p class="text-sm font-medium text-text-dark">Éducation Civique</p>
                                <p class="text-xs text-text-muted">Sur 10 pts — À saisir</p>
                            </div>
                        </div>
                    </button>

                    <button onclick="changerMatiere('Anglais', 20)" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-bg-page border border-transparent text-left transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                            <div>
                                <p class="text-sm font-medium text-text-dark">Anglais</p>
                                <p class="text-xs text-text-muted">Sur 20 pts — À saisir</p>
                            </div>
                        </div>
                    </button>

                </div>

                {{-- Progression --}}
                <div class="px-5 py-4 border-t border-border">
                    <div class="flex items-center justify-between text-xs text-text-muted mb-2">
                        <span>Progression</span>
                        <span class="font-semibold text-primary">2 / 6 matières</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full transition-all" style="width: 33%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Colonne droite : saisie des notes --}}
        <div class="col-span-2">
            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">

                {{-- Header saisie --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-border bg-primary-bg">
                    <div>
                        <h3 id="titre-matiere" class="text-text-dark font-bold text-base">Histoire-Géographie</h3>
                        <p id="sous-titre-matiere" class="text-text-muted text-xs mt-0.5">Notes sur <span id="note-sur">20</span> points — Composition T2</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="toutMettre0()" class="px-3 py-1.5 border border-border rounded-lg text-xs text-text-muted hover:bg-white transition-colors">
                            Tout à 0
                        </button>
                        <button onclick="validerNotes()" class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Valider et continuer
                        </button>
                    </div>
                </div>

                {{-- Tableau saisie --}}
                <form id="formNotes">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-bg-page">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest w-8">#</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Matricule</th>
                                <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Note <span id="colonne-sur">/20</span></th>
                                <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Sur 10</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border" id="tbody-eleves">

                            @php
                            $eleves = [
                                ['initiales' => 'MS', 'nom' => 'Moussa Sow', 'matricule' => 'EL-2024-001', 'couleur' => 'blue'],
                                ['initiales' => 'AF', 'nom' => 'Awa Fall', 'matricule' => 'EL-2024-002', 'couleur' => 'pink'],
                                ['initiales' => 'ID', 'nom' => 'Ibrahim Diallo', 'matricule' => 'EL-2024-003', 'couleur' => 'orange'],
                                ['initiales' => 'FD', 'nom' => 'Fatou Diop', 'matricule' => 'EL-2024-004', 'couleur' => 'purple'],
                                ['initiales' => 'OB', 'nom' => 'Oumar Ba', 'matricule' => 'EL-2024-005', 'couleur' => 'green'],
                                ['initiales' => 'MN', 'nom' => 'Mariama Ndiaye', 'matricule' => 'EL-2024-006', 'couleur' => 'red'],
                            ];
                            @endphp

                            @foreach($eleves as $i => $eleve)
                            <tr class="hover:bg-bg-page transition-colors">
                                <td class="px-6 py-3 text-sm text-text-muted">{{ $i + 1 }}</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-{{ $eleve['couleur'] }}-100 text-{{ $eleve['couleur'] }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                            {{ $eleve['initiales'] }}
                                        </div>
                                        <span class="text-sm font-medium text-text-dark">{{ $eleve['nom'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-sm text-text-muted font-mono">{{ $eleve['matricule'] }}</td>
                                <td class="px-6 py-3">
                                    <input type="number"
                                        name="notes[{{ $i }}]"
                                        min="0" max="20" step="0.25"
                                        placeholder="—"
                                        onchange="calculerSur10(this, {{ $i }})"
                                        class="note-input w-24 mx-auto block border border-border rounded-xl px-3 py-2 text-sm text-center text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <span id="sur10-{{ $i }}" class="text-sm font-semibold text-text-muted">—</span>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </form>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-border flex items-center justify-between bg-bg-page">
                    <p class="text-sm text-text-muted">
                        <span id="notes-saisies">0</span> / {{ count($eleves) }} notes saisies
                    </p>
                    <button onclick="validerNotes()"
                        class="flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
                        Valider et passer à la matière suivante
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let noteSur = 20;

    function changerMatiere(nom, sur) {
        noteSur = sur;
        document.getElementById('titre-matiere').textContent = nom;
        document.getElementById('sous-titre-matiere').innerHTML = `Notes sur <span id="note-sur">${sur}</span> points — Composition T2`;
        document.getElementById('colonne-sur').textContent = `/${sur}`;

        // Reset les inputs
        document.querySelectorAll('.note-input').forEach((input, i) => {
            input.max = sur;
            input.value = '';
            document.getElementById(`sur10-${i}`).textContent = '—';
            document.getElementById(`sur10-${i}`).className = 'text-sm font-semibold text-text-muted';
        });
        updateCompteur();
    }

    function calculerSur10(input, index) {
        const note = parseFloat(input.value);
        const span = document.getElementById(`sur10-${index}`);
        if (!isNaN(note) && note >= 0 && note <= noteSur) {
            const sur10 = (note * 10 / noteSur).toFixed(2);
            span.textContent = sur10 + '/10';
            span.className = 'text-sm font-semibold text-primary';
            input.classList.remove('border-red-400');
            input.classList.add('border-green-400');
        } else if (input.value !== '') {
            span.textContent = 'Invalide';
            span.className = 'text-sm font-semibold text-red-500';
            input.classList.add('border-red-400');
            input.classList.remove('border-green-400');
        } else {
            span.textContent = '—';
            span.className = 'text-sm font-semibold text-text-muted';
            input.classList.remove('border-red-400', 'border-green-400');
        }
        updateCompteur();
    }

    function updateCompteur() {
        const remplis = [...document.querySelectorAll('.note-input')].filter(i => i.value !== '').length;
        document.getElementById('notes-saisies').textContent = remplis;
    }

    function toutMettre0() {
        document.querySelectorAll('.note-input').forEach((input, i) => {
            input.value = 0;
            calculerSur10(input, i);
        });
    }

    function validerNotes() {
        alert('Notes validées ! Passage à la matière suivante...');
    }
</script>
@endpush