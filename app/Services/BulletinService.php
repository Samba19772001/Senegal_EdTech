<?php

namespace App\Services;

use App\Models\Eleve;
use App\Models\Composition;
use App\Models\Bulletin;
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
        $moyenne  = $this->moyenneService->calculerMoyenneEleve($eleve, $composition);
        $mention  = $this->moyenneService->getMention($moyenne);
        $classement = $this->moyenneService->calculerClassement($composition);
        $rang = $classement->firstWhere('eleve.id', $eleve->id)['rang'] ?? 0;

        $notes = $eleve->notes()
            ->where('composition_id', $composition->id)
            ->with('matiere')
            ->get();

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

        // Générer le PDF
        $pdf = Pdf::loadView('bulletins.pdf', [
            'eleve'       => $eleve,
            'composition' => $composition,
            'notes'       => $notes,
            'moyenne'     => $moyenne,
            'mention'     => $mention,
            'rang'        => $rang,
        ]);

        $filename = "bulletin_{$eleve->id}_compo_{$composition->id}.pdf";
        $path = storage_path("app/bulletins/{$filename}");

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