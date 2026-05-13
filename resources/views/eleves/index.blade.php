@extends('layouts.app')

@section('title', 'Élèves — Senegal EdTech')
@section('page_label', 'GESTION')
@section('page_title', 'Élèves')

@section('content')

    {{-- Barre d'actions --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-text-muted text-sm">Liste de tous vos élèves inscrits</p>
        <div class="flex items-center gap-3">
            <button onclick="ouvrirModalImport()"
                class="flex items-center gap-2 px-4 py-2.5 border border-border rounded-xl text-sm font-medium text-text-muted hover:bg-primary-bg hover:text-primary transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Importer Excel
            </button>
            <button onclick="ouvrirModal()"
                class="flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un élève
            </button>
        </div>
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

    {{-- Stats rapides --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide font-medium">Total élèves</p>
                <p class="text-2xl font-bold text-text-dark">{{ $eleves->total() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide font-medium">Garçons</p>
                <p class="text-2xl font-bold text-text-dark">{{ $totalGarcons }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide font-medium">Filles</p>
                <p class="text-2xl font-bold text-text-dark">{{ $totalFilles }}</p>
            </div>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">

        {{-- Filtres --}}
        <form method="GET" action="{{ route('eleves.index') }}"
            class="flex items-center justify-between px-6 py-4 border-b border-border gap-4">
            <div class="relative">
                <svg class="w-4 h-4 text-text-muted absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Rechercher un élève..."
                    class="pl-9 pr-4 py-2 border border-border rounded-xl text-sm bg-bg-page text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary w-64"/>
            </div>
            <div class="flex items-center gap-2">
                <select name="classe_id" class="border border-border rounded-xl px-3 py-2 text-sm text-text-muted bg-bg-page focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Toutes les classes</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
                <select name="sexe" class="border border-border rounded-xl px-3 py-2 text-sm text-text-muted bg-bg-page focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Tous les sexes</option>
                    <option value="M" {{ request('sexe') == 'M' ? 'selected' : '' }}>Garçons</option>
                    <option value="F" {{ request('sexe') == 'F' ? 'selected' : '' }}>Filles</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl text-sm font-medium hover:bg-primary-light transition-colors">
                    Filtrer
                </button>
            </div>
        </form>

        {{-- Table --}}
        <table class="w-full">
            <thead>
                <tr class="bg-primary-bg">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Matricule</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Classe</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Sexe</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Date de naissance</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($eleves as $eleve)
                @php
                    $initiales = strtoupper(substr($eleve->prenom, 0, 1) . substr($eleve->nom, 0, 1));
                    $couleurs = ['blue', 'pink', 'orange', 'purple', 'green', 'red', 'indigo', 'amber'];
                    $couleur = $couleurs[$eleve->id % count($couleurs)];
                @endphp
                <tr class="hover:bg-bg-page transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-{{ $couleur }}-100 text-{{ $couleur }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ $initiales }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-text-dark">{{ $eleve->prenom }} {{ $eleve->nom }}</p>
                                <p class="text-xs text-text-muted">Inscrit le {{ $eleve->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-text-muted font-mono">{{ $eleve->matricule ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm text-text-muted">{{ $eleve->classe->nom ?? '—' }}</td>
                    <td class="px-6 py-4">
                        @if($eleve->sexe == 'M')
                            <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Garçon</span>
                        @else
                            <span class="text-xs font-semibold bg-pink-50 text-pink-700 px-2.5 py-1 rounded-full">Fille</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-text-muted">
                        {{ $eleve->date_naissance ? \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') : '—' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button onclick="ouvrirModalEdit({{ $eleve->id }}, '{{ $eleve->nom }}', '{{ $eleve->prenom }}', '{{ $eleve->sexe }}', '{{ $eleve->date_naissance }}', '{{ $eleve->matricule }}')"
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
                        <p class="text-sm mt-1">Ajoutez votre premier élève en cliquant sur le bouton ci-dessus</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($eleves->hasPages())
        <div class="flex items-center justify-between px-6 py-4 border-t border-border">
            <p class="text-sm text-text-muted">
                Affichage de <b>{{ $eleves->firstItem() }} à {{ $eleves->lastItem() }}</b> sur <b>{{ $eleves->total() }}</b> élèves
            </p>
            {{ $eleves->links() }}
        </div>
        @endif
    </div>

    {{-- MODAL Ajouter --}}
    <div id="modalAjout" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black bg-opacity-40" onclick="fermerModal()"></div>
        <div class="relative bg-white rounded-2xl border border-border shadow-xl w-full max-w-lg mx-4 z-10">
            <div class="bg-primary px-6 py-5 rounded-t-2xl flex items-center justify-between">
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
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Classe</label>
                    <select name="classe_id" required class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                        <option value="">Sélectionner une classe...</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }} — {{ $classe->annee_scolaire }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
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
                </div>
                <div class="grid grid-cols-2 gap-4">
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
                        class="flex-1 border border-border text-text-muted py-2.5 rounded-xl text-sm font-medium hover:bg-bg-page transition-colors">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 bg-primary hover:bg-primary-light text-white py-2.5 rounded-xl text-sm font-medium transition-colors">
                        Ajouter l'élève
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL Import Excel --}}
    <div id="modalImport" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black bg-opacity-40" onclick="fermerModalImport()"></div>
        <div class="relative bg-white rounded-2xl border border-border shadow-xl w-full max-w-md mx-4 z-10">
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
                        <option value="">Sélectionner une classe...</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }} — {{ $classe->annee_scolaire }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Fichier Excel</label>
                    <input type="file" name="fichier" accept=".xlsx,.xls" required
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark bg-bg-page focus:outline-none focus:ring-2 focus:ring-primary"/>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="fermerModalImport()"
                        class="flex-1 border border-border text-text-muted py-2.5 rounded-xl text-sm font-medium hover:bg-bg-page transition-colors">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 bg-primary hover:bg-primary-light text-white py-2.5 rounded-xl text-sm font-medium transition-colors">
                        Importer
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
    function ouvrirModalImport() {
        document.getElementById('modalImport').classList.remove('hidden');
        document.getElementById('modalImport').classList.add('flex');
    }
    function fermerModalImport() {
        document.getElementById('modalImport').classList.add('hidden');
        document.getElementById('modalImport').classList.remove('flex');
    }
    function ouvrirModalEdit(id, nom, prenom, sexe, dob, matricule) {
        alert('Modifier : ' + prenom + ' ' + nom);
        // À implémenter
    }
</script>
@endpush