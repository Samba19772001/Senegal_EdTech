<?php

namespace App\Http\Controllers;

use App\Models\Classe;
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
            'nom'           => ['required', 'string', 'max:20'],
            'annee_scolaire'=> ['required', 'string', 'max:9'],
        ]);

        Classe::create([
            'user_id'        => auth()->id(),
            'nom'            => $request->nom,
            'annee_scolaire' => $request->annee_scolaire,
        ]);

        return redirect()->back()->with('success', 'Classe créée avec succès.');
    }

    public function destroy($id)
    {
        $classe = Classe::where('user_id', auth()->id())->findOrFail($id);
        $classe->delete();
        return redirect()->back()->with('success', 'Classe supprimée.');
    }
}