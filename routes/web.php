<?php

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

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Classes
    Route::get('/classes', [ClasseController::class, 'index'])->name('classes.index');
    Route::post('/classes', [ClasseController::class, 'store'])->name('classes.store');
    Route::delete('/classes/{id}', [ClasseController::class, 'destroy'])->name('classes.destroy');

    // Élèves
    Route::get('/eleves', [EleveController::class, 'index'])->name('eleves.index');
    Route::post('/eleves', [EleveController::class, 'store'])->name('eleves.store');
    Route::delete('/eleves/destroy-all', [EleveController::class, 'destroyAll'])->name('eleves.destroyAll');
    Route::put('/eleves/{id}', [EleveController::class, 'update'])->name('eleves.update');
    Route::delete('/eleves/{id}', [EleveController::class, 'destroy'])->name('eleves.destroy');
    Route::post('/eleves/import', [EleveController::class, 'import'])->name('eleves.import');

    // Matières
    Route::get('/matieres', [MatiereController::class, 'index'])->name('matieres.index');
    Route::post('/matieres', [MatiereController::class, 'store'])->name('matieres.store');
    Route::put('/matieres/{id}', [MatiereController::class, 'update'])->name('matieres.update');
    Route::delete('/matieres/{id}', [MatiereController::class, 'destroy'])->name('matieres.destroy');

    // Compositions
    Route::get('/compositions', [CompositionController::class, 'index'])->name('compositions.index');
    Route::post('/compositions', [CompositionController::class, 'store'])->name('compositions.store');
    Route::get('/compositions/{id}', [CompositionController::class, 'show'])->name('compositions.show');

    // Notes
    Route::get('/compositions/{composition}/matieres/{matiere}/notes', [NoteController::class, 'showMatiere'])->name('notes.showMatiere');
    Route::post('/compositions/{composition}/matieres/{matiere}/notes', [NoteController::class, 'storeMatiere'])->name('notes.storeMatiere');
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    // Bulletins
    Route::get('/bulletins', [BulletinController::class, 'index'])->name('bulletins.index');
    Route::get('/compositions/{composition}/generer', [BulletinController::class, 'generer'])->name('bulletins.generer');
    Route::get('/bulletins/{bulletin}/download', [BulletinController::class, 'download'])->name('bulletins.download');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Paramètres
    Route::get('/parametres', [ParametreController::class, 'index'])->name('parametres.index');
    Route::put('/parametres', [ParametreController::class, 'update'])->name('parametres.update');
});

require __DIR__.'/auth.php';