<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin — Senegal EdTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-blue-600 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Administration</h1>
            <p class="text-gray-400 text-sm mt-1">Senegal EdTech — Accès restreint</p>
        </div>

        <div class="bg-gray-900 rounded-2xl border border-gray-800 p-8">
            @if($errors->any())
                <div class="bg-red-900/30 border border-red-700 text-red-400 text-sm px-4 py-3 rounded-xl mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wide mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wide mb-1.5">Mot de passe</label>
                    <input type="password" name="password"
                        class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-colors text-sm mt-2">
                    Se connecter
                </button>
            </form>
        </div>
    </div>

</body>
</html>