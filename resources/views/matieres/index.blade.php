@extends('layouts.app')

@section('title', 'Matières — Senegal EdTech')
@section('page_label', 'GESTION')
@section('page_title', 'Matières')

@section('content')

    {{-- Barre d'actions --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-text-muted text-sm">Gérez les matières de votre classe</p>
        <button onclick="ouvrirModal()"
            class="flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter une matière
        </button>
    </div>

    {{-- Info niveau --}}
    <div class="bg-primary-bg border border-blue-200 rounded-2xl px-5 py-4 mb-6 flex items-center gap-3">
        <svg class="w-5 h-5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm text-primary">
            Les matières ci-dessous sont configurées pour le niveau <b>CE1</b>.
            La moyenne est toujours calculée <b>sur 10</b> — chaque note est ramenée sur 10 avant le calcul.
        </p>
    </div>

    {{-- Grille matières --}}
    <div class="grid grid-cols-3 gap-4 mb-6">

        {{-- Matière prédéfinie --}}
        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm hover:border-primary hover:shadow-md transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Par défaut</span>
            </div>
            <h3 class="text-text-dark font-semibold text-base mb-1">Français</h3>
            <p class="text-text-muted text-xs mb-4">Notée sur <span class="font-bold text-primary">40</span> points</p>
            <div class="flex items-center justify-between pt-3 border-t border-border">
                <span class="text-xs text-text-muted">Note ramenée sur 10</span>
                <span class="text-xs font-bold text-green-600">× 10 ÷ 40</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm hover:border-primary hover:shadow-md transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Par défaut</span>
            </div>
            <h3 class="text-text-dark font-semibold text-base mb-1">Mathématiques</h3>
            <p class="text-text-muted text-xs mb-4">Notée sur <span class="font-bold text-primary">40</span> points</p>
            <div class="flex items-center justify-between pt-3 border-t border-border">
                <span class="text-xs text-text-muted">Note ramenée sur 10</span>
                <span class="text-xs font-bold text-green-600">× 10 ÷ 40</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm hover:border-primary hover:shadow-md transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Par défaut</span>
            </div>
            <h3 class="text-text-dark font-semibold text-base mb-1">Histoire-Géographie</h3>
            <p class="text-text-muted text-xs mb-4">Notée sur <span class="font-bold text-primary">20</span> points</p>
            <div class="flex items-center justify-between pt-3 border-t border-border">
                <span class="text-xs text-text-muted">Note ramenée sur 10</span>
                <span class="text-xs font-bold text-green-600">× 10 ÷ 20</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm hover:border-primary hover:shadow-md transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Par défaut</span>
            </div>
            <h3 class="text-text-dark font-semibold text-base mb-1">Sciences</h3>
            <p class="text-text-muted text-xs mb-4">Notée sur <span class="font-bold text-primary">20</span> points</p>
            <div class="flex items-center justify-between pt-3 border-t border-border">
                <span class="text-xs text-text-muted">Note ramenée sur 10</span>
                <span class="text-xs font-bold text-green-600">× 10 ÷ 20</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm hover:border-primary hover:shadow-md transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Par défaut</span>
            </div>
            <h3 class="text-text-dark font-semibold text-base mb-1">Éducation Civique</h3>
            <p class="text-text-muted text-xs mb-4">Notée sur <span class="font-bold text-primary">10</span> points</p>
            <div class="flex items-center justify-between pt-3 border-t border-border">
                <span class="text-xs text-text-muted">Note ramenée sur 10</span>
                <span class="text-xs font-bold text-green-600">× 10 ÷ 10</span>
            </div>
        </div>

        {{-- Matière custom (ajoutée par l'enseignant) --}}
        <div class="bg-white rounded-2xl border border-amber-200 p-5 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-semibold bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full">Personnalisée</span>
                    <button class="w-7 h-7 flex items-center justify-center rounded-lg border border-border hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition-colors text-text-muted">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            <h3 class="text-text-dark font-semibold text-base mb-1">Anglais</h3>
            <p class="text-text-muted text-xs mb-4">Notée sur <span class="font-bold text-amber-600">20</span> points</p>
            <div class="flex items-center justify-between pt-3 border-t border-border">
                <span class="text-xs text-text-muted">Note ramenée sur 10</span>
                <span class="text-xs font-bold text-green-600">× 10 ÷ 20</span>
            </div>
        </div>

    </div>

    {{-- MODAL Ajouter une matière --}}
    <div id="modalAjout" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black bg-opacity-40" onclick="fermerModal()"></div>
        <div class="relative bg-white rounded-2xl border border-border shadow-xl w-full max-w-md mx-4 z-10">

            <div class="bg-primary px-6 py-5 rounded-t-2xl flex items-center justify-between">
                <div>
                    <h3 class="text-white font-semibold text-base">Ajouter une matière</h3>
                    <p class="text-blue-200 text-xs mt-0.5">Cette matière sera ajoutée à votre classe</p>
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
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Nom de la matière</label>
                    <input type="text" name="nom" placeholder="Ex: Arabe, Informatique..."
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                </div>
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Notée sur</label>
                    <select name="note_sur" class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                        <option value="">Sélectionner...</option>
                        <option value="10">10 points</option>
                        <option value="20">20 points</option>
                        <option value="24">24 points</option>
                        <option value="40">40 points</option>
                        <option value="60">60 points</option>
                    </select>
                </div>
                <div class="bg-primary-bg rounded-xl px-4 py-3 flex items-start gap-2">
                    <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs text-primary">La note sera automatiquement ramenée sur 10 lors du calcul de la moyenne.</p>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="fermerModal()"
                        class="flex-1 border border-border text-text-muted py-2.5 rounded-xl text-sm font-medium hover:bg-bg-page transition-colors">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 bg-primary hover:bg-primary-light text-white py-2.5 rounded-xl text-sm font-medium transition-colors">
                        Ajouter
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