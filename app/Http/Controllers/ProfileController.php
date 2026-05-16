<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user   = $request->user();
        $classe = Classe::where('user_id', $user->id)
            ->where('annee_scolaire', $user->annee_scolaire)
            ->first();

        return view('profile.edit', compact('user', 'classe'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $anneeChange  = isset($data['annee_scolaire'])
            && $data['annee_scolaire'] !== $user->annee_scolaire;
        $classeChange = isset($data['classe_nom'])
            && $data['classe_nom'] !== ''
            && $data['classe_nom'] !== Classe::where('user_id', $user->id)
                ->where('annee_scolaire', $user->annee_scolaire)
                ->value('nom');

        $changementDetecte = $anneeChange || $classeChange;

        // Si changement d'année ou de classe détecté mais pas encore confirmé → retour avec confirmation
        if ($changementDetecte && !$request->has('supprimer_eleves')) {
            // Stocker les données en session pour les resoumettre après confirmation
            session(['profile_pending' => $data]);
            return Redirect::route('profile.edit')
                ->with('demander_confirmation', true)
                ->withInput();
        }

        DB::transaction(function () use ($request, $user, $data, $anneeChange, $classeChange) {
            // Mettre à jour le profil
            $champsUser = collect($data)->except(['classe_nom', 'supprimer_eleves'])->toArray();
            $user->fill($champsUser);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }
            $user->save();

            // Si changement d'année ou de classe : reset des données
            if ($anneeChange || $classeChange) {
                $nouvelleAnnee = $data['annee_scolaire'] ?? $user->annee_scolaire;

                // Supprimer notes, compositions, bulletins (toujours)
                $user->notes()->delete();
                $user->bulletins()->delete();
                $user->compositions()->delete();

                // Élèves : selon le choix
                if ($request->supprimer_eleves === 'oui') {
                    $user->eleves()->delete();
                    $user->classes()->delete();
                } else {
                    // Garder les élèves mais supprimer l'ancienne classe
                    // et délier les élèves (classe_id sera recréé)
                    $user->classes()->delete();
                }

                // Créer la nouvelle classe
                $nouveauNomClasse = $data['classe_nom']
                    ?? Classe::where('user_id', $user->id)->latest()->value('nom')
                    ?? 'Ma classe';

                $nouvelleClasse = Classe::create([
                    'user_id'        => $user->id,
                    'nom'            => $nouveauNomClasse,
                    'annee_scolaire' => $nouvelleAnnee,
                ]);

                // Si on garde les élèves, les rattacher à la nouvelle classe
                if ($request->supprimer_eleves === 'non') {
                    $user->eleves()->update(['classe_id' => $nouvelleClasse->id]);
                }
            } elseif ($classeChange && isset($data['classe_nom'])) {
                // Juste renommer la classe sans reset
                Classe::where('user_id', $user->id)
                    ->where('annee_scolaire', $user->annee_scolaire)
                    ->update(['nom' => $data['classe_nom']]);
            }
        });

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}