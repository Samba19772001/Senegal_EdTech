@extends('layouts.app')

@section('title', 'Dashboard — Senegal EdTech')
@section('page_label', 'TABLEAU DE BORD')
@section('page_title', 'Bienvenue')

@section('content')

    {{-- Stat Cards --}}
    <div class="grid grid-cols-4 gap-5 mb-8">

        {{-- Élèves --}}
        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-xs text-text-muted uppercase tracking-widest font-medium mb-1">Nombre d'élèves</p>
            <p class="text-3xl font-bold text-text-dark">{{ $totalEleves }}</p>
        </div>

        {{-- Matières --}}
        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Actif</span>
            </div>
            <p class="text-xs text-text-muted uppercase tracking-widest font-medium mb-1">Nombre de matières</p>
            <p class="text-3xl font-bold text-text-dark">{{ $totalMatieres }}</p>
        </div>

        {{-- Notes --}}
        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-xs text-text-muted uppercase tracking-widest font-medium mb-1">Notes enregistrées</p>
            <p class="text-3xl font-bold text-text-dark">{{ $totalNotes }}</p>
        </div>

        {{-- Bulletins --}}
        <div class="bg-white rounded-2xl border border-border p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-primary-bg rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-xs text-text-muted uppercase tracking-widest font-medium mb-1">Bulletins générés</p>
            <p class="text-3xl font-bold text-text-dark">{{ $totalBulletins }}</p>
        </div>

    </div>        

    {{-- Actions Rapides + Activités --}}
    <div class="grid grid-cols-3 gap-5">

        {{-- Gauche : Actions + Activités --}}
        <div class="col-span-2 space-y-5">

            {{-- Actions Rapides --}}
            <div class="bg-white rounded-2xl border border-border p-6 shadow-sm">
                <h2 class="text-base font-bold text-text-dark mb-4">Actions Rapides</h2>
                <div class="grid grid-cols-2 gap-3">

                    <a href="#" class="flex items-center justify-between bg-primary hover:bg-primary-light text-white px-5 py-4 rounded-xl transition-colors duration-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-sm">Ajouter élèves</p>
                                <p class="text-xs text-blue-200">Inscrire manuellement</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <a href="#" class="flex items-center justify-between bg-white hover:bg-primary-bg border border-border text-text-dark px-5 py-4 rounded-xl transition-colors duration-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-sm">Importer Excel</p>
                                <p class="text-xs text-text-muted">Chargement par lot</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <a href="#" class="flex items-center justify-between bg-white hover:bg-primary-bg border border-border text-text-dark px-5 py-4 rounded-xl transition-colors duration-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-sm">Saisir notes</p>
                                <p class="text-xs text-text-muted">Entrée rapide par classe</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <a href="#" class="flex items-center justify-between bg-white hover:bg-primary-bg border border-border text-text-dark px-5 py-4 rounded-xl transition-colors duration-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-sm">Générer bulletins</p>
                                <p class="text-xs text-text-muted">Exportation PDF groupée</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                </div>
            </div>

            {{-- Dernières Activités --}}
            <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-border">
                    <h2 class="text-base font-bold text-text-dark">Dernières Activités</h2>
                    <a href="#" class="text-sm text-primary font-medium hover:underline">Voir tout</a>
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="bg-primary-bg">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Matière</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Type</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Note</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        <tr class="hover:bg-bg-page transition-colors">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center">MS</div>
                                    <span class="text-sm font-medium text-text-dark">Moussa Sow</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-sm text-text-muted">Mathématiques</td>
                            <td class="px-6 py-3.5">
                                <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Composition</span>
                            </td>
                            <td class="px-6 py-3.5 text-sm font-bold text-primary">16/20</td>
                        </tr>
                        <tr class="hover:bg-bg-page transition-colors">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 text-xs font-bold flex items-center justify-center">AF</div>
                                    <span class="text-sm font-medium text-text-dark">Awa Fall</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-sm text-text-muted">Français</td>
                            <td class="px-6 py-3.5">
                                <span class="text-xs font-semibold bg-green-50 text-green-700 px-2.5 py-1 rounded-full">Composition</span>
                            </td>
                            <td class="px-6 py-3.5 text-sm font-bold text-primary">14.5/20</td>
                        </tr>
                        <tr class="hover:bg-bg-page transition-colors">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-700 text-xs font-bold flex items-center justify-center">ID</div>
                                    <span class="text-sm font-medium text-text-dark">Ibrahim Diallo</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-sm text-text-muted">Histoire-Géo</td>
                            <td class="px-6 py-3.5">
                                <span class="text-xs font-semibold bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full">Composition</span>
                            </td>
                            <td class="px-6 py-3.5 text-sm font-bold text-primary">18/20</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Droite : Performance + Présence --}}
        <div class="space-y-5">

            {{-- Performance --}}
            <div class="bg-primary rounded-2xl p-6 text-white shadow-sm">
                <h3 class="font-bold text-base mb-1">Performance Globale</h3>
                <p class="text-blue-200 text-xs mb-5">Moyenne de classe en hausse de 1.2 points par rapport au trimestre précédent.</p>
                <div class="flex items-end gap-1.5 h-20">
                    <div class="flex-1 bg-blue-400 bg-opacity-50 rounded-t-md" style="height: 40%"></div>
                    <div class="flex-1 bg-blue-400 bg-opacity-50 rounded-t-md" style="height: 55%"></div>
                    <div class="flex-1 bg-blue-400 bg-opacity-50 rounded-t-md" style="height: 45%"></div>
                    <div class="flex-1 bg-blue-400 bg-opacity-50 rounded-t-md" style="height: 70%"></div>
                    <div class="flex-1 bg-blue-400 bg-opacity-50 rounded-t-md" style="height: 60%"></div>
                    <div class="flex-1 bg-white rounded-t-md" style="height: 85%"></div>
                </div>
            </div>

            {{-- Présence --}}
            <div class="bg-white rounded-2xl border border-border p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-base text-text-dark">Présence Aujourd'hui</h3>
                    <span class="text-sm font-bold text-green-600">98%</span>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                            <span class="text-sm text-text-muted">Présents</span>
                        </div>
                        <span class="text-sm font-bold text-text-dark">41</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                            <span class="text-sm text-text-muted">Absents</span>
                        </div>
                        <span class="text-sm font-bold text-text-dark">1</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                            <span class="text-sm text-text-muted">Retards</span>
                        </div>
                        <span class="text-sm font-bold text-text-dark">2</span>
                    </div>
                </div>
                <button class="w-full mt-4 border border-border text-text-muted text-sm py-2 rounded-xl hover:bg-primary-bg hover:text-primary transition-colors">
                    Faire l'appel
                </button>
            </div>

            {{-- Citation --}}
            <div class="bg-primary rounded-2xl p-6 text-white shadow-sm">
                <p class="text-sm font-medium leading-relaxed">
                    "L'éducation est l'arme la plus puissante pour changer le monde."
                </p>
                <p class="text-blue-200 text-xs mt-3">— Nelson Mandela</p>
            </div>

        </div>
    </div>

@endsection