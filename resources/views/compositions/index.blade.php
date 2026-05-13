@extends('layouts.app')

@section('title', 'Compositions — Senegal EdTech')
@section('page_label', 'GESTION')
@section('page_title', 'Compositions')

@section('content')

    {{-- Barre d'actions --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-text-muted text-sm">Gérez vos compositions par trimestre</p>
        <button onclick="ouvrirModal()"
            class="flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle composition
        </button>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Cards trimestres --}}
    <div class="grid grid-cols-3 gap-5 mb-8">

        @foreach([1, 2, 3] as $trimestre)
        @php
            $composition = $compositions->get($trimestre)?->first();
        @endphp

        @if($composition)
            {{-- Composition existante --}}
            @php
                $niveau     = $composition->classe->nom;
                $matieres   = \App\Models\Matiere::where(function($q) use ($niveau) {
                    $q->where('is_default', true)->where('classe_niveau', $niveau);
                })->orWhere(function($q) {
                    $q->where('user_id', auth()->id())->where('is_default', false);
                })->count();

                $eleves         = $composition->classe->eleves->count();
                $notesEnregistrees = $composition->notes->count();
                $notesAttendues = $matieres * $eleves;
                $progression    = $notesAttendues > 0 ? round($notesEnregistrees / $notesAttendues * 100) : 0;
                $matieresSaisies = $eleves > 0 ? floor($notesEnregistrees / $eleves) : 0;
                $estTermine     = $progression >= 100;
            @endphp

            <div class="bg-white rounded-2xl border {{ $estTermine ? 'border-green-200' : 'border-primary' }} shadow-sm overflow-hidden">
                <div class="bg-primary px-5 py-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-blue-200 uppercase tracking-widest">Trimestre {{ $trimestre }}</span>
                        @if($estTermine)
                            <span class="text-xs font-semibold bg-green-400 text-white px-2.5 py-1 rounded-full">Terminé</span>
                        @else
                            <span class="text-xs font-semibold bg-amber-400 text-white px-2.5 py-1 rounded-full">En cours</span>
                        @endif
                    </div>
                    <h3 class="text-white font-bold text-lg mt-1">{{ $composition->libelle }}</h3>
                    <p class="text-blue-200 text-xs mt-1">
                        {{ $composition->date_composition ? \Carbon\Carbon::parse($composition->date_composition)->format('d M Y') : 'Date non définie' }}
                    </p>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-muted">Élèves</span>
                        <span class="font-semibold text-text-dark">{{ $eleves }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-muted">Matières saisies</span>
                        <span class="font-semibold {{ $estTermine ? 'text-green-600' : 'text-amber-600' }}">
                            {{ $matieresSaisies }} / {{ $matieres }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="{{ $estTermine ? 'bg-green-500' : 'bg-amber-500' }} h-1.5 rounded-full transition-all"
                            style="width: {{ $progression }}%"></div>
                    </div>
                </div>
                <div class="px-5 pb-4 flex gap-2">
                    <a href="{{ route('compositions.show', $composition->id) }}"
                        class="flex-1 text-center border {{ $estTermine ? 'border-border text-text-muted hover:bg-primary-bg hover:text-primary' : 'border-primary text-primary hover:bg-primary-bg' }} py-2 rounded-xl text-xs font-medium transition-colors">
                        Saisir notes
                    </a>
                    <a href="{{ route('bulletins.generer', $composition->id) }}"
                        class="flex-1 text-center {{ $estTermine ? 'bg-primary text-white hover:bg-primary-light' : 'bg-gray-100 text-text-muted cursor-not-allowed' }} py-2 rounded-xl text-xs font-medium transition-colors">
                        Bulletins PDF
                    </a>
                </div>
            </div>

        @else
            {{-- Trimestre vide --}}
            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="bg-gray-400 px-5 py-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-200 uppercase tracking-widest">Trimestre {{ $trimestre }}</span>
                        <span class="text-xs font-semibold bg-gray-500 text-white px-2.5 py-1 rounded-full">À venir</span>
                    </div>
                    <h3 class="text-white font-bold text-lg mt-1">Composition T{{ $trimestre }}</h3>
                    <p class="text-gray-200 text-xs mt-1">Non planifiée</p>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-muted">Élèves</span>
                        <span class="font-semibold text-gray-400">—</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-muted">Matières saisies</span>
                        <span class="font-semibold text-gray-400">0</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-gray-300 h-1.5 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
                <div class="px-5 pb-4 flex gap-2">
                    <button onclick="ouvrirModal()"
                        class="flex-1 text-center border border-border text-text-muted py-2 rounded-xl text-xs font-medium hover:bg-primary-bg hover:text-primary transition-colors">
                        Créer
                    </button>
                    <button class="flex-1 text-center bg-gray-100 text-text-muted py-2 rounded-xl text-xs font-medium cursor-not-allowed">
                        Bulletins PDF
                    </button>
                </div>
            </div>
        @endif

        @endforeach

    </div>

    {{-- MODAL Nouvelle composition --}}
    <div id="modalAjout" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black bg-opacity-40" onclick="fermerModal()"></div>
        <div class="relative bg-white rounded-2xl border border-border shadow-xl w-full max-w-md mx-4 z-10">
            <div class="bg-primary px-6 py-5 rounded-t-2xl flex items-center justify-between">
                <div>
                    <h3 class="text-white font-semibold text-base">Nouvelle composition</h3>
                    <p class="text-blue-200 text-xs mt-0.5">Créer une composition pour un trimestre</p>
                </div>
                <button onclick="fermerModal()" class="text-blue-200 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('compositions.store') }}" class="px-6 py-6 space-y-4">
                @csrf
                {{-- Classe automatique --}}
                @php $classeUser = auth()->user()->classes()->first(); @endphp
                @if($classeUser)
                    <input type="hidden" name="classe_id" value="{{ $classeUser->id }}">
                    <div class="bg-primary-bg rounded-xl px-4 py-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-primary">Classe : <b>{{ $classeUser->nom }} — {{ $classeUser->annee_scolaire }}</b></p>
                    </div>
                @else
                    <div class="bg-red-50 rounded-xl px-4 py-3 text-xs text-red-600">
                        Aucune classe trouvée. Veuillez contacter l'administrateur.
                    </div>
                @endif
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Trimestre</label>
                    <select name="trimestre" required class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                        <option value="">Sélectionner...</option>
                        <option value="1">Trimestre 1</option>
                        <option value="2">Trimestre 2</option>
                        <option value="3">Trimestre 3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Libellé</label>
                    <input type="text" name="libelle" placeholder="Ex: Composition T1" required
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                </div>
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Date <span class="text-gray-400 normal-case">(optionnel)</span></label>
                    <input type="date" name="date_composition"
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="fermerModal()"
                        class="flex-1 border border-border text-text-muted py-2.5 rounded-xl text-sm font-medium hover:bg-bg-page transition-colors">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 bg-primary hover:bg-primary-light text-white py-2.5 rounded-xl text-sm font-medium transition-colors">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function ouvrirModal() {
        document.getElementById('modalAjout').classList.remove('hidden');
        document.getElementById('modalAjout').classList.add('flex');
    }
    function fermerModal() {
        document.getElementById('modalAjout').classList.add('hidden');
        document.getElementById('modalAjout').classList.remove('flex');
    }
</script>
@endpush