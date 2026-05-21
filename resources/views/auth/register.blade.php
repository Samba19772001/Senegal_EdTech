<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Senegal EdTech</title>
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
<body class="bg-bg-page min-h-screen flex items-center justify-center py-10 px-4">

    <div class="w-full max-w-2xl">

        {{-- Branding --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-primary rounded-2xl mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-text-dark">Senegal EdTech</h1>
            <p class="text-text-muted text-sm mt-1">Portail de l'enseignement primaire</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-primary px-8 py-6">
                <h2 class="text-white text-xl font-semibold">Créer votre compte</h2>
                <p class="text-blue-200 text-sm mt-1">Renseignez vos informations pour commencer</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="px-8 py-8 space-y-8">
                @csrf

                {{-- Erreurs --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- SECTION 1 --}}
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">1</div>
                        <h3 class="text-text-dark font-semibold text-base">Informations personnelles</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Nom</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Diallo"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page @error('nom') border-red-400 @enderror"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Aminata"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page @error('prenom') border-red-400 @enderror"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Téléphone</label>
                            <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="+221 77 000 00 00"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="aminata@ecole.sn"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page @error('email') border-red-400 @enderror"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Mot de passe</label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page @error('password') border-red-400 @enderror"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                    </div>
                </div>

                <hr class="border-border"/>

                {{-- SECTION 2 --}}
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">2</div>
                        <h3 class="text-text-dark font-semibold text-base">Informations professionnelles</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Nom de l'école</label>
                            <input type="text" name="nom_ecole" value="{{ old('nom_ecole') }}" placeholder="École Élémentaire de Dakar"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page @error('nom_ecole') border-red-400 @enderror"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Type d'école</label>
                            <select name="type_ecole" class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page @error('type_ecole') border-red-400 @enderror">
                                <option value="">Sélectionner...</option>
                                <option value="publique" {{ old('type_ecole') == 'publique' ? 'selected' : '' }}>Publique</option>
                                <option value="privee" {{ old('type_ecole') == 'privee' ? 'selected' : '' }}>Privée</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Région</label>
                            <select name="region" class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page @error('region') border-red-400 @enderror">
                                <option value="">Sélectionner...</option>
                                @foreach(['Dakar','Thiès','Saint-Louis','Ziguinchor','Kaolack','Diourbel','Fatick','Kolda','Tambacounda','Louga','Matam','Kaffrine','Kédougou','Sédhiou'] as $region)
                                    <option value="{{ $region }}" {{ old('region') == $region ? 'selected' : '' }}>{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Département</label>
                            <input type="text" name="departement" value="{{ old('departement') }}" placeholder="Dakar"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Commune / Localité</label>
                            <input type="text" name="commune" value="{{ old('commune') }}" placeholder="Plateau"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page"/>
                        </div>
                    </div>
                </div>

                <hr class="border-border"/>

                {{-- SECTION 3 --}}
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">3</div>
                        <h3 class="text-text-dark font-semibold text-base">Informations pédagogiques</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Année scolaire</label>
                            <input type="text" name="annee_scolaire" value="{{ old('annee_scolaire') }}" placeholder="2024-2025"
                                class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page @error('annee_scolaire') border-red-400 @enderror"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">Niveau enseigné</label>
                            <select name="niveau_enseignement" class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page @error('niveau_enseignement') border-red-400 @enderror">
                                <option value="">Sélectionner...</option>
                                @foreach(['CI','CP','CE1','CE2','CM1','CM2'] as $niveau)
                                    <option value="{{ $niveau }}" {{ old('niveau_enseignement') == $niveau ? 'selected' : '' }}>{{ $niveau }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="border-border"/>

                {{-- SECTION 4 : Clé d'accès --}}
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">4</div>
                        <h3 class="text-text-dark font-semibold text-base">Clé d'accès</h3>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted uppercase tracking-wide mb-1.5">
                            Clé d'accès <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="access_key" value="{{ old('access_key') }}"
                            placeholder="XXXX-XXXX-XXXX"
                            class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary bg-bg-page font-mono tracking-widest @error('access_key') border-red-400 @enderror"/>
                        <p class="text-xs text-text-muted mt-1">Clé fournie par l'administrateur Senegal EdTech</p>
                        @error('access_key')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary-light text-white font-semibold py-3 rounded-xl transition-colors duration-200 text-sm tracking-wide">
                    Créer mon compte
                </button>

                <p class="text-center text-sm text-text-muted">
                    Déjà inscrit ?
                    <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Se connecter</a>
                </p>

            </form>
        </div>
    </div>

</body>
</html>