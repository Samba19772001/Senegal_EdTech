<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalEleves    = $user->eleves()->count();
        $totalMatieres  = $user->matieres()->count() +
                          \App\Models\Matiere::where('is_default', true)
                            ->where('classe_niveau', $user->niveau_enseignement)
                            ->count();
        $totalNotes     = $user->notes()->count();
        $totalBulletins = $user->bulletins()->count();

        return view('dashboard', compact(
            'totalEleves',
            'totalMatieres',
            'totalNotes',
            'totalBulletins'
        ));
    }
}