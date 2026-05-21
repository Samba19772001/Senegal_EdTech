@extends('layouts.app')

@section('title', 'Notes — Senegal EdTech')
@section('page_label', 'GESTION')
@section('page_title', 'Notes')

@section('content')

    {{-- Filtres --}}
    <form method="GET" action="{{ route('notes.index') }}" class="mb-6">
        <div class="flex flex-wrap gap-2">
            <select name="composition_id" onchange="this.form.submit()"
                class="flex-1 min-w-0 border border-border rounded-xl px-3 py-2 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-white">
                <option value="">Tous les trimestres</option>
                @foreach($compositions as $comp)
                    <option value="{{ $comp->id }}" {{ request('composition_id') == $comp->id ? 'selected' : '' }}>
                        {{ $comp->libelle }}
                    </option>
                @endforeach
            </select>
            <select name="matiere_id" onchange="this.form.submit()"
                class="flex-1 min-w-0 border border-border rounded-xl px-3 py-2 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-white">
                <option value="">Toutes les matières</option>
                @foreach($matieres as $mat)
                    <option value="{{ $mat->id }}" {{ request('matiere_id') == $mat->id ? 'selected' : '' }}>
                        {{ $mat->nom }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('notes.index') }}"
                class="px-3 py-2 border border-border rounded-xl text-sm text-text-muted hover:bg-primary-bg hover:text-primary transition-colors whitespace-nowrap">
                ✕
            </a>
        </div>
    </form>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-2 mb-6">
        <div class="bg-white rounded-xl border border-border p-2.5 flex flex-col items-center gap-1">
            <div class="w-8 h-8 bg-primary-bg rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <p class="text-xs text-text-muted font-medium text-center leading-tight">Total</p>
            <p class="text-lg font-bold text-text-dark">{{ $notes->total() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-border p-2.5 flex flex-col items-center gap-1">
            <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <p class="text-xs text-text-muted font-medium text-center leading-tight">Moy.</p>
            <p class="text-lg font-bold text-text-dark">{{ $moyenneGenerale }}/10</p>
        </div>
        <div class="bg-white rounded-xl border border-border p-2.5 flex flex-col items-center gap-1">
            <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-xs text-text-muted font-medium text-center leading-tight">Matières</p>
            <p class="text-lg font-bold text-text-dark">{{ $matieres->count() }}</p>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-border">
            <h3 class="text-text-dark font-semibold text-sm">Toutes les notes saisies</h3>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-primary-bg">
                    <th class="text-left px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                    <th class="text-left px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden sm:table-cell">Matière</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden sm:table-cell">T</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Note</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden md:table-cell">Sur</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden md:table-cell">/10</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden lg:table-cell">Appréciation</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($notes as $note)
                @php
                    $initiales   = strtoupper(substr($note->eleve->prenom, 0, 1) . substr($note->eleve->nom, 0, 1));
                    $couleurs    = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                    $couleur     = $couleurs[$note->eleve->id % count($couleurs)];
                    $noteRamenee = $note->note * 10 / $note->matiere->note_sur;

                    if ($noteRamenee >= 9.5)     { $appColor = 'text-green-700 bg-green-50';   $appText = 'Excellent'; }
                    elseif ($noteRamenee >= 8)   { $appColor = 'text-blue-700 bg-blue-50';     $appText = 'Très Bien'; }
                    elseif ($noteRamenee >= 7)   { $appColor = 'text-indigo-700 bg-indigo-50'; $appText = 'Bien'; }
                    elseif ($noteRamenee >= 6)   { $appColor = 'text-purple-700 bg-purple-50'; $appText = 'Assez Bien'; }
                    elseif ($noteRamenee >= 5)   { $appColor = 'text-amber-700 bg-amber-50';   $appText = 'Passable'; }
                    else                         { $appColor = 'text-red-700 bg-red-50';       $appText = 'Insuffisant'; }
                @endphp
                <tr class="hover:bg-bg-page transition-colors">
                    <td class="px-3 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ $initiales }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-text-dark truncate">{{ $note->eleve->prenom }} {{ $note->eleve->nom }}</p>
                                <p class="text-xs text-text-muted sm:hidden truncate">{{ $note->matiere->nom }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-3 text-sm text-text-muted hidden sm:table-cell">{{ $note->matiere->nom }}</td>
                    <td class="px-3 py-3 text-center hidden sm:table-cell">
                        <span class="text-xs font-semibold bg-primary-bg text-primary px-2 py-1 rounded-full">
                            T{{ $note->composition->trimestre }}
                        </span>
                    </td>
                    <td class="px-3 py-3 text-center font-bold text-primary text-sm">{{ $note->note }}</td>
                    <td class="px-3 py-3 text-center text-text-muted text-sm hidden md:table-cell">{{ $note->matiere->note_sur }}</td>
                    <td class="px-3 py-3 text-center font-bold text-primary text-sm hidden md:table-cell">{{ number_format($noteRamenee, 2) }}</td>
                    <td class="px-3 py-3 text-center hidden lg:table-cell">
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

        @if($notes->hasPages())
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-4 py-4 border-t border-border gap-2">
            <p class="text-sm text-text-muted">
                <b>{{ $notes->firstItem() }} à {{ $notes->lastItem() }}</b> sur <b>{{ $notes->total() }}</b> notes
            </p>
            {{ $notes->links() }}
        </div>
        @endif
    </div>

@endsection