<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;

class MatiereSeeder extends Seeder
{
    public function run(): void
    {
        $niveaux = [

            'CI' => [
                'Lecture'    => 10,
                'Écriture'   => 10,
                'Calcul'     => 10,
                'Récitation' => 10,
                'Dessin'     => 10,
                'Chant'      => 10,
            ],

            'CP' => [
                'Lecture'    => 10,
                'Écriture'   => 10,
                'Calcul'     => 10,
                'Récitation' => 10,
                'Dessin'     => 10,
                'Chant'      => 10,
            ],

            'CE1' => [
                // ✏️ Mets tes matières ici
                'Mots Familier'         => 10,
                'Mots Inventés'         => 10,
                'Fluidité'              => 10,
                'LC / Ressources'       => 20,
                'LC / Compétence'       => 20,
                'Maths / Ressources'    => 40,
                'Maths / Compétence'    => 20,
                'DM / Ressources'       => 24,
	            'DM / Compétence'       => 16,
                'EDD / Ressources'      => 24,
	            'EDD / Compétence'      => 16,
                'Éducation Artistique'  => 10,
                'Arabe'                 => 10,
            ],

            'CE2' => [
                // ✏️ Mets tes matières ici
                'LC / Ressources'       => 40,
	            'LC / Compétence'       => 60,
                'Maths / Ressources'    => 40,
	            'Maths / Compétence'    => 60,
                'DM / Ressources'       => 24,
	            'DM / Compétence'       => 16,
                'EDD / Ressources'      => 24,
	            'EDD / Compétence'      => 16,
                'Éducation Artistique'  => 10,
                'Arabe'                 => 10,
            ],

            'CM1' => [
                'LC / Ressources'       => 20,
	            'LC / Compétence'       => 20,
                'Maths / Ressources'    => 40,
	            'Maths / Compétence'    => 20,
                'DM / Ressources'       => 24,
	            'DM / Compétence'       => 16,
                'EDD / Ressources'      => 24,
	            'EDD / Compétence'      => 16,
                'Éducation Artistique'  => 10,
                'Arabe'                 => 10,
            ],

            'CM2' => [
                'LC / Ressources'       => 40,
	            'LC / Compétence'       => 60,
                'Maths / Ressources'    => 40,
	            'Maths / Compétence'    => 60,
                'DM / Ressources'       => 24,
	            'DM / Compétence'       => 16,
                'EDD / Ressources'      => 24,
	            'EDD / Compétence'      => 16,
                'Éducation Artistique'  => 10,
                'Arabe'                 => 10,
            ],

        ];

        foreach ($niveaux as $niveau => $matieres) {
            $index = 1;
            foreach ($matieres as $nom => $noteSur) {
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