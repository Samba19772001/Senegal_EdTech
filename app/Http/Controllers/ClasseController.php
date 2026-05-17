<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Composition;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::where('user_id', auth()->id())->get();
        return view('classes.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'            => ['required', 'string', 'max:20'],
            'annee_scolaire' => ['required', 'string', 'max:9'],
        ]);

        $classe = Classe::create([
            'user_id'        => auth()->id(),
            'nom'            => $request->nom,
            'annee_scolaire' => $request->annee_scolaire,
        ]);

        // Créer automatiquement les 3 compositions
        foreach ([1, 2, 3] as $trimestre) {
            Composition::create([
                'user_id'   => auth()->id(),
                'classe_id' => $classe->id,
                'trimestre' => $trimestre,
                'libelle'   => 'Composition T' . $trimestre,
            ]);
        }

        return redirect()->back()->with('success', 'Classe créée avec succès.');
    }

    public function destroy($id)
    {
        $classe = Classe::where('user_id', auth()->id())->findOrFail($id);
        $classe->delete();
        return redirect()->back()->with('success', 'Classe supprimée.');
    }
}