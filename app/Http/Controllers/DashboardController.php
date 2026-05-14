<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $niveau = $user->niveau_enseignement;

        $totalEleves = $user->eleves()->count();

        $totalMatieres = \App\Models\Matiere::where('is_default', true)
            ->where('classe_niveau', $niveau)
            ->count() + $user->matieres()->count();

        $totalNotes     = $user->notes()->count();
        $totalBulletins = $user->bulletins()->count();

        $dernieresNotes = \App\Models\Note::where('user_id', $user->id)
            ->with(['eleve', 'matiere', 'composition'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalEleves',
            'totalMatieres',
            'totalNotes',
            'totalBulletins',
            'dernieresNotes'
        ));
    }
}