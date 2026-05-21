@extends('layouts.app')

@section('title', 'Profil — Senegal EdTech')
@section('page_label', 'MON COMPTE')
@section('page_title', 'Profil')

@section('content')

    @if(session('status') === 'profile-updated')
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-6">
            Profil mis à jour avec succès !
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Carte profil --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-border shadow-sm p-6 text-center">
                <div class="w-20 h-20 rounded-2xl bg-primary flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 ring-4 ring-blue-100">
                    {{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                </div>
                <h3 class="text-text-dark font-bold text-lg">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</h3>
                <p class="text-text-muted text-sm mt-1">{{ auth()->user()->nom_ecole }}</p>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center justify-between bg-bg-page rounded-xl px-4 py-2.5">
                        <span class="text-xs text-text-muted">Niveau</span>
                        <span class="text-xs font-bold text-primary">{{ auth()->user()->niveau_enseignement }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-bg-page rounded-xl px-4 py-2.5">
                        <span class="text-xs text-text-muted">Année scolaire</span>
                        <span class="text-xs font-bold text-primary">{{ auth()->user()->annee_scolaire }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-bg-page rounded-xl px-4 py-2.5">
                        <span class="text-xs text-text-muted">Type d'école</span>
                        <span class="text-xs font-bold text-primary">{{ ucfirst(auth()->user()->type_ecole) }}</span>
                    </div>
                    <div class="flex items-center justify-between bg-bg-page rounded-xl px-4 py-2.5">
                        <span class="text-xs text-text-muted">Région</span>
                        <span class="text-xs font-bold text-primary">{{ auth()->user()->region }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaires --}}
        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="bg-primary px-6 py-4">
                    <h3 class="text-white font-semibold text-base">Informations personnelles</h3>
                    <p class="text-blue-200 text-xs mt-0.5">Modifiez vos informations de base</p>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" class="px-4 lg:px-6 py-6 space-y-4">
                    @csrf @method('PATCH')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Nom</label>
                            <input type="text" name="nom" value="{{ auth()->user()->nom }}"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Prénom</label>
                            <input type="text" name="prenom" value="{{ auth()->user()->prenom }}"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Téléphone</label>
                            <input type="tel" name="telephone" value="{{ auth()->user()->telephone }}"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="bg-primary px-6 py-4">
                    <h3 class="text-white font-semibold text-base">Informations professionnelles</h3>
                    <p class="text-blue-200 text-xs mt-0.5">Informations de votre école</p>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" class="px-4 lg:px-6 py-6 space-y-4">
                    @csrf @method('PATCH')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Nom de l'école</label>
                            <input type="text" name="nom_ecole" value="{{ auth()->user()->nom_ecole }}"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Type d'école</label>
                            <select name="type_ecole" class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                                <option value="publique" {{ auth()->user()->type_ecole == 'publique' ? 'selected' : '' }}>Publique</option>
                                <option value="privee" {{ auth()->user()->type_ecole == 'privee' ? 'selected' : '' }}>Privée</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Région</label>
                            <select name="region" class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page">
                                @foreach(['Dakar','Thiès','Saint-Louis','Ziguinchor','Kaolack','Diourbel','Fatick','Kolda','Tambacounda','Louga','Matam','Kaffrine','Kédougou','Sédhiou'] as $region)
                                    <option value="{{ $region }}" {{ auth()->user()->region == $region ? 'selected' : '' }}>{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Département</label>
                            <input type="text" name="departement" value="{{ auth()->user()->departement }}"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Commune</label>
                            <input type="text" name="commune" value="{{ auth()->user()->commune }}"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="bg-primary px-6 py-4">
                    <h3 class="text-white font-semibold text-base">Changer le mot de passe</h3>
                    <p class="text-blue-200 text-xs mt-0.5">Assurez-vous d'utiliser un mot de passe sécurisé</p>
                </div>
                <form method="POST" action="{{ route('password.update') }}" class="px-4 lg:px-6 py-6 space-y-4">
                    @csrf @method('PUT')
                    @if($errors->updatePassword->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
                            {{ $errors->updatePassword->first() }}
                        </div>
                    @endif
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Mot de passe actuel</label>
                        <input type="password" name="current_password"
                            class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Nouveau mot de passe</label>
                            <input type="password" name="password"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Confirmer</label>
                            <input type="password" name="password_confirmation"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection