<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use App\Imports\ElevesImport;
use Maatwebsite\Excel\Facades\Excel;

class EleveController extends Controller
{
    public function index(Request $request)
    {
        $annee   = auth()->user()->annee_scolaire;

        // ← Ajouter ce filtre par année
        $classes = Classe::where('user_id', auth()->id())
            ->where('annee_scolaire', $annee)
            ->get();

        // ← Ajouter cette variable pour le formulaire d'ajout
        $classeUser = Classe::where('user_id', auth()->id())
            ->where('annee_scolaire', $annee)
            ->first();

        $query = Eleve::where('user_id', auth()->id())
            ->with('classe')
            ->orderBy('nom')
            ->orderBy('prenom');

        if ($request->classe_id) {
            $query->where('classe_id', $request->classe_id);
        }
        if ($request->sexe) {
            $query->where('sexe', $request->sexe);
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', "%{$request->search}%")
                ->orWhere('prenom', 'like', "%{$request->search}%")
                ->orWhere('matricule', 'like', "%{$request->search}%");
            });
        }

        $eleves       = $query->paginate(20);
        $totalGarcons = Eleve::where('user_id', auth()->id())->where('sexe', 'M')->count();
        $totalFilles  = Eleve::where('user_id', auth()->id())->where('sexe', 'F')->count();

        return view('eleves.index', compact(
            'eleves', 'classes', 'classeUser', 'totalGarcons', 'totalFilles'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classe_id'      => ['required', 'exists:classes,id'],
            'nom'            => ['required', 'string', 'max:100'],
            'prenom'         => ['required', 'string', 'max:100'],
            'sexe'           => ['required', 'in:M,F'],
            'date_naissance' => ['nullable', 'date'],
            'matricule'      => ['nullable', 'string', 'max:50', 'unique:eleves'],
        ]);

        Eleve::create([
            'user_id'        => auth()->id(),
            'classe_id'      => $request->classe_id,
            'nom'            => $request->nom,
            'prenom'         => $request->prenom,
            'sexe'           => $request->sexe,
            'date_naissance' => $request->date_naissance,
            'matricule'      => $request->matricule,
        ]);

        return redirect()->back()->with('success', 'Élève ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $eleve = Eleve::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'nom'            => ['required', 'string', 'max:100'],
            'prenom'         => ['required', 'string', 'max:100'],
            'sexe'           => ['required', 'in:M,F'],
            'date_naissance' => ['nullable', 'date'],
            'matricule'      => ['nullable', 'string', 'max:50', 'unique:eleves,matricule,'.$id],
        ]);

        $eleve->update($request->only([
            'nom', 'prenom', 'sexe', 'date_naissance', 'matricule'
        ]));

        return redirect()->back()->with('success', 'Élève modifié avec succès.');
    }

    public function destroy($id)
    {
        $eleve = Eleve::where('user_id', auth()->id())->findOrFail($id);
        $eleve->delete();
        return redirect()->back()->with('success', 'Élève supprimé.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'fichier'   => ['required', 'file', 'mimes:xlsx,xls'],
            'classe_id' => ['required', 'exists:classes,id'],
        ]);

        Excel::import(
            new ElevesImport(auth()->id(), $request->classe_id),
            $request->file('fichier')
        );

        return redirect()->back()->with('success', 'Élèves importés avec succès.');
    }

    public function destroyAll()
    {
        $user = auth()->user();

        // Supprimer les notes liées
        \App\Models\Note::where('user_id', $user->id)->delete();

        // Supprimer les bulletins liés
        \App\Models\Bulletin::where('user_id', $user->id)->delete();

        // Supprimer tous les élèves
        \App\Models\Eleve::where('user_id', $user->id)->delete();

        return redirect()->route('eleves.index')
            ->with('success', 'Tous les élèves ont été supprimés avec succès.');
    }

    public function suggestions(Request $request)
    {
        try {

            $q = $request->get('q');

            if (!$q) {
                return response()->json([]);
            }

            $eleves = Eleve::query()
                ->where('nom', 'LIKE', "%{$q}%")
                ->orWhere('prenom', 'LIKE', "%{$q}%")
                ->limit(8)
                ->get(['id', 'nom', 'prenom']);

            return response()->json($eleves);

        } catch (\Throwable $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}