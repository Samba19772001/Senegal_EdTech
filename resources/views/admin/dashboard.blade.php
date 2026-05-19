<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard — Senegal EdTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-950 min-h-screen text-white">

    {{-- Header --}}
    <header class="bg-gray-900 border-b border-gray-800 px-8 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div>
                <p class="text-white font-bold text-sm">Senegal EdTech</p>
                <p class="text-gray-400 text-xs">Panel Administrateur</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.cles.index') }}"
                class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-xl text-sm transition-colors">
                Gérer les clés
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-900/40 hover:bg-red-900/60 text-red-400 rounded-xl text-sm transition-colors">
                    Déconnexion
                </button>
            </form>
        </div>
    </header>

    <main class="p-8">

        {{-- Messages --}}
        @if(session('success'))
            <div class="bg-green-900/30 border border-green-700 text-green-400 text-sm px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-900/30 border border-red-700 text-red-400 text-sm px-4 py-3 rounded-xl mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5">
                <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Total utilisateurs</p>
                <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5">
                <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Comptes actifs</p>
                <p class="text-3xl font-bold text-green-400">{{ $stats['actifs'] }}</p>
            </div>
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5">
                <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Comptes bloqués</p>
                <p class="text-3xl font-bold text-red-400">{{ $stats['bloques'] }}</p>
            </div>
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5">
                <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Clés disponibles</p>
                <p class="text-3xl font-bold text-blue-400">{{ $stats['cles_disponibles'] }}</p>
            </div>
        </div>

        {{-- Table utilisateurs --}}
        <div class="bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between">
                <h2 class="font-bold text-white">Utilisateurs</h2>
                <span class="text-xs text-gray-400">{{ $users->total() }} comptes</span>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Enseignant</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase">École</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Région</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Niveau</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Année</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Statut</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $user->prenom }} {{ $user->nom }}</p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                <p class="text-xs text-gray-500">{{ $user->telephone ?? '—' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-300">{{ $user->nom_ecole }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($user->type_ecole) }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $user->region }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-blue-900/40 text-blue-400 text-xs font-bold rounded-lg">
                                {{ $user->niveau_enseignement }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $user->annee_scolaire }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_blocked)
                                <span class="px-2 py-1 bg-red-900/40 text-red-400 text-xs font-semibold rounded-full">Bloqué</span>
                            @else
                                <span class="px-2 py-1 bg-green-900/40 text-green-400 text-xs font-semibold rounded-full">Actif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Bloquer / Débloquer --}}
                                @if($user->is_blocked)
                                    <form method="POST" action="{{ route('admin.users.debloquer', $user) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-green-900/40 hover:bg-green-900/60 text-green-400 rounded-lg text-xs font-medium transition-colors">
                                            Débloquer
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.users.bloquer', $user) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-amber-900/40 hover:bg-amber-900/60 text-amber-400 rounded-lg text-xs font-medium transition-colors">
                                            Bloquer
                                        </button>
                                    </form>
                                @endif

                                {{-- Reset mot de passe --}}
                                <form method="POST" action="{{ route('admin.users.resetPassword', $user) }}">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Réinitialiser le mot de passe de {{ $user->prenom }} ?')"
                                        class="px-3 py-1.5 bg-blue-900/40 hover:bg-blue-900/60 text-blue-400 rounded-lg text-xs font-medium transition-colors">
                                        Reset MDP
                                    </button>
                                </form>

                                {{-- Supprimer --}}
                                <form method="POST" action="{{ route('admin.users.supprimer', $user) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Supprimer définitivement le compte de {{ $user->prenom }} {{ $user->nom }} ?')"
                                        class="px-3 py-1.5 bg-red-900/40 hover:bg-red-900/60 text-red-400 rounded-lg text-xs font-medium transition-colors">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $users->links() }}
            </div>
        </div>
    </main>

</body>
</html>