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

        // Récupérer uniquement les compositions de la classe active
        $classeActive = $user->classes()
            ->where('annee_scolaire', $user->annee_scolaire)
            ->latest()->first();

        $compositions = \App\Models\Composition::where('user_id', $user->id)
            ->where('classe_id', $classeActive?->id)
            ->orderBy('trimestre')
            ->get();

        $matieres = \App\Models\Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) use ($niveau, $user) {
            $q->where('user_id', $user->id)
            ->where('is_default', false)
            ->where('classe_niveau', $niveau);
        })->orderBy('ordre')->get();

        $query = \App\Models\Note::where('notes.user_id', $user->id)
            ->join('matieres', 'notes.matiere_id', '=', 'matieres.id')
            ->join('compositions', 'notes.composition_id', '=', 'compositions.id')
            ->join('eleves', 'notes.eleve_id', '=', 'eleves.id')
            ->orderBy('compositions.trimestre')
            ->orderBy('matieres.ordre')
            ->orderBy('eleves.nom')
            ->select('notes.*');

        if ($request->composition_id) {
            $query->where('notes.composition_id', $request->composition_id);
        }
        if ($request->matiere_id) {
            $query->where('notes.matiere_id', $request->matiere_id);
        }

        // Filtrer uniquement les notes de la classe active
        if ($classeActive) {
            $compositionIds = $compositions->pluck('id');
            $query->whereIn('notes.composition_id', $compositionIds);
        }

        $notes = $query->with(['eleve', 'matiere', 'composition'])->paginate(50);

        // Moyenne sur les notes non-NULL uniquement
        $toutesNotes = \App\Models\Note::where('user_id', $user->id)
            ->whereIn('composition_id', $compositions->pluck('id'))
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