<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clés d'accès — Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-950 min-h-screen text-white">

    {{-- ====== HEADER ====== --}}
    <header class="bg-gray-900 border-b border-gray-800 px-4 sm:px-8 py-3 sm:py-4">
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('admin.dashboard') }}"
                class="text-gray-400 hover:text-white transition-colors text-sm shrink-0">
                ← Retour
            </a>
            <h1 class="font-bold text-white text-sm sm:text-base text-center">
                Gestion des clés d'accès
            </h1>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                    class="px-3 sm:px-4 py-2 bg-red-900/40 hover:bg-red-900/60 text-red-400 rounded-xl text-xs sm:text-sm transition-colors shrink-0">
                    Déconnexion
                </button>
            </form>
        </div>
    </header>

    <main class="p-4 sm:p-8 space-y-4 sm:space-y-6">

        {{-- ====== MESSAGE ====== --}}
        @if(session('success'))
            <div class="bg-green-900/30 border border-green-700 text-green-400 text-sm px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- ====== FORMULAIRE GÉNÉRATION ====== --}}
        <div class="bg-gray-900 rounded-2xl border border-gray-800 p-4 sm:p-6">
            <h2 class="font-bold text-white mb-4">Générer des clés</h2>
            <form method="POST" action="{{ route('admin.cles.generer') }}"
                class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 sm:gap-4">
                @csrf

                <div class="flex flex-row gap-3 sm:contents">
                    {{-- Nombre --}}
                    <div class="w-28 sm:w-auto shrink-0">
                        <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">
                            Nombre
                        </label>
                        <input type="number" name="nombre" value="1" min="1" max="50"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                    </div>

                    {{-- Note --}}
                    <div class="flex-1">
                        <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1.5">
                            Note (optionnel)
                        </label>
                        <input type="text" name="note" placeholder="Ex : Pour école de Thiès"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                    </div>
                </div>

                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors touch-manipulation">
                    Générer
                </button>
            </form>
        </div>

        {{-- ====== LISTE DES CLÉS ====== --}}
        <div class="bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-800">
                <h2 class="font-bold text-white">Toutes les clés</h2>
            </div>

            {{-- TABLE desktop --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-800">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Clé</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Note</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Utilisée par</th>
                            <th class="text-center px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Statut</th>
                            <th class="text-center px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Créée le</th>
                            <th class="text-center px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($cles as $cle)
                        <tr class="hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-bold text-blue-400 tracking-widest">
                                    {{ $cle->cle }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $cle->note ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @if($cle->user)
                                    <p class="text-sm text-white">{{ $cle->user->prenom }} {{ $cle->user->nom }}</p>
                                    <p class="text-xs text-gray-400">{{ $cle->user->email }}</p>
                                @else
                                    <span class="text-gray-500 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($cle->est_utilisee)
                                    <span class="px-2 py-1 bg-gray-700 text-gray-400 text-xs rounded-full">Utilisée</span>
                                @else
                                    <span class="px-2 py-1 bg-green-900/40 text-green-400 text-xs rounded-full">Disponible</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-xs text-gray-400">
                                {{ $cle->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if(!$cle->est_utilisee)
                                    <form method="POST" action="{{ route('admin.cles.supprimer', $cle) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Supprimer cette clé ?')"
                                            class="px-3 py-1.5 bg-red-900/40 hover:bg-red-900/60 text-red-400 rounded-lg text-xs transition-colors">
                                            Supprimer
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-600 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- CARDS mobile --}}
            <div class="sm:hidden divide-y divide-gray-800">
                @foreach($cles as $cle)
                <div class="p-4 space-y-2.5">

                    {{-- Clé + statut --}}
                    <div class="flex items-start justify-between gap-2">
                        <span class="font-mono text-sm font-bold text-blue-400 tracking-widest break-all">
                            {{ $cle->cle }}
                        </span>
                        @if($cle->est_utilisee)
                            <span class="shrink-0 px-2 py-1 bg-gray-700 text-gray-400 text-xs rounded-full">Utilisée</span>
                        @else
                            <span class="shrink-0 px-2 py-1 bg-green-900/40 text-green-400 text-xs rounded-full">Disponible</span>
                        @endif
                    </div>

                    {{-- Méta --}}
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-400">
                        @if($cle->note)
                            <span>📝 {{ $cle->note }}</span>
                        @endif
                        <span>📅 {{ $cle->created_at->format('d/m/Y') }}</span>
                    </div>

                    {{-- Utilisateur --}}
                    @if($cle->user)
                        <div class="text-xs">
                            <span class="text-gray-500">Utilisée par : </span>
                            <span class="text-white">{{ $cle->user->prenom }} {{ $cle->user->nom }}</span>
                            <span class="text-gray-400"> — {{ $cle->user->email }}</span>
                        </div>
                    @endif

                    {{-- Action --}}
                    @if(!$cle->est_utilisee)
                        <form method="POST" action="{{ route('admin.cles.supprimer', $cle) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Supprimer cette clé ?')"
                                class="px-4 py-2 bg-red-900/40 hover:bg-red-900/60 text-red-400 rounded-lg text-xs font-medium transition-colors touch-manipulation">
                                Supprimer
                            </button>
                        </form>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="px-4 sm:px-6 py-4 border-t border-gray-800">
                {{ $cles->links() }}
            </div>
        </div>

    </main>

</body>
</html>