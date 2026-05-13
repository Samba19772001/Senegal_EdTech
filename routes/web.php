<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/eleves', function () {
    return view('eleves.index');
})->name('eleves.index');
    Route::get('/matieres', function () {
    return view('matieres.index');
})->name('matieres.index');
    Route::get('/compositions', function () {
    return view('compositions.index');
})->name('compositions.index');
});

Route::get('/compositions/notes', function () {
    return view('compositions.notes');
})->name('compositions.notes');


Route::get('/bulletins', function () {
    return view('bulletins.index');
})->name('bulletins.index');



require __DIR__.'/auth.php';
