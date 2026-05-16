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
        // Récupérer uniquement la classe active (dernière créée)
        $classeActive = \App\Models\Classe::where('user_id', auth()->id())
            ->where('annee_scolaire', auth()->user()->annee_scolaire)
            ->latest()
            ->first();

        $compositions = Composition::where('user_id', auth()->id())
            ->where('classe_id', $classeActive?->id)
            ->with(['classe', 'notes'])
            ->orderBy('trimestre')
            ->get()
            ->groupBy('trimestre');

        $classes = \App\Models\Classe::where('user_id', auth()->id())->get();

        $statsCompositions = [];

        foreach ($compositions->flatten() as $composition) {
            $niveau = $composition->classe->nom;

            $matieres = Matiere::where(function ($q) use ($niveau) {
                $q->where('is_default', true)->where('classe_niveau', $niveau);
            })->orWhere(function ($q) use ($niveau) {
                $q->where('user_id', auth()->id())
                ->where('is_default', false)
                ->where('classe_niveau', $niveau);
            })->orderBy('ordre')->get();

            $eleves   = $composition->classe->eleves;
            $nbEleves = $eleves->count();
            $nbMatieres = $matieres->count();

            // Matière saisie = toutes les lignes existent (note OU null)
            $matieresSaisies = $nbEleves > 0
                ? $matieres->filter(function ($m) use ($composition, $nbEleves) {
                    return $composition->notes->where('matiere_id', $m->id)->count() >= $nbEleves;
                })->count()
                : 0;

            // Progression = matières entièrement traitées / total matières
            $progression = $nbMatieres > 0
                ? round($matieresSaisies / $nbMatieres * 100)
                : 0;

            // Complet = toutes les matières ont une ligne pour chaque élève (NULL inclus)
            $estComplet = $nbMatieres > 0 && $matieresSaisies >= $nbMatieres;

            // Bulletin bloqué si pas complet — même comportement qu'avant
            $peutGenererBulletin = $estComplet;

            $statsCompositions[$composition->id] = [
                'matieres'            => $matieres,
                'nbEleves'            => $nbEleves,
                'nbMatieres'          => $nbMatieres,
                'progression'         => $progression,
                'matieresSaisies'     => $matieresSaisies,
                'peutGenererBulletin' => $peutGenererBulletin,
                'estComplet'          => $estComplet,
            ];
        }

        return view('compositions.index', compact('compositions', 'classes', 'statsCompositions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classe_id'        => ['required', 'exists:classes,id'],
            'trimestre'        => ['required', 'in:1,2,3'],
            'libelle'          => ['required', 'string', 'max:100'],
            'date_composition' => ['nullable', 'date'],
        ]);

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

        $matieres = Matiere::where(function ($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function ($q) use ($niveau) {
            $q->where('user_id', auth()->id())
            ->where('is_default', false)
            ->where('classe_niveau', $niveau);
        })->orderBy('ordre')->get();

        $eleves = $composition->classe->eleves;

        return view('compositions.notes', compact('composition', 'matieres', 'eleves'));
    }
}