<?php

namespace App\Http\Controllers;

use App\Models\Composition;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Bulletin;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $niveau = $user->niveau_enseignement;

        $classeActive = $user->classes()
            ->where('annee_scolaire', $user->annee_scolaire)
            ->latest()->first();

        if (!$classeActive) {
            return view('statistiques.index', [
                'statsParTrimestre' => [],
                'statsGlobales'     => null,
                'trimestreActif'    => 1,
            ]);
        }

        $compositions = Composition::where('user_id', $user->id)
            ->where('classe_id', $classeActive->id)
            ->orderBy('trimestre')
            ->get()
            ->keyBy('trimestre');

        $matieres = Matiere::where(function($q) use ($niveau) {
            $q->where('is_default', true)->where('classe_niveau', $niveau);
        })->orWhere(function($q) use ($niveau, $user) {
            $q->where('user_id', $user->id)
              ->where('is_default', false)
              ->where('classe_niveau', $niveau);
        })->orderBy('ordre')->get();

        $eleves = $classeActive->eleves;
        $totalGarcons = $eleves->where('sexe', 'M')->count();
        $totalFilles  = $eleves->where('sexe', 'F')->count();

        $statsParTrimestre = [];

        foreach ($compositions as $trimestre => $composition) {
            $statsParMatiere = [];

            foreach ($matieres as $matiere) {
                $notes = Note::where('composition_id', $composition->id)
                    ->where('matiere_id', $matiere->id)
                    ->whereNotNull('note')
                    ->with('eleve')
                    ->get();

                if ($notes->isEmpty()) continue;

                $garconsMoyenne   = 0;
                $garconsSansMoy   = 0;
                $fillesMoyenne    = 0;
                $fillesSansMoy    = 0;
                $absentsG         = 0;
                $absentsF         = 0;
                $totalPoints      = 0;
                $noteMax          = null;
                $noteMin          = null;
                $eleveMax         = null;
                $eleveMin         = null;

                // Compter les absents
                $tousLesEleves = $eleves;
                $elevesAvecNote = $notes->pluck('eleve_id')->toArray();

                foreach ($tousLesEleves as $eleve) {
                    if (!in_array($eleve->id, $elevesAvecNote)) {
                        if ($eleve->sexe == 'M') $absentsG++;
                        else $absentsF++;
                    }
                }

                foreach ($notes as $note) {
                    $nr = $note->note * 10 / $matiere->note_sur;
                    $totalPoints += $nr;

                    if ($noteMax === null || $nr > $noteMax) {
                        $noteMax = $nr;
                        $eleveMax = $note->eleve->prenom . ' ' . $note->eleve->nom;
                    }
                    if ($noteMin === null || $nr < $noteMin) {
                        $noteMin = $nr;
                        $eleveMin = $note->eleve->prenom . ' ' . $note->eleve->nom;
                    }

                    if ($note->eleve->sexe == 'M') {
                        if ($nr >= 5) $garconsMoyenne++;
                        else $garconsSansMoy++;
                    } else {
                        if ($nr >= 5) $fillesMoyenne++;
                        else $fillesSansMoy++;
                    }
                }

                $moyenneMatiere = $notes->count() > 0 ? round($totalPoints / $notes->count(), 2) : null;
                $tauxReussite   = ($notes->count() > 0)
                    ? round(($garconsMoyenne + $fillesMoyenne) / $notes->count() * 100)
                    : 0;

                $statsParMatiere[] = [
                    'matiere'         => $matiere,
                    'garconsMoyenne'  => $garconsMoyenne,
                    'garconsSansMoy'  => $garconsSansMoy,
                    'fillesMoyenne'   => $fillesMoyenne,
                    'fillesSansMoy'   => $fillesSansMoy,
                    'absentsG'        => $absentsG,
                    'absentsF'        => $absentsF,
                    'moyenne'         => $moyenneMatiere,
                    'noteMax'         => $noteMax ? round($noteMax, 2) : null,
                    'noteMin'         => $noteMin ? round($noteMin, 2) : null,
                    'eleveMax'        => $eleveMax,
                    'eleveMin'        => $eleveMin,
                    'tauxReussite'    => $tauxReussite,
                    'totalNotes'      => $notes->count(),
                ];
            }

            // Stats bulletins du trimestre
            $bulletins = Bulletin::where('composition_id', $composition->id)->get();
            $mentionsCount = [
                'Très Bien'   => $bulletins->where('mention', 'Très Bien')->count(),
                'Bien'        => $bulletins->where('mention', 'Bien')->count(),
                'Assez Bien'  => $bulletins->where('mention', 'Assez Bien')->count(),
                'Passable'    => $bulletins->where('mention', 'Passable')->count(),
                'Insuffisant' => $bulletins->where('mention', 'Insuffisant')->count(),
            ];

            $statsParTrimestre[$trimestre] = [
                'composition'     => $composition,
                'statsParMatiere' => $statsParMatiere,
                'mentionsCount'   => $mentionsCount,
                'moyenneClasse'   => $bulletins->avg('moyenne_generale'),
                'meilleurEleve'   => $bulletins->sortByDesc('moyenne_generale')->first()?->load('eleve'),
                'plusFaible'      => $bulletins->sortBy('moyenne_generale')->first()?->load('eleve'),
                'totalBulletins'  => $bulletins->count(),
            ];
        }

        // Stats globales annuelles
        $tousLesBulletins = Bulletin::where('user_id', $user->id)
            ->whereIn('composition_id', $compositions->pluck('id'))
            ->with('eleve')
            ->get();

        $statsGlobales = [
            'totalEleves'   => $eleves->count(),
            'totalGarcons'  => $totalGarcons,
            'totalFilles'   => $totalFilles,
            'moyenneGlobale'=> round($tousLesBulletins->avg('moyenne_generale'), 2),
        ];

        $trimestreActif = $request->get('trimestre', $compositions->keys()->first() ?? 1);

        return view('statistiques.index', compact(
            'statsParTrimestre',
            'statsGlobales',
            'trimestreActif'
        ));
    }
}