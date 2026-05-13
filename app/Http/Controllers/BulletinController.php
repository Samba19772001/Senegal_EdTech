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

    public function index()
    {
        $bulletins = Bulletin::where('user_id', auth()->id())
            ->with(['eleve', 'composition'])
            ->orderBy('rang')
            ->get()
            ->groupBy('composition_id');

        $compositions = Composition::where('user_id', auth()->id())
            ->with('classe')
            ->get();

        return view('bulletins.index', compact('bulletins', 'compositions'));
    }

    public function generer($compositionId)
    {
        $composition = Composition::where('user_id', auth()->id())
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

        return response()->download($path);
    }
}