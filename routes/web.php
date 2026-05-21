<?php
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\CompositionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\ParametreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ✅ Routes admin — EN DEHORS du middleware auth
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::post('/users/{user}/bloquer',        [AdminController::class, 'bloquer'])->name('users.bloquer');
        Route::post('/users/{user}/debloquer',      [AdminController::class, 'debloquer'])->name('users.debloquer');
        Route::delete('/users/{user}',              [AdminController::class, 'supprimer'])->name('users.supprimer');
        Route::post('/users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('users.resetPassword');

        Route::get('/cles',          [AdminController::class, 'cles'])->name('cles.index');
        Route::post('/cles/generer', [AdminController::class, 'genererCles'])->name('cles.generer');
        Route::delete('/cles/{cle}', [AdminController::class, 'supprimerCle'])->name('cles.supprimer');
    });
});

// Routes utilisateurs normaux
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/classes', [ClasseController::class, 'index'])->name('classes.index');
    Route::post('/classes', [ClasseController::class, 'store'])->name('classes.store');
    Route::delete('/classes/{id}', [ClasseController::class, 'destroy'])->name('classes.destroy');

    Route::get('/eleves', [EleveController::class, 'index'])->name('eleves.index');
    Route::post('/eleves', [EleveController::class, 'store'])->name('eleves.store');
    Route::delete('/eleves/destroy-all', [EleveController::class, 'destroyAll'])->name('eleves.destroyAll');
    Route::put('/eleves/{id}', [EleveController::class, 'update'])->name('eleves.update');
    Route::delete('/eleves/{id}', [EleveController::class, 'destroy'])->name('eleves.destroy');
    Route::post('/eleves/import', [EleveController::class, 'import'])->name('eleves.import');
    Route::get('/eleves/suggestions', [EleveController::class, 'suggestions']);

    Route::get('/matieres', [MatiereController::class, 'index'])->name('matieres.index');
    Route::post('/matieres', [MatiereController::class, 'store'])->name('matieres.store');
    Route::put('/matieres/{id}', [MatiereController::class, 'update'])->name('matieres.update');
    Route::delete('/matieres/{id}', [MatiereController::class, 'destroy'])->name('matieres.destroy');

    Route::get('/compositions', [CompositionController::class, 'index'])->name('compositions.index');
    Route::post('/compositions', [CompositionController::class, 'store'])->name('compositions.store');
    Route::get('/compositions/{id}', [CompositionController::class, 'show'])->name('compositions.show');

    Route::get('/compositions/{composition}/matieres/{matiere}/notes', [NoteController::class, 'showMatiere'])->name('notes.showMatiere');
    Route::post('/compositions/{composition}/matieres/{matiere}/notes', [NoteController::class, 'storeMatiere'])->name('notes.storeMatiere');
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');

    Route::get('/bulletins', [BulletinController::class, 'index'])->name('bulletins.index');
    Route::get('/compositions/{composition}/generer', [BulletinController::class, 'generer'])->name('bulletins.generer');
    Route::get('/bulletins/{bulletin}/download', [BulletinController::class, 'download'])->name('bulletins.download');
    Route::get('/bulletins/{composition}/download-all', [BulletinController::class, 'downloadAll'])->name('bulletins.downloadAll');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/parametres', [ParametreController::class, 'index'])->name('parametres.index');
    Route::put('/parametres', [ParametreController::class, 'update'])->name('parametres.update');

    Route::get('/apropos', function () {
        return view('apropos.index');
    })->name('apropos.index');

    Route::get('/search-eleves', function (\Illuminate\Http\Request $request) {
        $q = $request->get('q', '');
        $eleves = \App\Models\Eleve::where('user_id', auth()->id())
            ->where(function($query) use ($q) {
                $query->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%");
            })
            ->with('classe')
            ->limit(6)
            ->get()
            ->map(fn($e) => [
                'id'     => $e->id,
                'nom'    => $e->nom,
                'prenom' => $e->prenom,
                'classe' => $e->classe->nom ?? '—',
            ]);
        return response()->json($eleves);
    })->name('search.eleves');
});

require __DIR__.'/auth.php';