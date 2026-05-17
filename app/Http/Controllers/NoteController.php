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

        // ✅ niveau depuis le user, pas le nom de classe
        $niveau = auth()->user()->niveau_enseignement;

        // ✅ élèves uniquement de la classe de cette composition
        $eleves = $composition->classe->eleves;

        $matieres = Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) use ($niveau) {
            $q->where('user_id', auth()->id())
              ->where('is_default', false)
              ->where('classe_niveau', $niveau);
        })->orderBy('ordre')->get();

        $notesExistantes = Note::where('composition_id', $compositionId)
            ->where('matiere_id', $matiereId)
            ->get()
            ->keyBy('eleve_id')
            ->map(fn($n) => $n->note);

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

        foreach ($request->notes as $eleveId => $valeur) {
            Note::updateOrCreate(
                [
                    'composition_id' => $compositionId,
                    'eleve_id'       => $eleveId,
                    'matiere_id'     => $matiereId,
                ],
                [
                    'user_id' => auth()->id(),
                    'note'    => ($valeur !== '' && $valeur !== null) ? $valeur : null,
                ]
            );
        }

        // ✅ niveau depuis le user
        $niveau = auth()->user()->niveau_enseignement;

        $matieres = Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) use ($niveau) {
            $q->where('user_id', auth()->id())
              ->where('is_default', false)
              ->where('classe_niveau', $niveau);
        })->orderBy('ordre')->pluck('id')->toArray();

        $indexActuel   = array_search((int)$matiereId, $matieres);
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

        $matieres = Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) use ($niveau) {
            $q->where('user_id', auth()->id())
              ->where('is_default', false)
              ->where('classe_niveau', $niveau);
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

        $toutesNotes = Note::where('user_id', $user->id)
            ->whereNotNull('note')
            ->with('matiere')
            ->get();

        $moyenneGenerale = '—';
        if ($toutesNotes->count() > 0) {
            $total = $toutesNotes->sum(fn($n) => $n->note * 10 / $n->matiere->note_sur);
            $moyenneGenerale = number_format($total / $toutesNotes->count(), 2);
        }

        return view('notes.index', compact('notes', 'compositions', 'matieres', 'moyenneGenerale'));
    }
}