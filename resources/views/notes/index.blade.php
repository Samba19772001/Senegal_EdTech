@extends('layouts.app')

@section('title', 'Notes — Senegal EdTech')
@section('page_label', 'GESTION')
@section('page_title', 'Notes')

@section('content')

    {{-- Filtres --}}
    <form method="GET" action="{{ route('notes.index') }}" class="flex items-center gap-3 mb-6">
        <select name="composition_id" onchange="this.form.submit()"
            class="border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-white">
            <option value="">Tous les trimestres</option>
            @foreach($compositions as $comp)
                <option value="{{ $comp->id }}" {{ request('composition_id') == $comp->id ? 'selected' : '' }}>
                    {{ $comp->libelle }}
                </option>
            @endforeach
        </select>
        <select name="matiere_id" onchange="this.form.submit()"
            class="border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-white">
            <option value="">Toutes les matières</option>
            @foreach($matieres as $mat)
                <option value="{{ $mat->id }}" {{ request('matiere_id') == $mat->id ? 'selected' : '' }}>
                    {{ $mat->nom }}
                </option>
            @endforeach
        </select>
        <a href="{{ route('notes.index') }}" class="px-4 py-2.5 border border-border rounded-xl text-sm text-text-muted hover:bg-primary-bg hover:text-primary transition-colors">
            Réinitialiser
        </a>
    </form>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide font-medium">Total notes</p>
                <p class="text-2xl font-bold text-text-dark">{{ $notes->total() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide font-medium">Moyenne générale</p>
                <p class="text-2xl font-bold text-text-dark">{{ $moyenneGenerale }}/10</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide font-medium">Matières notées</p>
                <p class="text-2xl font-bold text-text-dark">{{ $matieres->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-border">
            <h3 class="text-text-dark font-semibold text-sm">Toutes les notes saisies</h3>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-primary-bg">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Matière</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Trimestre</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Note</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Sur</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Sur 10</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Appréciation</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($notes as $note)
                @php
                    $initiales = strtoupper(substr($note->eleve->prenom, 0, 1) . substr($note->eleve->nom, 0, 1));
                    $couleurs = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                    $couleur = $couleurs[$note->eleve->id % count($couleurs)];
                    $noteRamenee = $note->note * 10 / $note->matiere->note_sur;

                    if ($noteRamenee >= 9.5)     { $appColor = 'text-green-700 bg-green-50';   $appText = 'Excellent'; }
                    elseif ($noteRamenee >= 8)   { $appColor = 'text-blue-700 bg-blue-50';     $appText = 'Très Bien'; }
                    elseif ($noteRamenee >= 7)   { $appColor = 'text-indigo-700 bg-indigo-50'; $appText = 'Bien'; }
                    elseif ($noteRamenee >= 6)   { $appColor = 'text-purple-700 bg-purple-50'; $appText = 'Assez Bien'; }
                    elseif ($noteRamenee >= 5)   { $appColor = 'text-amber-700 bg-amber-50';   $appText = 'Passable'; }
                    else                         { $appColor = 'text-red-700 bg-red-50';       $appText = 'Insuffisant'; }
                @endphp
                <tr class="hover:bg-bg-page transition-colors">
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ $initiales }}
                            </div>
                            <span class="text-sm font-medium text-text-dark">{{ $note->eleve->prenom }} {{ $note->eleve->nom }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-3 text-sm text-text-muted">{{ $note->matiere->nom }}</td>
                    <td class="px-6 py-3">
                        <span class="text-xs font-semibold bg-primary-bg text-primary px-2.5 py-1 rounded-full">
                            T{{ $note->composition->trimestre }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-center font-bold text-primary">{{ $note->note }}</td>
                    <td class="px-6 py-3 text-center text-text-muted">{{ $note->matiere->note_sur }}</td>
                    <td class="px-6 py-3 text-center font-bold text-primary">{{ number_format($noteRamenee, 2) }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $appColor }}">{{ $appText }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-text-muted">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <p class="font-medium">Aucune note trouvée</p>
                        <p class="text-sm mt-1">Saisissez des notes depuis la page Compositions</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($notes->hasPages())
        <div class="flex items-center justify-between px-6 py-4 border-t border-border">
            <p class="text-sm text-text-muted">
                Affichage de <b>{{ $notes->firstItem() }} à {{ $notes->lastItem() }}</b> sur <b>{{ $notes->total() }}</b> notes
            </p>
            {{ $notes->links() }}
        </div>
        @endif

    </div>

@endsection