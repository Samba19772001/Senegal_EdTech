<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bulletin;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $niveau = $user->niveau_enseignement;

        // =========================
        // STATS GLOBALES
        // =========================
        $totalEleves = $user->eleves()->count();

        $totalMatieres = \App\Models\Matiere::where('is_default', true)
            ->where('classe_niveau', $niveau)
            ->count()
            + $user->matieres()->count();

        $totalNotes = $user->notes()->count();
        $totalBulletins = $user->bulletins()->count();

        // =========================
        // DERNIÈRES NOTES
        // =========================
        $dernieresNotes = \App\Models\Note::where('user_id', $user->id)
            ->with(['eleve', 'matiere', 'composition'])
            ->latest()
            ->take(5)
            ->get();

        // =========================
        // 🔥 TRIMESTRES (OPTIMISÉ)
        // =========================
        $trimestres = Bulletin::query()
            ->selectRaw('compositions.trimestre as trimestre')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('AVG(bulletins.moyenne_generale) as moyenne')
            ->join('compositions', 'compositions.id', '=', 'bulletins.composition_id')
            ->where('bulletins.user_id', $user->id)
            ->groupBy('compositions.trimestre')
            ->get()
            ->keyBy('trimestre');

        // =========================
        // VIEW
        // =========================
        return view('dashboard', compact(
            'totalEleves',
            'totalMatieres',
            'totalNotes',
            'totalBulletins',
            'dernieresNotes',
            'trimestres'
        ));
    }
}