<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Composition;
use Illuminate\Support\Facades\DB;

class ParametreController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $classe = Classe::where('user_id', $user->id)
            ->where('annee_scolaire', $user->annee_scolaire)
            ->first();

        $stats = [
            'eleves'       => $user->eleves()->count(),
            'compositions' => $user->compositions()->count(),
            'notes'        => $user->notes()->count(),
            'bulletins'    => $user->bulletins()->count(),
        ];

        return view('parametres.index', compact('user', 'classe', 'stats'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'annee_scolaire'      => ['required', 'string', 'max:9', 'regex:/^\d{4}-\d{4}$/'],
            'niveau_enseignement' => ['required', 'in:CI,CP,CE1,CE2,CM1,CM2'],
            'classe_nom'          => ['required', 'string', 'max:20'],
            'supprimer_eleves'    => ['required', 'in:oui,non'],
        ]);

        $user = auth()->user();

        DB::transaction(function () use ($request, $user) {

            // 1. Toujours supprimer : notes et bulletins
            $user->notes()->delete();
            $user->bulletins()->delete();

            // 2. Supprimer les élèves si demandé
            if ($request->supprimer_eleves === 'oui') {
                $user->eleves()->delete();
            }

            // 3. Détacher les élèves de la classe AVANT de supprimer
            //    pour éviter le cascadeOnDelete
            DB::table('eleves')
                ->where('user_id', $user->id)
                ->update(['classe_id' => null]);

            // 4. Supprimer l'ancienne classe
            DB::table('classes')->where('user_id', $user->id)->delete();

            // 5. Créer la nouvelle classe
            $nouvelleClasse = Classe::create([
                'user_id'        => $user->id,
                'nom'            => $request->classe_nom,
                'annee_scolaire' => $request->annee_scolaire,
            ]);

            // 6. Créer automatiquement les 3 compositions
            foreach ([1, 2, 3] as $trimestre) {
                Composition::create([
                    'user_id'   => $user->id,
                    'classe_id' => $nouvelleClasse->id,
                    'trimestre' => $trimestre,
                    'libelle'   => 'Composition T' . $trimestre,
                ]);
            }

            // 7. Rattacher les élèves conservés à la nouvelle classe
            if ($request->supprimer_eleves === 'non') {
                DB::table('eleves')
                    ->where('user_id', $user->id)
                    ->update(['classe_id' => $nouvelleClasse->id]);
            }

            // 6. Mettre à jour le profil user
            $user->update([
                'annee_scolaire'      => $request->annee_scolaire,
                'niveau_enseignement' => $request->niveau_enseignement,
            ]);
        });

        return redirect()->route('parametres.index')
            ->with('success', 'Nouvelle année scolaire démarrée avec succès !');
    }
}