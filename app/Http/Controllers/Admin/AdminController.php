<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AccessKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total'    => User::count(),
            'actifs'   => User::where('is_blocked', false)->count(),
            'bloques'  => User::where('is_blocked', true)->count(),
            'cles_disponibles' => AccessKey::where('est_utilisee', false)->count(),
        ];

        $users = User::latest()->paginate(15);

        return view('admin.dashboard', compact('stats', 'users'));
    }

    public function bloquer(User $user)
    {
        $user->update(['is_blocked' => true]);
        return redirect()->route('admin.dashboard')
            ->with('success', "Compte de {$user->prenom} {$user->nom} bloqué.");
    }

    public function debloquer(User $user)
    {
        $user->update(['is_blocked' => false]);
        return redirect()->route('admin.dashboard')
            ->with('success', "Compte de {$user->prenom} {$user->nom} débloqué.");
    }


    public function resetPassword(User $user)
    {
        $nouveauMdp = Str::random(10);
        $user->update(['password' => Hash::make($nouveauMdp)]);
        return redirect()->route('admin.dashboard')
            ->with('success', "Mot de passe réinitialisé : {$nouveauMdp}");
    }

    public function supprimer(User $user)
    {
        $user->delete();
        return redirect()->route('admin.dashboard')
            ->with('success', 'Compte supprimé.');
    }

    // Gestion des clés
    public function cles()
    {
        $cles = AccessKey::with('user')->latest()->paginate(20);
        return view('admin.cles', compact('cles'));
    }

    public function genererCles(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'integer', 'min:1', 'max:50'],
            'note'   => ['nullable', 'string', 'max:100'],
        ]);

        for ($i = 0; $i < $request->nombre; $i++) {
            AccessKey::create([
                'cle'          => strtoupper(Str::random(4).'-'.Str::random(4).'-'.Str::random(4)),
                'est_utilisee' => false,
                'note'         => $request->note,
            ]);
        }

        return back()->with('success', "{$request->nombre} clé(s) générée(s) avec succès.");
    }

    public function supprimerCle(AccessKey $cle)
    {
        if ($cle->est_utilisee) {
            return back()->withErrors(['error' => 'Impossible de supprimer une clé déjà utilisée.']);
        }
        $cle->delete();
        return back()->with('success', 'Clé supprimée.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'), true)) { // ← true = remember me
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }
}