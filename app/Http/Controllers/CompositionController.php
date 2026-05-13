<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Composition;
use App\Models\Matiere;
use Illuminate\Http\Request;

class CompositionController extends Controller
{
    public function index()
    {
        $compositions = Composition::where('user_id', auth()->id())
            ->with('classe')
            ->orderBy('trimestre')
            ->get()
            ->groupBy('trimestre');

        $classes = Classe::where('user_id', auth()->id())->get();

        return view('compositions.index', compact('compositions', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classe_id'        => ['required', 'exists:classes,id'],
            'trimestre'        => ['required', 'in:1,2,3'],
            'libelle'          => ['required', 'string', 'max:100'],
            'date_composition' => ['nullable', 'date'],
        ]);

        // Vérifier unicité classe + trimestre
        $existe = Composition::where('classe_id', $request->classe_id)
            ->where('trimestre', $request->trimestre)
            ->exists();

        if ($existe) {
            return redirect()->back()->withErrors([
                'trimestre' => 'Une composition existe déjà pour ce trimestre.'
            ]);
        }

        Composition::create([
            'user_id'          => auth()->id(),
            'classe_id'        => $request->classe_id,
            'trimestre'        => $request->trimestre,
            'libelle'          => $request->libelle,
            'date_composition' => $request->date_composition,
        ]);

        return redirect()->back()->with('success', 'Composition créée avec succès.');
    }

    public function show($id)
    {
        $composition = Composition::where('user_id', auth()->id())
            ->with('classe')
            ->findOrFail($id);

        $niveau = $composition->classe->nom;

        $matieres = Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) {
            $q->where('user_id', auth()->id())->where('is_default', false);
        })->orderBy('ordre')->get();

        $eleves = $composition->classe->eleves;

        return view('compositions.notes', compact('composition', 'matieres', 'eleves'));
    }
}