<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Composition;

class ParametreController extends Controller
{
    public function index()
    {
        return view('parametres.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'annee_scolaire'      => ['required', 'string', 'max:9', 'regex:/^\d{4}-\d{4}$/'],
            'niveau_enseignement' => ['required', 'in:CI,CP,CE1,CE2,CM1,CM2'],
        ]);

        $user = auth()->user();

        if ($request->annee_scolaire == $user->annee_scolaire &&
            $request->niveau_enseignement == $user->niveau_enseignement) {
            return redirect()->back()->withErrors([
                'annee_scolaire' => 'Veuillez entrer une nouvelle année scolaire ou une nouvelle classe.'
            ]);
        }

        // Mettre à jour l'utilisateur
        $user->update([
            'annee_scolaire'      => $request->annee_scolaire,
            'niveau_enseignement' => $request->niveau_enseignement,
        ]);

        // Créer la nouvelle classe
        $classe = Classe::create([
            'user_id'        => $user->id,
            'nom'            => $request->niveau_enseignement,
            'annee_scolaire' => $request->annee_scolaire,
        ]);

        // Transférer les élèves existants dans la nouvelle classe
        \App\Models\Eleve::where('user_id', $user->id)
            ->update(['classe_id' => $classe->id]);

        // Créer les 3 nouvelles compositions
        foreach ([1, 2, 3] as $trimestre) {
            Composition::create([
                'user_id'   => $user->id,
                'classe_id' => $classe->id,
                'trimestre' => $trimestre,
                'libelle'   => 'Composition T' . $trimestre,
            ]);
        }

        return redirect()->route('parametres.index')
            ->with('success', 'Nouvelle année scolaire démarrée avec succès !');
    }
}