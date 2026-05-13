<?php

namespace App\Services;

use App\Models\Eleve;
use App\Models\Composition;
use Illuminate\Support\Collection;

class MoyenneService
{
    public function calculerMoyenneEleve(Eleve $eleve, Composition $composition): float
    {
        $notes = $eleve->notes()
            ->where('composition_id', $composition->id)
            ->with('matiere')
            ->get();

        if ($notes->isEmpty()) {
            return 0;
        }

        $total = 0;
        foreach ($notes as $note) {
            $noteRamenee = $note->note * 10 / $note->matiere->note_sur;
            $total += $noteRamenee;
        }

        return round($total / $notes->count(), 2);
    }

    public function getMention(float $moyenne): string
    {
        if ($moyenne < 5)       return 'Insuffisant';
        if ($moyenne < 7)       return 'Passable';
        if ($moyenne < 8)       return 'Assez Bien';
        if ($moyenne < 9)       return 'Bien';
        return 'Très Bien';
    }

    public function calculerClassement(Composition $composition): Collection
    {
        $eleves = $composition->classe->eleves;

        $resultats = $eleves->map(function ($eleve) use ($composition) {
            return [
                'eleve'   => $eleve,
                'moyenne' => $this->calculerMoyenneEleve($eleve, $composition),
            ];
        });

        $sorted = $resultats->sortByDesc('moyenne')->values();

        return $sorted->map(function ($item, $index) {
            $item['rang'] = $index + 1;
            return $item;
        });
    }
}