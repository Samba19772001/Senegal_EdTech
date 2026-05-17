@extends('layouts.app')

@section('title', 'Paramètres — Senegal EdTech')
@section('page_label', 'CONFIGURATION')
@section('page_title', 'Paramètres')

@section('content')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl mb-6">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-2 gap-6">

        {{-- Formulaire nouvelle année --}}
        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
            <div class="bg-primary px-6 py-4">
                <h3 class="text-white font-semibold text-base">Nouvelle année scolaire</h3>
                <p class="text-blue-200 text-xs mt-0.5">Changez l'année scolaire et la classe</p>
            </div>
            <div class="px-6 py-6 space-y-4">

                <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs text-amber-700">
                        <b>Attention !</b> Les notes et bulletins seront supprimés.
                        Vous choisirez si vous voulez garder vos élèves.
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Année scolaire actuelle
                    </label>
                    <div class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-muted bg-gray-50">
                        {{ auth()->user()->annee_scolaire }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Nouvelle année scolaire <span class="text-red-400">*</span>
                    </label>
                    @php
                        $parts = explode('-', auth()->user()->annee_scolaire);
                        $anneeSuivante = ($parts[0]+1).'-'.($parts[1]+1);
                    @endphp
                    <input type="text" id="input-annee"
                        value="{{ $anneeSuivante }}"
                        placeholder="Ex: 2026-2027"
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                    <p class="text-xs text-text-muted mt-1">Format : AAAA-AAAA</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Niveau actuel
                    </label>
                    <div class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-muted bg-gray-50">
                        {{ auth()->user()->niveau_enseignement }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Nouveau niveau <span class="text-red-400">*</span>
                    </label>
                    <select id="input-niveau"
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                        <option value="">Sélectionner...</option>
                        @foreach(['CI','CP','CE1','CE2','CM1','CM2'] as $niv)
                            <option value="{{ $niv }}">{{ $niv }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Nom de la nouvelle classe <span class="text-red-400">*</span>
                    </label>
                    <input type="text" id="input-classe"
                        value="{{ $classe->nom ?? '' }}"
                        placeholder="Ex: CE1 A"
                        class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                </div>

                <button type="button" onclick="ouvrirModal()"
                    class="w-full bg-primary hover:bg-primary-light text-white py-3 rounded-xl text-sm font-medium transition-colors">
                    Démarrer la nouvelle année →
                </button>
            </div>
        </div>

        {{-- Infos & historique --}}
        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-border shadow-sm p-6">
                <h3 class="font-bold text-base text-text-dark mb-4">Année scolaire en cours</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-border">
                        <span class="text-sm text-text-muted">Année scolaire</span>
                        <span class="text-sm font-bold text-primary">{{ auth()->user()->annee_scolaire }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-border">
                        <span class="text-sm text-text-muted">Niveau</span>
                        <span class="text-sm font-bold text-primary">{{ auth()->user()->niveau_enseignement }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-border">
                        <span class="text-sm text-text-muted">Classe</span>
                        <span class="text-sm font-bold text-primary">{{ $classe->nom ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-border">
                        <span class="text-sm text-text-muted">Élèves</span>
                        <span class="text-sm font-bold text-primary">{{ $stats['eleves'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-border">
                        <span class="text-sm text-text-muted">Notes saisies</span>
                        <span class="text-sm font-bold text-primary">{{ $stats['notes'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-text-muted">Bulletins générés</span>
                        <span class="text-sm font-bold text-primary">{{ $stats['bulletins'] }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-border shadow-sm p-6">
                <h3 class="font-bold text-base text-text-dark mb-4">Historique des classes</h3>
                @php
                    $classes = auth()->user()->classes()->orderByDesc('created_at')->get();
                @endphp
                @forelse($classes as $c)
                <div class="flex items-center justify-between py-2 border-b border-border last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary-bg rounded-lg flex items-center justify-center">
                            <span class="text-xs font-bold text-primary">{{ substr($c->nom, 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-text-dark">{{ $c->nom }}</p>
                            <p class="text-xs text-text-muted">{{ $c->annee_scolaire }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-text-muted">{{ $c->eleves->count() }} élèves</p>
                        @if($c->annee_scolaire == auth()->user()->annee_scolaire)
                            <span class="text-xs font-semibold bg-green-50 text-green-700 px-2 py-0.5 rounded-full">En cours</span>
                        @else
                            <span class="text-xs font-semibold bg-gray-50 text-gray-500 px-2 py-0.5 rounded-full">Archivée</span>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-sm text-text-muted text-center py-4">Aucune classe trouvée</p>
                @endforelse
            </div>

        </div>
    </div>

    {{-- Modal confirmation --}}
    <div id="modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">

            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-text-dark">Confirmer la nouvelle année</h3>
                    <p class="text-xs text-text-muted mt-0.5">Notes et bulletins seront supprimés</p>
                </div>
            </div>

            <p class="text-sm text-text-dark mb-4">
                Que faire avec la <strong>liste des élèves</strong> actuels ?
            </p>

            <div class="space-y-2 mb-6">
                <label class="flex items-start gap-3 p-3 border border-border rounded-xl cursor-pointer hover:bg-bg-page transition-colors">
                    <input type="radio" name="choix_eleves" value="non" class="mt-0.5 accent-primary" checked/>
                    <div>
                        <p class="text-sm font-semibold text-text-dark">Conserver les élèves</p>
                        <p class="text-xs text-text-muted">La liste reste, seules les notes sont effacées</p>
                    </div>
                </label>
                <label class="flex items-start gap-3 p-3 border border-red-200 rounded-xl cursor-pointer hover:bg-red-50 transition-colors">
                    <input type="radio" name="choix_eleves" value="oui" class="mt-0.5 accent-red-500"/>
                    <div>
                        <p class="text-sm font-semibold text-red-700">Supprimer les élèves</p>
                        <p class="text-xs text-red-400">Tous les élèves seront supprimés définitivement</p>
                    </div>
                </label>
            </div>

            {{-- Formulaire soumis par JS --}}
            <form id="formNouvelleAnnee" method="POST" action="{{ route('parametres.update') }}">
                @csrf @method('PUT')
                <input type="hidden" id="form-annee"   name="annee_scolaire"/>
                <input type="hidden" id="form-niveau"  name="niveau_enseignement"/>
                <input type="hidden" id="form-classe"  name="classe_nom"/>
                <input type="hidden" id="form-eleves"  name="supprimer_eleves"/>
            </form>

            <div class="flex gap-3">
                <button type="button" onclick="fermerModal()"
                    class="flex-1 py-2.5 border border-border text-text-muted rounded-xl text-sm hover:bg-bg-page transition-colors">
                    Annuler
                </button>
                <button type="button" onclick="confirmer()"
                    class="flex-1 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-semibold transition-colors">
                    Confirmer et démarrer
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function ouvrirModal() {
        const annee  = document.getElementById('input-annee').value.trim();
        const niveau = document.getElementById('input-niveau').value;
        const classe = document.getElementById('input-classe').value.trim();

        if (!annee || !niveau || !classe) {
            alert('Veuillez remplir tous les champs.');
            return;
        }
        if (!/^\d{4}-\d{4}$/.test(annee)) {
            alert('Format année invalide. Exemple : 2026-2027');
            return;
        }

        document.getElementById('modal').classList.remove('hidden');
    }

    function fermerModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    function confirmer() {
        document.getElementById('form-annee').value  = document.getElementById('input-annee').value.trim();
        document.getElementById('form-niveau').value = document.getElementById('input-niveau').value;
        document.getElementById('form-classe').value = document.getElementById('input-classe').value.trim();
        document.getElementById('form-eleves').value = document.querySelector('input[name="choix_eleves"]:checked').value;
        document.getElementById('formNouvelleAnnee').submit();
    }
</script>
@endpush