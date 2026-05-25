<?php

namespace App\Http\Controllers;

use App\Models\Composition;
use App\Models\MoyenneManuelle;
use Illuminate\Http\Request;

class MoyenneManuellController extends Controller
{
    public function index($compositionId)
    {
        $composition = Composition::where('user_id', auth()->id())
            ->with('classe.eleves')
            ->findOrFail($compositionId);

        $eleves = $composition->classe->eleves;

        // Trouver les trimestres manquants
        $trimestresDisponibles = Composition::where('user_id', auth()->id())
            ->where('classe_id', $composition->classe_id)
            ->whereIn('trimestre', [1, 2])
            ->get()
            ->filter(function($comp) use ($eleves) {
                // Un trimestre est disponible si au moins un élève a des notes
                return $comp->notes()->whereNotNull('note')->count() > 0;
            })
            ->pluck('trimestre')
            ->toArray();

        $trimestresManquants = array_diff([1, 2], $trimestresDisponibles);

        // Récupérer les moyennes manuelles déjà saisies
        $moyennesExistantes = MoyenneManuelle::where('user_id', auth()->id())
            ->whereIn('eleve_id', $eleves->pluck('id'))
            ->whereIn('trimestre', $trimestresManquants)
            ->get()
            ->groupBy('trimestre');

        // Si aucun trimestre manquant → rediriger vers génération bulletins
        if (empty($trimestresManquants)) {
            return redirect()->route('bulletins.generer', $compositionId);
        }

        return view('compositions.moyennes_manuelles', compact(
            'composition',
            'eleves',
            'trimestresManquants',
            'moyennesExistantes'
        ));
    }

    public function store(Request $request, $compositionId)
    {
        $composition = Composition::where('user_id', auth()->id())
            ->findOrFail($compositionId);

        $request->validate([
            'moyennes'         => ['required', 'array'],
            'moyennes.*.*'     => ['nullable', 'numeric', 'min:0', 'max:10'],
        ]);

        foreach ($request->moyennes as $trimestre => $eleveMoyennes) {
            foreach ($eleveMoyennes as $eleveId => $moyenne) {
                if ($moyenne !== null && $moyenne !== '') {
                    MoyenneManuelle::updateOrCreate(
                        [
                            'user_id'   => auth()->id(),
                            'eleve_id'  => $eleveId,
                            'trimestre' => $trimestre,
                        ],
                        [
                            'moyenne' => $moyenne,
                        ]
                    );
                }
            }
        }

        return redirect()->route('bulletins.generer', $compositionId)
            ->with('success', 'Moyennes enregistrées ! Génération des bulletins en cours...');
    }
}