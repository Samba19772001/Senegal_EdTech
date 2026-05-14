@extends('layouts.app')

@section('title', 'Compositions — Senegal EdTech')
@section('page_label', 'GESTION')
@section('page_title', 'Compositions')

@section('content')

    <p class="text-text-muted text-sm mb-6">Sélectionnez un trimestre pour saisir les notes</p>

    {{-- Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Cards trimestres --}}
    <div class="grid grid-cols-3 gap-5">

        @foreach([1, 2, 3] as $trimestre)
        @php
            $composition = $compositions->get($trimestre)?->first();
        @endphp

        @if($composition)
            @php
                $niveau     = $composition->classe->nom;
                $matieres   = \App\Models\Matiere::where(function($q) use ($niveau) {
                    $q->where('is_default', true)->where('classe_niveau', $niveau);
                })->orWhere(function($q) {
                    $q->where('user_id', auth()->id())->where('is_default', false);
                })->count();

                $eleves          = $composition->classe->eleves->count();
                $notesEnregistrees = $composition->notes->count();
                $notesAttendues  = $matieres * $eleves;
                $progression     = $notesAttendues > 0 ? round($notesEnregistrees / $notesAttendues * 100) : 0;
                $matieresSaisies = $eleves > 0 ? floor($notesEnregistrees / $eleves) : 0;
                $estTermine      = $progression >= 100;

                $premierMatiere = \App\Models\Matiere::where(function($q) use ($niveau) {
                    $q->where('is_default', true)->where('classe_niveau', $niveau);
                })->orWhere(function($q) {
                    $q->where('user_id', auth()->id())->where('is_default', false);
                })->orderBy('ordre')->first();
            @endphp

            <div class="bg-white rounded-2xl border {{ $estTermine ? 'border-green-200' : 'border-primary' }} shadow-sm overflow-hidden">
                <div class="{{ $estTermine ? 'bg-green-600' : 'bg-primary' }} px-5 py-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-white opacity-70 uppercase tracking-widest">Trimestre {{ $trimestre }}</span>
                        @if($estTermine)
                            <span class="text-xs font-semibold bg-green-400 text-white px-2.5 py-1 rounded-full">Terminé</span>
                        @else
                            <span class="text-xs font-semibold bg-amber-400 text-white px-2.5 py-1 rounded-full">En cours</span>
                        @endif
                    </div>
                    <h3 class="text-white font-bold text-lg mt-1">{{ $composition->libelle }}</h3>
                    <p class="text-white opacity-60 text-xs mt-1">
                        {{ $composition->date_composition
                            ? \Carbon\Carbon::parse($composition->date_composition)->format('d M Y')
                            : 'Année scolaire : '.auth()->user()->annee_scolaire }}
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
                    @if($eleves > 0)
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="{{ $estTermine ? 'bg-green-500' : 'bg-amber-500' }} h-1.5 rounded-full transition-all"
                            style="width: {{ $progression }}%"></div>
                    </div>
                    @endif
                </div>
                <div class="px-5 pb-4 flex gap-2">
                    @if($premierMatiere)
                    <a href="{{ route('notes.showMatiere', [$composition->id, $premierMatiere->id]) }}"
                        class="flex-1 text-center border {{ $estTermine ? 'border-border text-text-muted hover:bg-primary-bg hover:text-primary' : 'border-primary text-primary hover:bg-primary-bg' }} py-2 rounded-xl text-xs font-medium transition-colors">
                        {{ $estTermine ? 'Voir notes' : 'Saisir notes' }}
                    </a>
                    @endif
                    <a href="{{ $estTermine ? route('bulletins.generer', $composition->id) : '#' }}"
                        class="flex-1 text-center {{ $estTermine ? 'bg-primary text-white hover:bg-primary-light' : 'bg-gray-100 text-text-muted cursor-not-allowed' }} py-2 rounded-xl text-xs font-medium transition-colors">
                        Bulletins PDF
                    </a>
                </div>
            </div>

        @else
            {{-- Composition non trouvée --}}
            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="bg-gray-400 px-5 py-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-200 uppercase tracking-widest">Trimestre {{ $trimestre }}</span>
                        <span class="text-xs font-semibold bg-gray-500 text-white px-2.5 py-1 rounded-full">Non disponible</span>
                    </div>
                    <h3 class="text-white font-bold text-lg mt-1">Composition T{{ $trimestre }}</h3>
                    <p class="text-gray-200 text-xs mt-1">—</p>
                </div>
                <div class="px-5 py-8 text-center text-text-muted text-sm">
                    Aucune composition trouvée
                </div>
            </div>
        @endif

        @endforeach

    </div>

@endsection