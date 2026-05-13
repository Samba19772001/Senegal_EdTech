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

    {{-- Cards trimestres --}}
    <div class="grid grid-cols-3 gap-5 mb-8">

        {{-- Trimestre 1 --}}
        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="bg-primary px-5 py-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-blue-200 uppercase tracking-widest">Trimestre 1</span>
                    <span class="text-xs font-semibold bg-green-400 text-white px-2.5 py-1 rounded-full">Terminé</span>
                </div>
                <h3 class="text-white font-bold text-lg mt-1">Composition T1</h3>
                <p class="text-blue-200 text-xs mt-1">15 Octobre 2024</p>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">Élèves évalués</span>
                    <span class="font-semibold text-text-dark">42 / 42</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">Matières saisies</span>
                    <span class="font-semibold text-text-dark">6 / 6</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">Moyenne classe</span>
                    <span class="font-semibold text-green-600">7.8 / 10</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: 100%"></div>
                </div>
            </div>
            <div class="px-5 pb-4 flex gap-2">
                <a href="#" class="flex-1 text-center border border-border text-text-muted py-2 rounded-xl text-xs font-medium hover:bg-primary-bg hover:text-primary transition-colors">
                    Voir notes
                </a>
                <a href="#" class="flex-1 text-center bg-primary text-white py-2 rounded-xl text-xs font-medium hover:bg-primary-light transition-colors">
                    Bulletins PDF
                </a>
            </div>
        </div>

        {{-- Trimestre 2 --}}
        <div class="bg-white rounded-2xl border border-primary shadow-md overflow-hidden">
            <div class="bg-primary px-5 py-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-blue-200 uppercase tracking-widest">Trimestre 2</span>
                    <span class="text-xs font-semibold bg-amber-400 text-white px-2.5 py-1 rounded-full">En cours</span>
                </div>
                <h3 class="text-white font-bold text-lg mt-1">Composition T2</h3>
                <p class="text-blue-200 text-xs mt-1">20 Janvier 2025</p>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">Élèves évalués</span>
                    <span class="font-semibold text-text-dark">42 / 42</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">Matières saisies</span>
                    <span class="font-semibold text-amber-600">4 / 6</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">Moyenne classe</span>
                    <span class="font-semibold text-amber-600">En attente</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1">
                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: 66%"></div>
                </div>
            </div>
            <div class="px-5 pb-4 flex gap-2">
                <a href="#" class="flex-1 text-center border border-primary text-primary py-2 rounded-xl text-xs font-medium hover:bg-primary-bg transition-colors">
                    Saisir notes
                </a>
                <a href="#" class="flex-1 text-center bg-gray-100 text-text-muted py-2 rounded-xl text-xs font-medium cursor-not-allowed">
                    Bulletins PDF
                </a>
            </div>
        </div>

        {{-- Trimestre 3 --}}
        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="bg-gray-400 px-5 py-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-200 uppercase tracking-widest">Trimestre 3</span>
                    <span class="text-xs font-semibold bg-gray-500 text-white px-2.5 py-1 rounded-full">À venir</span>
                </div>
                <h3 class="text-white font-bold text-lg mt-1">Composition T3</h3>
                <p class="text-gray-200 text-xs mt-1">Non planifiée</p>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">Élèves évalués</span>
                    <span class="font-semibold text-gray-400">— / 42</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">Matières saisies</span>
                    <span class="font-semibold text-gray-400">0 / 6</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">Moyenne classe</span>
                    <span class="font-semibold text-gray-400">—</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1">
                    <div class="bg-gray-300 h-1.5 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <div class="px-5 pb-4 flex gap-2">
                <a href="#" class="flex-1 text-center border border-border text-text-muted py-2 rounded-xl text-xs font-medium hover:bg-primary-bg hover:text-primary transition-colors">
                    Créer
                </a>
                <a href="#" class="flex-1 text-center bg-gray-100 text-text-muted py-2 rounded-xl text-xs font-medium cursor-not-allowed">
                    Bulletins PDF
                </a>
            </div>
        </div>

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
            <form class="px-6 py-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Trimestre</label>
                    <select name="trimestre" class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                        <option value="">Sélectionner...</option>
                        <option value="1">Trimestre 1</option>
                        <option value="2">Trimestre 2</option>
                        <option value="3">Trimestre 3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Libellé</label>
                    <input type="text" name="libelle" placeholder="Ex: Composition T1"
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
        const modal = document.getElementById('modalAjout');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function fermerModal() {
        const modal = document.getElementById('modalAjout');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush