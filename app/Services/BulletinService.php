<?php

namespace App\Services;

use App\Models\Eleve;
use App\Models\Composition;
use App\Models\Bulletin;
use App\Models\Matiere;
use App\Models\Note;
use Barryvdh\DomPDF\Facade\Pdf;

class BulletinService
{
    protected MoyenneService $moyenneService;

    public function __construct(MoyenneService $moyenneService)
    {
        $this->moyenneService = $moyenneService;
    }

    public function genererBulletin(Eleve $eleve, Composition $composition): Bulletin
    {
        $moyenne    = $this->moyenneService->calculerMoyenneEleve($eleve, $composition);
        $mention    = $this->moyenneService->getMention($moyenne);
        $classement = $this->moyenneService->calculerClassement($composition);
        $rang       = $classement->firstWhere('eleve.id', $eleve->id)['rang'] ?? 0;

        $notes = $eleve->notes()
            ->where('composition_id', $composition->id)
            ->whereNotNull('note')
            ->with('matiere')
            ->get();

        // Rang par matière
        $niveau = $composition->classe->nom;
        $userId = $eleve->user_id;

        $toutesLesMatieres = Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) use ($userId, $niveau) {  // ← ajouter $niveau ici
            $q->where('user_id', $userId)
            ->where('is_default', false)
            ->where('classe_niveau', $niveau);
        })->orderBy('ordre')->get();

        $rangParMatiere = [];

        foreach ($toutesLesMatieres as $mat) {
            $notesMatiere = Note::where('composition_id', $composition->id)
                ->where('matiere_id', $mat->id)
                ->whereNotNull('note')
                ->orderByDesc('note')
                ->pluck('note', 'eleve_id');

            $noteEleve = $notesMatiere->get($eleve->id);

            if ($noteEleve !== null) {
                $rang_mat = 1;
                foreach ($notesMatiere as $eId => $n) {
                    if ($n > $noteEleve) $rang_mat++;
                }
                $rangParMatiere[$mat->id] = $rang_mat;
            }
        }

        // Calcul annuel si T3
        $moyenneAnnuelle = null;
        $rangAnnuel      = null;
        $decision        = null;

        if ($composition->trimestre == 3) {
            $moyenneAnnuelle  = $this->moyenneService->calculerMoyenneAnnuelle($eleve);
            $classementAnnuel = $this->moyenneService->calculerClassementAnnuel($composition);
            $rangAnnuel       = $classementAnnuel->firstWhere('eleve.id', $eleve->id)['rang'] ?? 0;
            $decision         = $moyenneAnnuelle !== null
                ? $this->moyenneService->getDecision($moyenneAnnuelle)
                : null;
        }

        $bulletin = Bulletin::updateOrCreate(
            [
                'user_id'        => $eleve->user_id,
                'composition_id' => $composition->id,
                'eleve_id'       => $eleve->id,
            ],
            [
                'moyenne_generale' => $moyenne,
                'rang'             => $rang,
                'mention'          => $mention,
            ]
        );

        $pdf = Pdf::loadView('bulletins.pdf', [
            'eleve'           => $eleve,
            'composition'     => $composition,
            'notes'           => $notes,
            'moyenne'         => $moyenne,
            'mention'         => $mention,
            'rang'            => $rang,
            'rangParMatiere'  => $rangParMatiere,
            'moyenneAnnuelle' => $moyenneAnnuelle,
            'rangAnnuel'      => $rangAnnuel,
            'decision'        => $decision,
        ]);

        $filename = "bulletin_{$eleve->id}_compo_{$composition->id}.pdf";
        $path     = storage_path("app/bulletins/{$filename}");

        if (!file_exists(storage_path('app/bulletins'))) {
            mkdir(storage_path('app/bulletins'), 0755, true);
        }

        $pdf->save($path);
        $bulletin->update(['pdf_path' => "bulletins/{$filename}"]);

        return $bulletin;
    }

    public function genererTousBulletins(Composition $composition): void
    {
        $eleves = $composition->classe->eleves;
        foreach ($eleves as $eleve) {
            $this->genererBulletin($eleve, $composition);
        }
    }
}