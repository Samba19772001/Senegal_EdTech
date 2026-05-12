<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Senegal EdTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00288e',
                        'primary-light': '#0058be',
                        'primary-bg': '#eff4ff',
                        'text-dark': '#121c2a',
                        'text-muted': '#444653',
                        border: '#c4c5d5',
                        'bg-page': '#f8f9ff',
                    },
                    fontFamily: { inter: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-bg-page min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        {{-- Branding --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-primary rounded-2xl mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-text-dark">Senegal EdTech</h1>
            <p class="text-text-muted text-sm mt-1">Primary Education Portal</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-primary px-8 py-6">
                <h2 class="text-white text-xl font-semibold">Bon retour 👋</h2>
                <p class="text-blue-200 text-sm mt-1">Connectez-vous à votre espace enseignant</p>
            </div>

            <form class="px-8 py-8 space-y-5">

                {{-- Session erreur --}}
                @if (session('status'))
                    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                        Adresse email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="aminata@gmail.com" required autofocus
                        class="w-full border border-border rounded-xl px-4 py-3 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-bg-page"/>
                </div>

                {{-- Mot de passe --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide">
                            Mot de passe
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs text-primary hover:underline font-medium">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>
                    <input type="password" name="password" placeholder="••••••••" required
                        class="w-full border border-border rounded-xl px-4 py-3 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-bg-page"/>
                </div>

                {{-- Se souvenir --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 rounded border-border text-primary focus:ring-primary cursor-pointer"/>
                    <label for="remember" class="text-sm text-text-muted cursor-pointer">
                        Se souvenir de moi
                    </label>
                </div>

                {{-- Bouton --}}
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary-light text-white font-semibold py-3 rounded-xl transition-colors duration-200 text-sm tracking-wide">
                    Se connecter
                </button>

                <p class="text-center text-sm text-text-muted">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">
                        S'inscrire
                    </a>
                </p>

            </form>
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-text-muted mt-6">
            © 2025 Senegal EdTech — Tous droits réservés
        </p>

    </div>

</body>
</html>