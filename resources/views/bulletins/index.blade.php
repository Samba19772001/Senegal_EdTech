@extends('layouts.app')

@section('title', 'Bulletins — Senegal EdTech')
@section('page_label', 'GESTION')
@section('page_title', 'Bulletins')

@section('content')

    {{-- Barre d'actions --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-text-muted text-sm">Générez et téléchargez les bulletins de vos élèves</p>
        <button class="flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Tout télécharger
        </button>
    </div>

    {{-- Sélecteur trimestre --}}
    <div class="flex items-center gap-3 mb-6">
        <button class="px-5 py-2 bg-primary text-white rounded-xl text-sm font-medium">Trimestre 1</button>
        <button class="px-5 py-2 border border-border text-text-muted rounded-xl text-sm font-medium hover:bg-primary-bg hover:text-primary transition-colors">Trimestre 2</button>
        <button class="px-5 py-2 border border-border text-text-muted rounded-xl text-sm font-medium hover:bg-primary-bg hover:text-primary transition-colors">Trimestre 3</button>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-primary-bg rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide">Total élèves</p>
                <p class="text-xl font-bold text-text-dark">42</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide">Générés</p>
                <p class="text-xl font-bold text-text-dark">42</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide">Moy. classe</p>
                <p class="text-xl font-bold text-text-dark">7.8/10</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-border p-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-text-muted uppercase tracking-wide">Meilleure moy.</p>
                <p class="text-xl font-bold text-text-dark">9.4/10</p>
            </div>
        </div>
    </div>

    {{-- Tableau bulletins --}}
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b border-border">
            <h3 class="text-text-dark font-semibold text-sm">Bulletins — Trimestre 1</h3>
            <div class="relative">
                <svg class="w-4 h-4 text-text-muted absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="Rechercher un élève..."
                    class="pl-9 pr-4 py-2 border border-border rounded-xl text-sm bg-bg-page text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary w-56"/>
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-primary-bg">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Élève</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Moyenne</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Rang</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Mention</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Statut</th>
                    <th class="text-center px-6 py-3 text-xs font-semibold text-text-muted uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">

                @php
                $bulletins = [
                    ['initiales' => 'FD', 'nom' => 'Fatou Diop', 'matricule' => 'EL-2024-004', 'couleur' => 'purple', 'moyenne' => '9.40', 'rang' => 1, 'mention' => 'Très Bien', 'mention_color' => 'green'],
                    ['initiales' => 'AF', 'nom' => 'Awa Fall', 'matricule' => 'EL-2024-002', 'couleur' => 'pink', 'moyenne' => '8.75', 'rang' => 2, 'mention' => 'Bien', 'mention_color' => 'blue'],
                    ['initiales' => 'MS', 'nom' => 'Moussa Sow', 'matricule' => 'EL-2024-001', 'couleur' => 'blue', 'moyenne' => '7.80', 'rang' => 3, 'mention' => 'Assez Bien', 'mention_color' => 'indigo'],
                    ['initiales' => 'ID', 'nom' => 'Ibrahim Diallo', 'matricule' => 'EL-2024-003', 'couleur' => 'orange', 'moyenne' => '7.20', 'rang' => 4, 'mention' => 'Assez Bien', 'mention_color' => 'indigo'],
                    ['initiales' => 'OB', 'nom' => 'Oumar Ba', 'matricule' => 'EL-2024-005', 'couleur' => 'green', 'moyenne' => '6.50', 'rang' => 5, 'mention' => 'Passable', 'mention_color' => 'amber'],
                    ['initiales' => 'MN', 'nom' => 'Mariama Ndiaye', 'matricule' => 'EL-2024-006', 'couleur' => 'red', 'moyenne' => '4.80', 'rang' => 6, 'mention' => 'Insuffisant', 'mention_color' => 'red'],
                ];
                @endphp

                @foreach($bulletins as $b)
                <tr class="hover:bg-bg-page transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-{{ $b['couleur'] }}-100 text-{{ $b['couleur'] }}-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ $b['initiales'] }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-text-dark">{{ $b['nom'] }}</p>
                                <p class="text-xs text-text-muted font-mono">{{ $b['matricule'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-base font-bold text-primary">{{ $b['moyenne'] }}/10</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="w-8 h-8 rounded-full bg-primary-bg text-primary text-sm font-bold inline-flex items-center justify-center">
                            {{ $b['rang'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                        $colors = [
                            'green' => 'bg-green-50 text-green-700',
                            'blue' => 'bg-blue-50 text-blue-700',
                            'indigo' => 'bg-indigo-50 text-indigo-700',
                            'amber' => 'bg-amber-50 text-amber-700',
                            'red' => 'bg-red-50 text-red-700',
                        ];
                        @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $colors[$b['mention_color']] }}">
                            {{ $b['mention'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-xs font-semibold bg-green-50 text-green-700 px-2.5 py-1 rounded-full">Généré</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-border hover:bg-primary-bg hover:text-primary hover:border-primary transition-colors text-text-muted" title="Aperçu">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-border hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition-colors text-text-muted" title="Télécharger PDF">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-border flex items-center justify-between bg-bg-page">
            <p class="text-sm text-text-muted">42 bulletins générés pour le Trimestre 1</p>
            <button class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-light text-white rounded-xl text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Télécharger tous les PDF
            </button>
        </div>

    </div>

@endsection