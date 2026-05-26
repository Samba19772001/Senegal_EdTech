<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;
use App\Models\Note;

class MatiereController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $niveau  = $user->niveau_enseignement;

        $matieres_default = Matiere::where('is_default', true)
            ->where('classe_niveau', $niveau)
            ->orderBy('ordre')
            ->get();

        $matieres_custom = Matiere::where('user_id', auth()->id())
            ->where('classe_niveau', $niveau)
            ->orderBy('ordre')
            ->get();

        return view('matieres.index', compact('matieres_default', 'matieres_custom'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'      => ['required', 'string', 'max:100'],
            'note_sur' => ['required', 'numeric', 'in:10,20,24,40,60'],
        ]);

        Matiere::create([
            'user_id'       => auth()->id(),
            'classe_niveau' => auth()->user()->niveau_enseignement,
            'nom'           => $request->nom,
            'note_sur'      => $request->note_sur,
            'is_default'    => false,
        ]);

        return redirect()->back()->with('success', 'Matière ajoutée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $matiere = Matiere::where('user_id', auth()->id())
            ->where('is_default', false)
            ->findOrFail($id);

        $request->validate([
            'nom'      => ['required', 'string', 'max:100'],
            'note_sur' => ['required', 'numeric', 'in:10,16,20,24,40,60'],
        ]);

        $matiere->update($request->only(['nom', 'note_sur']));
        return redirect()->back()->with('success', 'Matière modifiée.');
    }

    public function destroy($id)
    {
        $matiere = Matiere::where('user_id', auth()->id())
            ->where('is_default', false)
            ->findOrFail($id);

        // Supprimer toutes les notes liées à cette matière
        Note::where('matiere_id', $matiere->id)->delete();

        $matiere->delete();
        return redirect()->back()->with('success', 'Matière supprimée.');
    }
}