<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom'                  => ['required', 'string', 'max:100'],
            'prenom'               => ['required', 'string', 'max:100'],
            'email'                => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password'             => ['required', 'confirmed', Rules\Password::defaults()],
            'telephone'            => ['nullable', 'string', 'max:20'],
            'nom_ecole'            => ['required', 'string', 'max:150'],
            'type_ecole'           => ['required', 'in:publique,privee'],
            'region'               => ['required', 'string', 'max:100'],
            'departement'          => ['nullable', 'string', 'max:100'],
            'commune'              => ['nullable', 'string', 'max:100'],
            'annee_scolaire'       => ['required', 'string', 'max:9'],
            'niveau_enseignement'  => ['required', 'in:CI,CP,CE1,CE2,CM1,CM2'],
        ]);

        $user = User::create([
            'nom'                  => $request->nom,
            'prenom'               => $request->prenom,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'telephone'            => $request->telephone,
            'nom_ecole'            => $request->nom_ecole,
            'type_ecole'           => $request->type_ecole,
            'region'               => $request->region,
            'departement'          => $request->departement,
            'commune'              => $request->commune,
            'annee_scolaire'       => $request->annee_scolaire,
            'niveau_enseignement'  => $request->niveau_enseignement,
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Créer automatiquement la classe
        $classe = \App\Models\Classe::create([
            'user_id'        => $user->id,
            'nom'            => $user->niveau_enseignement,
            'annee_scolaire' => $user->annee_scolaire,
        ]);

        // Créer automatiquement les 3 compositions
        foreach ([1, 2, 3] as $trimestre) {
            \App\Models\Composition::create([
                'user_id'   => $user->id,
                'classe_id' => $classe->id,
                'trimestre' => $trimestre,
                'libelle'   => 'Composition T' . $trimestre,
            ]);
        }

        return redirect(route('dashboard', absolute: false));
    }
}