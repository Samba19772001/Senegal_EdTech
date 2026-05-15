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
            ->whereNotNull('note') // absents exclus du calcul
            ->with('matiere')
            ->get();

        if ($notes->isEmpty()) {
            return 0;
        }

        $total = 0;
        $count = 0;

        foreach ($notes as $note) {
            $noteRamenee = $note->note * 10 / $note->matiere->note_sur;
            $total += $noteRamenee;
            $count++;
        }

        return $count > 0 ? round($total / $count, 2) : 0;
    }

    public function eleveADesNotes(Eleve $eleve, Composition $composition): bool
    {
        return $eleve->notes()
            ->where('composition_id', $composition->id)
            ->whereNotNull('note')
            ->exists();
    }

    public function getMention(float $moyenne): string
    {
        if ($moyenne < 5)  return 'Insuffisant';
        if ($moyenne < 7)  return 'Passable';
        if ($moyenne < 8)  return 'Assez Bien';
        if ($moyenne < 9)  return 'Bien';
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

        return $resultats->sortByDesc('moyenne')->values()->map(function ($item, $index) {
            $item['rang'] = $index + 1;
            return $item;
        });
    }

    public function calculerMoyenneAnnuelle(Eleve $eleve): ?float
    {
        $compositions = $eleve->user->compositions()
            ->whereIn('trimestre', [1, 2, 3])
            ->get();

        $moyennes = [];

        foreach ($compositions as $composition) {
            $notes = $eleve->notes()
                ->where('composition_id', $composition->id)
                ->whereNotNull('note') // absents exclus
                ->get();

            if ($notes->count() > 0) {
                $moyennes[] = $this->calculerMoyenneEleve($eleve, $composition);
            }
        }

        if (empty($moyennes)) return null;

        return round(array_sum($moyennes) / count($moyennes), 2);
    }

    public function getDecision(float $moyenneAnnuelle): string
    {
        return $moyenneAnnuelle >= 5
            ? 'Passe en classe supérieure'
            : 'Redouble';
    }

    public function calculerClassementAnnuel(Composition $compositionT3): Collection
    {
        $eleves = $compositionT3->classe->eleves;

        $resultats = $eleves->map(function ($eleve) {
            $moy = $this->calculerMoyenneAnnuelle($eleve);
            return [
                'eleve'   => $eleve,
                'moyenne' => $moy ?? 0,
            ];
        });

        return $resultats->sortByDesc('moyenne')->values()->map(function ($item, $index) {
            $item['rang'] = $index + 1;
            return $item;
        });
    }
}