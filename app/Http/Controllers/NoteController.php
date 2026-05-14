<?php

namespace App\Http\Controllers;

use App\Models\Composition;
use App\Models\Matiere;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function showMatiere($compositionId, $matiereId)
    {
        $composition = Composition::where('user_id', auth()->id())
            ->with(['classe.eleves', 'notes'])
            ->findOrFail($compositionId);

        $matiere = Matiere::findOrFail($matiereId);
        $eleves  = $composition->classe->eleves;
        $niveau  = $composition->classe->nom;

        $matieres = Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) {
            $q->where('user_id', auth()->id())->where('is_default', false);
        })->orderBy('ordre')->get();

        $notesExistantes = Note::where('composition_id', $compositionId)
            ->where('matiere_id', $matiereId)
            ->pluck('note', 'eleve_id');

        return view('compositions.notes', compact(
            'composition', 'matiere', 'eleves', 'matieres', 'notesExistantes'
        ));
    }
    public function storeMatiere(Request $request, $compositionId, $matiereId)
    {
        $composition = Composition::where('user_id', auth()->id())
            ->findOrFail($compositionId);

        $matiere = Matiere::findOrFail($matiereId);

        $request->validate([
            'notes'   => ['required', 'array'],
            'notes.*' => ['nullable', 'numeric', 'min:0', 'max:' . $matiere->note_sur],
        ]);

        foreach ($request->notes as $eleveId => $note) {
            if ($note !== null && $note !== '') {
                Note::updateOrCreate(
                    [
                        'composition_id' => $compositionId,
                        'eleve_id'       => $eleveId,
                        'matiere_id'     => $matiereId,
                    ],
                    [
                        'user_id' => auth()->id(),
                        'note'    => $note,
                    ]
                );
            }
        }

        // Passer à la matière suivante
        $niveau   = $composition->classe->nom;
        $matieres = Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) {
            $q->where('user_id', auth()->id())->where('is_default', false);
        })->orderBy('ordre')->pluck('id')->toArray();

        $indexActuel = array_search($matiereId, $matieres);
        $prochainIndex = $indexActuel + 1;

        if ($prochainIndex < count($matieres)) {
            $prochaineMatiere = $matieres[$prochainIndex];
            return redirect()->route('notes.showMatiere', [$compositionId, $prochaineMatiere])
                ->with('success', 'Notes enregistrées !');
        }

        return redirect()->route('compositions.index')
            ->with('success', 'Toutes les notes ont été saisies !');
    }
}