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

    public function index(Request $request)
    {
        $trimestreActif = $request->get('trimestre', 1);
        $user = auth()->user();

        // Récupérer la classe active
        $classeActive = \App\Models\Classe::where('user_id', $user->id)
            ->where('annee_scolaire', $user->annee_scolaire)
            ->latest()
            ->first();

        $composition = null;
        $bulletinsComposition = collect();

        if ($classeActive) {
            $composition = \App\Models\Composition::where('user_id', $user->id)
                ->where('classe_id', $classeActive->id)
                ->where('trimestre', $trimestreActif)
                ->with('classe.eleves')
                ->first();

            if ($composition) {
                $bulletinsComposition = \App\Models\Bulletin::where('user_id', $user->id)
                    ->where('composition_id', $composition->id)
                    ->with('eleve')
                    ->get();
            }
        }

        return view('bulletins.index', compact(
            'trimestreActif',
            'composition',
            'bulletinsComposition'
        ));
    }
   public function generer($compositionId)
    {
        $composition = \App\Models\Composition::where('user_id', auth()->id())
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

        $nomEleve = $bulletin->eleve->prenom . '_' . $bulletin->eleve->nom;
        $filename = "{$nomEleve}_T{$bulletin->composition->trimestre}.pdf";

        return response()->download($path, $filename);
    }

    public function downloadAll($compositionId)
    {
        $composition = \App\Models\Composition::where('user_id', auth()->id())
            ->findOrFail($compositionId);

        $bulletins = \App\Models\Bulletin::where('user_id', auth()->id())
            ->where('composition_id', $compositionId)
            ->with('eleve')
            ->get();

        if ($bulletins->isEmpty()) {
            return redirect()->back()->withErrors(['zip' => 'Aucun bulletin à télécharger.']);
        }

        $zipFilename = "bulletins_T{$composition->trimestre}.zip";

        $zip = new \ZipStream\ZipStream(
            outputName: $zipFilename,
            sendHttpHeaders: true,
        );
        foreach ($bulletins as $bulletin) {
            $pdfPath = storage_path('app/' . $bulletin->pdf_path);
            if (file_exists($pdfPath)) {
                $nomEleve = $bulletin->eleve->prenom . '_' . $bulletin->eleve->nom;
                $zip->addFileFromPath(
                    "{$nomEleve}_T{$composition->trimestre}.pdf",
                    $pdfPath
                );
            }
        }

        $zip->finish();
    }
}