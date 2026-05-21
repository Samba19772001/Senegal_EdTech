@extends('layouts.app')

@section('title', 'Élèves — Senegal EdTech')
@section('page_label', 'GESTION')
@section('page_title', 'Élèves')

@section('content')

    {{-- Barre d'actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <p class="text-text-muted text-sm">Liste de tous vos élèves inscrits</p>
        <div class="flex flex-wrap items-center gap-2">
            <form method="POST" action="{{ route('eleves.destroyAll') }}"
                onsubmit="return confirm('⚠️ Ceci supprimera TOUS vos élèves. Continuer ?')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="flex items-center gap-2 px-3 py-2 border border-red-200 text-red-500 hover:bg-red-50 rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span class="hidden sm:inline">Effacer tous</span>
                </button>
            </form>
            <button onclick="ouvrirModalImport()"
                class="flex items-center gap-2 px-3 py-2 border border-border rounded-xl text-sm font-medium text-text-muted hover:bg-primary-bg hover:text-primary transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <span class="hidden sm:inline">Importer Excel</span>
            </button>
            <button onclick="ouvrirModal()"
                class="flex items-center gap-2 px-3 py-2 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="hidden sm:inline">Ajouter un élève</span>
                <span class="sm:hidden">Ajouter</span>
            </button>
        </div>
    </div>

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

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-2 mb-6">
        <div class="bg-white rounded-xl border border-border p-2.5 flex flex-col items-center gap-1">
            <div class="w-8 h-8 bg-primary-bg rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-xs text-text-muted font-medium text-center">Total</p>
            <p class="text-lg font-bold text-text-dark">{{ $eleves->total() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-border p-2.5 flex flex-col items-center gap-1">
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <p class="text-xs text-text-muted font-medium text-center">Garçons</p>
            <p class="text-lg font-bold text-text-dark">{{ $totalGarcons }}</p>
        </div>
        <div class="bg-white rounded-xl border border-border p-2.5 flex flex-col items-center gap-1">
            <div class="w-8 h-8 bg-pink-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <p class="text-xs text-text-muted font-medium text-center">Filles</p>
            <p class="text-lg font-bold text-text-dark">{{ $totalFilles }}</p>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">

        {{-- Filtres --}}
        <form method="GET" action="{{ route('eleves.index') }}"
            class="flex flex-col px-4 lg:px-6 py-4 border-b border-border gap-2">
            <div class="relative">
                <svg class="w-4 h-4 text-text-muted absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                <input type="text"
                    id="searchInput"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Rechercher un élève..."
                    autocomplete="off"
                    class="pl-9 pr-4 py-2 border border-border rounded-xl text-sm bg-bg-page text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary w-full"/>

                <div id="suggestionsBox"
                    class="absolute z-50 w-full bg-white border border-border rounded-xl shadow-lg hidden max-h-60 overflow-auto">
                </div>
            </div>
            <div class="flex gap-2">
                <select name="classe_id" class="flex-1 border border-border rounded-xl px-3 py-2 text-sm text-text-muted bg-bg-page focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Toutes classes</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                    @endforeach
                </select>
                <select name="sexe" class="flex-1 border border-border rounded-xl px-3 py-2 text-sm text-text-muted bg-bg-page focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Tous</option>
                    <option value="M" {{ request('sexe') == 'M' ? 'selected' : '' }}>Garçons</option>
                    <option value="F" {{ request('sexe') == 'F' ? 'selected' : '' }}>Filles</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl text-sm font-medium hover:bg-primary-light transition-colors">
                    OK
                </button>
            </div>
        </form>

        {{-- Table --}}
        <table class="w-full">
            <thead>
                <tr class="bg-primary-bg">
                    <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden md:table-cell">Matricule</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden sm:table-cell">Classe</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Sexe</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest hidden lg:table-cell">Naissance</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($eleves as $eleve)
                @php
                    $initiales = strtoupper(substr($eleve->prenom, 0, 1) . substr($eleve->nom, 0, 1));
                    $couleurs  = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                    $couleur   = $couleurs[$eleve->id % count($couleurs)];
                @endphp
                <tr class="hover:bg-bg-page transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ $initiales }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-text-dark">{{ $eleve->prenom }} {{ $eleve->nom }}</p>
                                <p class="text-xs text-text-muted hidden sm:block">{{ $eleve->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-text-muted font-mono hidden md:table-cell">{{ $eleve->matricule ?? '—' }}</td>
                    <td class="px-4 py-3 text-sm text-text-muted hidden sm:table-cell">{{ $eleve->classe->nom ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @if($eleve->sexe == 'M')
                            <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2 py-1 rounded-full">M</span>
                        @else
                            <span class="text-xs font-semibold bg-pink-50 text-pink-700 px-2 py-1 rounded-full">F</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-text-muted hidden lg:table-cell">
                        {{ $eleve->date_naissance ? \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') : '—' }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-1.5">
                            <button onclick="ouvrirModalEdit({{ $eleve->id }}, '{{ addslashes($eleve->nom) }}', '{{ addslashes($eleve->prenom) }}', '{{ $eleve->sexe }}', '{{ $eleve->date_naissance }}', '{{ $eleve->matricule }}')"
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-border hover:bg-primary-bg hover:text-primary hover:border-primary transition-colors text-text-muted">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form method="POST" action="{{ route('eleves.destroy', $eleve->id) }}"
                                onsubmit="return confirm('Supprimer cet élève ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg border border-border hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition-colors text-text-muted">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-text-muted">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="font-medium">Aucun élève trouvé</p>
                        <p class="text-sm mt-1">Ajoutez votre premier élève</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($eleves->hasPages())
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-4 lg:px-6 py-4 border-t border-border gap-2">
            <p class="text-sm text-text-muted">
                {{ $eleves->firstItem() }} à {{ $eleves->lastItem() }} sur {{ $eleves->total() }} élèves
            </p>
            {{ $eleves->links() }}
        </div>
        @endif
    </div>

    {{-- MODAL Ajouter --}}
    <div id="modalAjout" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black bg-opacity-40" onclick="fermerModal()"></div>
        <div class="relative bg-white rounded-2xl border border-border shadow-xl w-full max-w-lg z-10 max-h-[90vh] overflow-y-auto">
            <div class="bg-primary px-6 py-5 rounded-t-2xl flex items-center justify-between sticky top-0 z-10">
                <div>
                    <h3 class="text-white font-semibold text-base">Ajouter un élève</h3>
                    <p class="text-blue-200 text-xs mt-0.5">Renseignez les informations de l'élève</p>
                </div>
                <button onclick="fermerModal()" class="text-blue-200 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('eleves.store') }}" class="px-6 py-6 space-y-4">
                @csrf
                @php $classeUser = auth()->user()->classes()->where('annee_scolaire', auth()->user()->annee_scolaire)->first(); @endphp
                @if($classeUser)
                    <input type="hidden" name="classe_id" value="{{ $classeUser->id }}">
                    <div class="bg-primary-bg rounded-xl px-4 py-3">
                        <p class="text-xs text-primary">Classe : <b>{{ $classeUser->nom }} — {{ $classeUser->annee_scolaire }}</b></p>
                    </div>
                @else
                    <div class="bg-red-50 rounded-xl px-4 py-3 text-xs text-red-600">Aucune classe trouvée.</div>
                @endif
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Nom</label>
                        <input type="text" name="nom" placeholder="Diallo" required
                            class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Prénom</label>
                        <input type="text" name="prenom" placeholder="Moussa" required
                            class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Sexe</label>
                        <select name="sexe" required class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                            <option value="">Sélectionner...</option>
                            <option value="M">Garçon</option>
                            <option value="F">Fille</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Date de naissance</label>
                        <input type="date" name="date_naissance"
                            class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Matricule <span class="text-gray-400 normal-case">(optionnel)</span></label>
                    <input type="text" name="matricule" placeholder="EL-2024-001"
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="fermerModal()"
                        class="flex-1 border border-border text-text-muted py-2.5 rounded-xl text-sm font-medium hover:bg-bg-page transition-colors">Annuler</button>
                    <button type="submit"
                        class="flex-1 bg-primary hover:bg-primary-light text-white py-2.5 rounded-xl text-sm font-medium transition-colors">Ajouter l'élève</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL Modifier --}}
    <div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black bg-opacity-40" onclick="fermerModalEdit()"></div>
        <div class="relative bg-white rounded-2xl border border-border shadow-xl w-full max-w-lg z-10 max-h-[90vh] overflow-y-auto">
            <div class="bg-primary px-6 py-5 rounded-t-2xl flex items-center justify-between sticky top-0 z-10">
                <div>
                    <h3 class="text-white font-semibold text-base">Modifier l'élève</h3>
                    <p class="text-blue-200 text-xs mt-0.5">Modifiez les informations</p>
                </div>
                <button onclick="fermerModalEdit()" class="text-blue-200 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form id="formEdit" method="POST" action="" class="px-6 py-6 space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Nom</label>
                        <input type="text" id="edit-nom" name="nom" required
                            class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Prénom</label>
                        <input type="text" id="edit-prenom" name="prenom" required
                            class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Sexe</label>
                        <select id="edit-sexe" name="sexe" required class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                            <option value="M">Garçon</option>
                            <option value="F">Fille</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Date de naissance</label>
                        <input type="date" id="edit-dob" name="date_naissance"
                            class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Matricule <span class="text-gray-400 normal-case">(optionnel)</span></label>
                    <input type="text" id="edit-matricule" name="matricule"
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="fermerModalEdit()"
                        class="flex-1 border border-border text-text-muted py-2.5 rounded-xl text-sm font-medium hover:bg-bg-page transition-colors">Annuler</button>
                    <button type="submit"
                        class="flex-1 bg-primary hover:bg-primary-light text-white py-2.5 rounded-xl text-sm font-medium transition-colors">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL Import --}}
    <div id="modalImport" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black bg-opacity-40" onclick="fermerModalImport()"></div>
        <div class="relative bg-white rounded-2xl border border-border shadow-xl w-full max-w-md z-10">
            <div class="bg-primary px-6 py-5 rounded-t-2xl flex items-center justify-between">
                <div>
                    <h3 class="text-white font-semibold text-base">Importer depuis Excel</h3>
                    <p class="text-blue-200 text-xs mt-0.5">Colonnes : nom | prenom | sexe | date_naissance | matricule</p>
                </div>
                <button onclick="fermerModalImport()" class="text-blue-200 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('eleves.import') }}" enctype="multipart/form-data" class="px-6 py-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Classe</label>
                    <select name="classe_id" required class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                        <option value="">Sélectionner...</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }} — {{ $classe->annee_scolaire }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Fichier Excel</label>
                    <input type="file" name="fichier" accept=".xlsx,.xls" required
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark bg-bg-page"/>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="fermerModalImport()"
                        class="flex-1 border border-border text-text-muted py-2.5 rounded-xl text-sm font-medium hover:bg-bg-page transition-colors">Annuler</button>
                    <button type="submit"
                        class="flex-1 bg-primary hover:bg-primary-light text-white py-2.5 rounded-xl text-sm font-medium transition-colors">Importer</button>
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
    function ouvrirModalImport() {
        document.getElementById('modalImport').classList.remove('hidden');
        document.getElementById('modalImport').classList.add('flex');
    }
    function fermerModalImport() {
        document.getElementById('modalImport').classList.add('hidden');
        document.getElementById('modalImport').classList.remove('flex');
    }
    function ouvrirModalEdit(id, nom, prenom, sexe, dob, matricule) {
        document.getElementById('edit-nom').value       = nom;
        document.getElementById('edit-prenom').value    = prenom;
        document.getElementById('edit-sexe').value      = sexe;
        document.getElementById('edit-dob').value       = dob;
        document.getElementById('edit-matricule').value = matricule;
        document.getElementById('formEdit').action      = `/eleves/${id}`;
        document.getElementById('modalEdit').classList.remove('hidden');
        document.getElementById('modalEdit').classList.add('flex');
    }
    function fermerModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
        document.getElementById('modalEdit').classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function () {

        const input = document.getElementById('searchInput');
        const box = document.getElementById('suggestionsBox');

        if (!input || !box) return;

        let timer = null;

        input.addEventListener('input', function () {

            clearTimeout(timer);

            const query = this.value.trim();

            if (query.length < 1) {
                box.classList.add('hidden');
                box.innerHTML = '';
                return;
            }

            timer = setTimeout(() => {

                fetch(`/eleves/suggestions?q=${encodeURIComponent(query)}`)
                    .then(async res => {

                        if (!res.ok) {
                            console.error('Erreur backend suggestions');
                            return [];
                        }

                        return await res.json();
                    })
                    .then(data => {

                        if (!Array.isArray(data)) return;

                        if (!data.length) {
                            box.classList.add('hidden');
                            return;
                        }

                        box.innerHTML = data.map(e => `
                            <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer suggestion-item">
                                ${e.prenom} ${e.nom}
                            </div>
                        `).join('');

                        box.classList.remove('hidden');
                    })
                    .catch(err => console.error(err));

            }, 250); // debounce
        });

        document.addEventListener('click', function (e) {
            if (!box.contains(e.target) && e.target !== input) {
                box.classList.add('hidden');
            }
        });
    });
</script>
@endpush