<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\Composition;
use App\Services\BulletinService;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    protected BulletinService $bulletinService;

    public function __construct(BulletinService $bulletinService)
    {
        $this->bulletinService = $bulletinService;
    }

    public function index(Request $request)
    {
        $trimestreActif = $request->get('trimestre', 1);
        $user = auth()->user();

        // Récupérer la classe active
        $classeActive = \App\Models\Classe::where('user_id', $user->id)
            ->where('annee_scolaire', $user->annee_scolaire)
            ->latest()
            ->first();

        $composition = null;
        $bulletinsComposition = collect();

        if ($classeActive) {
            $composition = \App\Models\Composition::where('user_id', $user->id)
                ->where('classe_id', $classeActive->id)
                ->where('trimestre', $trimestreActif)
                ->with('classe.eleves')
                ->first();

            if ($composition) {
                $bulletinsComposition = \App\Models\Bulletin::where('user_id', $user->id)
                    ->where('composition_id', $composition->id)
                    ->with('eleve')
                    ->get();
            }
        }

        return view('bulletins.index', compact(
            'trimestreActif',
            'composition',
            'bulletinsComposition'
        ));
    }
   public function generer($compositionId)
    {
        $composition = \App\Models\Composition::where('user_id', auth()->id())
            ->findOrFail($compositionId);

        $this->bulletinService->genererTousBulletins($composition);

        return redirect()->route('bulletins.index')
            ->with('success', 'Bulletins générés avec succès !');
    }

    public function download($id)
    {
        $bulletin = Bulletin::where('user_id', auth()->id())->findOrFail($id);

        $path = storage_path('app/' . $bulletin->pdf_path);

        if (!file_exists($path)) {
            return redirect()->back()->withErrors(['pdf' => 'Fichier PDF introuvable.']);
        }

        $nomEleve = $bulletin->eleve->prenom . '_' . $bulletin->eleve->nom;
        $filename = "{$nomEleve}_T{$bulletin->composition->trimestre}.pdf";

        return response()->download($path, $filename);
    }

    public function downloadAll($compositionId)
    {
        $composition = \App\Models\Composition::where('user_id', auth()->id())
            ->findOrFail($compositionId);

        $bulletins = \App\Models\Bulletin::where('user_id', auth()->id())
            ->where('composition_id', $compositionId)
            ->with('eleve')
            ->get();

        if ($bulletins->isEmpty()) {
            return redirect()->back()->withErrors(['zip' => 'Aucun bulletin à télécharger.']);
        }

        $zipFilename = "bulletins_T{$composition->trimestre}.zip";

        $zip = new \ZipStream\ZipStream(
            outputName: $zipFilename,
            sendHttpHeaders: true,
        );
        foreach ($bulletins as $bulletin) {
            $pdfPath = storage_path('app/' . $bulletin->pdf_path);
            if (file_exists($pdfPath)) {
                $nomEleve = $bulletin->eleve->prenom . '_' . $bulletin->eleve->nom;
                $zip->addFileFromPath(
                    "{$nomEleve}_T{$composition->trimestre}.pdf",
                    $pdfPath
                );
            }
        }

        $zip->finish();
    }

    public function classement($compositionId)
    {
        $composition = \App\Models\Composition::where('user_id', auth()->id())
            ->with('classe.eleves')
            ->findOrFail($compositionId);

        $niveau = $composition->classe->nom;

        $matieres = \App\Models\Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) use ($niveau) {
            $q->where('user_id', auth()->id())
            ->where('is_default', false)
            ->where('classe_niveau', $niveau);
        })->orderBy('ordre')->get();

        $moyenneService = new \App\Services\MoyenneService();

        $resultats = $composition->classe->eleves->map(function($eleve) use ($composition, $matieres, $moyenneService) {
            $notes = $eleve->notes()
                ->where('composition_id', $composition->id)
                ->with('matiere')
                ->get()
                ->keyBy('matiere_id');

            $totalPoints = 0;
            $notesPropres = [];

            foreach ($matieres as $matiere) {
                $note = $notes->get($matiere->id);
                $noteVal = $note ? $note->note : null;
                $noteRamenee = ($noteVal !== null) ? round($noteVal * 10 / $matiere->note_sur, 2) : null;
                $totalPoints += $noteVal ?? 0;
                $notesPropres[$matiere->id] = [
                    'note'        => $noteVal,
                    'note_sur'    => $matiere->note_sur,
                    'note_ramenee'=> $noteRamenee,
                ];
            }

            $moyenne = $moyenneService->calculerMoyenneEleve($eleve, $composition);

            return [
                'eleve'        => $eleve,
                'notes'        => $notesPropres,
                'totalPoints'  => $totalPoints,
                'moyenne'      => $moyenne,
                'mention'      => $moyenneService->getMention($moyenne),
            ];
        })
        ->sortByDesc('moyenne')
        ->values();

        $resultats = $resultats->map(function($item) use ($resultats) {
            $item['rang'] = $resultats->filter(
                fn($other) => $other['moyenne'] > $item['moyenne']
            )->count() + 1;
            return $item;
        });

        $moyenneClasse = $resultats->avg('moyenne');

        return view('bulletins.classement', compact(
            'composition', 'matieres', 'resultats', 'moyenneClasse'
        ));
    }

    public function classementPdf($compositionId)
    {
        $composition = \App\Models\Composition::where('user_id', auth()->id())
            ->with('classe.eleves')
            ->findOrFail($compositionId);

        $niveau = $composition->classe->nom;

        $matieres = \App\Models\Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) use ($niveau) {
            $q->where('user_id', auth()->id())
            ->where('is_default', false)
            ->where('classe_niveau', $niveau);
        })->orderBy('ordre')->get();

        $moyenneService = new \App\Services\MoyenneService();

        $resultats = $composition->classe->eleves->map(function($eleve) use ($composition, $matieres, $moyenneService) {
            $notes = $eleve->notes()
                ->where('composition_id', $composition->id)
                ->with('matiere')
                ->get()
                ->keyBy('matiere_id');

            $totalPoints = 0;
            $notesPropres = [];

            foreach ($matieres as $matiere) {
                $note = $notes->get($matiere->id);
                $noteVal = $note ? $note->note : null;
                $totalPoints += $noteVal ?? 0;
                $notesPropres[$matiere->id] = [
                    'note'        => $noteVal,
                    'note_sur'    => $matiere->note_sur,
                    'note_ramenee'=> ($noteVal !== null) ? round($noteVal * 10 / $matiere->note_sur, 2) : null,
                ];
            }

            $moyenne = $moyenneService->calculerMoyenneEleve($eleve, $composition);

            return [
                'eleve'       => $eleve,
                'notes'       => $notesPropres,
                'totalPoints' => $totalPoints,
                'moyenne'     => $moyenne,
                'mention'     => $moyenneService->getMention($moyenne),
            ];
        })
        ->sortByDesc('moyenne')
        ->values();

        $resultats = $resultats->map(function($item) use ($resultats) {
            $item['rang'] = $resultats->filter(
                fn($other) => $other['moyenne'] > $item['moyenne']
            )->count() + 1;
            return $item;
        });

        $moyenneClasse = $resultats->avg('moyenne');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bulletins.classement_pdf', compact(
            'composition', 'matieres', 'resultats', 'moyenneClasse'
        ))->setPaper('A4', 'landscape');

        return $pdf->download("Classement_T{$composition->trimestre}_{$composition->classe->nom}.pdf");
    }

    public function propositionPassage($compositionId)
    {
        $composition = \App\Models\Composition::where('user_id', auth()->id())
            ->with('classe.eleves')
            ->findOrFail($compositionId);

        $moyenneService = new \App\Services\MoyenneService();
        $user = auth()->user();

        $classeActive = $user->classes()
            ->where('annee_scolaire', $user->annee_scolaire)
            ->latest()->first();

        $compositions = \App\Models\Composition::where('user_id', $user->id)
            ->where('classe_id', $classeActive?->id)
            ->orderBy('trimestre')
            ->get()
            ->keyBy('trimestre');

        $resultats = $composition->classe->eleves->map(function($eleve) use ($compositions, $moyenneService, $user) {
            $moyennes = [];
            foreach ([1, 2, 3] as $t) {
                $comp = $compositions->get($t);
                if (!$comp) { $moyennes[$t] = null; continue; }

                $notes = $eleve->notes()
                    ->where('composition_id', $comp->id)
                    ->whereNotNull('note')->get();

                if ($notes->count() > 0) {
                    $moyennes[$t] = $moyenneService->calculerMoyenneEleve($eleve, $comp);
                } else {
                    $mm = \App\Models\MoyenneManuelle::where('user_id', $user->id)
                        ->where('eleve_id', $eleve->id)
                        ->where('trimestre', $t)
                        ->where('annee_scolaire', $user->annee_scolaire)
                        ->first();

                    $moyennes[$t] = $mm ? $mm->moyenne : null;
                }
            }

            $moyennesValides = array_filter($moyennes, fn($m) => $m !== null);
            $moyAnnuelle = count($moyennesValides) > 0
                ? round(array_sum($moyennesValides) / count($moyennesValides), 2)
                : null;
            $decision = $moyAnnuelle !== null ? $moyenneService->getDecision($moyAnnuelle) : '—';

            return [
                'eleve'       => $eleve,
                'moyennes'    => $moyennes,
                'moyAnnuelle' => $moyAnnuelle,
                'decision'    => $decision,
            ];
        })
        ->sortByDesc('moyAnnuelle')
        ->values();

        $resultats = $resultats->map(function($item) use ($resultats) {
            $item['rang'] = $resultats->filter(
                fn($other) => $other['moyAnnuelle'] > $item['moyAnnuelle']
            )->count() + 1;
            return $item;
        });

        return view('bulletins.proposition_passage', compact('composition', 'resultats'));
    }

    public function propositionPassagePdf($compositionId)
    {
        $composition = \App\Models\Composition::where('user_id', auth()->id())
            ->with('classe.eleves')
            ->findOrFail($compositionId);

        $moyenneService = new \App\Services\MoyenneService();
        $user = auth()->user();

        $classeActive = $user->classes()
            ->where('annee_scolaire', $user->annee_scolaire)
            ->latest()->first();

        $compositions = \App\Models\Composition::where('user_id', $user->id)
            ->where('classe_id', $classeActive?->id)
            ->orderBy('trimestre')
            ->get()
            ->keyBy('trimestre');

        $resultats = $composition->classe->eleves->map(function($eleve) use ($compositions, $moyenneService, $user) {
            $moyennes = [];
            foreach ([1, 2, 3] as $t) {
                $comp = $compositions->get($t);
                if (!$comp) { $moyennes[$t] = null; continue; }

                $notes = $eleve->notes()
                    ->where('composition_id', $comp->id)
                    ->whereNotNull('note')->get();

                if ($notes->count() > 0) {
                    $moyennes[$t] = $moyenneService->calculerMoyenneEleve($eleve, $comp);
                } else {
                    $mm = \App\Models\MoyenneManuelle::where('user_id', $user->id)
                        ->where('eleve_id', $eleve->id)
                        ->where('trimestre', $t)->first();
                    $moyennes[$t] = $mm ? $mm->moyenne : null;
                }
            }

            $moyennesValides = array_filter($moyennes, fn($m) => $m !== null);
            $moyAnnuelle = count($moyennesValides) > 0
                ? round(array_sum($moyennesValides) / count($moyennesValides), 2)
                : null;
            $decision = $moyAnnuelle !== null ? $moyenneService->getDecision($moyAnnuelle) : '—';
            return [
                'eleve'       => $eleve,
                'moyennes'    => $moyennes,
                'moyAnnuelle' => $moyAnnuelle,
                'decision'    => $decision,
            ];
        })
        ->sortByDesc('moyAnnuelle')
        ->values();

        $resultats = $resultats->map(function($item) use ($resultats) {
            $item['rang'] = $resultats->filter(
                fn($other) => $other['moyAnnuelle'] > $item['moyAnnuelle']
            )->count() + 1;
            return $item;
        });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bulletins.proposition_passage_pdf', compact(
            'composition', 'resultats'
        ))->setPaper('A4', 'landscape');

        return $pdf->download("Proposition_Passage_{$composition->classe->nom}.pdf");
    }
}