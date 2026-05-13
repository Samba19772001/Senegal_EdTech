<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;

class MatiereSeeder extends Seeder
{
    public function run(): void
    {
        // CI et CP — tout sur 10
        $niveauxSur10 = ['CI', 'CP'];
        $matieresSur10 = [
            'Lecture', 'Écriture', 'Calcul', 'Langage',
            'Récitation', 'Dessin', 'Chant'
        ];

        foreach ($niveauxSur10 as $niveau) {
            foreach ($matieresSur10 as $index => $nom) {
                Matiere::create([
                    'user_id'       => null,
                    'classe_niveau' => $niveau,
                    'nom'           => $nom,
                    'note_sur'      => 10,
                    'is_default'    => true,
                    'ordre'         => $index + 1,
                ]);
            }
        }

        // CE1 et CE2
        $niveauxCE = ['CE1', 'CE2'];
        $matieresCE = [
            'Français'           => 40,
            'Mathématiques'      => 40,
            'Histoire-Géographie'=> 20,
            'Sciences'           => 20,
            'Éducation Civique'  => 10,
            'Dessin'             => 10,
            'Sport'              => 10,
        ];

        foreach ($niveauxCE as $niveau) {
            $index = 1;
            foreach ($matieresCE as $nom => $noteSur) {
                Matiere::create([
                    'user_id'       => null,
                    'classe_niveau' => $niveau,
                    'nom'           => $nom,
                    'note_sur'      => $noteSur,
                    'is_default'    => true,
                    'ordre'         => $index++,
                ]);
            }
        }

        // CM1 et CM2
        $niveauxCM = ['CM1', 'CM2'];
        $matieresCM = [
            'Français'           => 40,
            'Mathématiques'      => 40,
            'Histoire-Géographie'=> 20,
            'Sciences'           => 20,
            'Éducation Civique'  => 10,
            'Anglais'            => 20,
            'Dessin'             => 10,
            'Sport'              => 10,
        ];

        foreach ($niveauxCM as $niveau) {
            $index = 1;
            foreach ($matieresCM as $nom => $noteSur) {
                Matiere::create([
                    'user_id'       => null,
                    'classe_niveau' => $niveau,
                    'nom'           => $nom,
                    'note_sur'      => $noteSur,
                    'is_default'    => true,
                    'ordre'         => $index++,
                ]);
            }
        }
    }
}