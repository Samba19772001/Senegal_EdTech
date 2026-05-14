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
    public function index(Request $request)
    {
        $user   = auth()->user();
        $niveau = $user->niveau_enseignement;

        $compositions = \App\Models\Composition::where('user_id', $user->id)->get();

        $matieres = \App\Models\Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) use ($user) {
            $q->where('user_id', $user->id)->where('is_default', false);
        })->orderBy('ordre')->get();

        $query = Note::where('notes.user_id', $user->id)
            ->join('matieres', 'notes.matiere_id', '=', 'matieres.id')
            ->join('compositions', 'notes.composition_id', '=', 'compositions.id')
            ->orderBy('compositions.trimestre')
            ->orderBy('matieres.ordre')
            ->orderBy('matieres.nom')
            ->select('notes.*');

        if ($request->composition_id) {
            $query->where('composition_id', $request->composition_id);
        }
        if ($request->matiere_id) {
            $query->where('matiere_id', $request->matiere_id);
        }

        $notes = $query->paginate(20);

        // Calculer moyenne générale sur 10
        $toutesNotes = Note::where('user_id', $user->id)->with('matiere')->get();
        $moyenneGenerale = '—';
        if ($toutesNotes->count() > 0) {
            $total = $toutesNotes->sum(fn($n) => $n->note * 10 / $n->matiere->note_sur);
            $moyenneGenerale = number_format($total / $toutesNotes->count(), 2);
        }

        return view('notes.index', compact('notes', 'compositions', 'matieres', 'moyenneGenerale'));
    }
}