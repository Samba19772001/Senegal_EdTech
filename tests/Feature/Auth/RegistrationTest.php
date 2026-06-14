<?php

namespace Tests\Feature\Auth;

use App\Models\AccessKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        // Créer une clé d'accès valide pour le test
        AccessKey::create([
            'cle'          => 'TEST-KEY-123',
            'est_utilisee' => false,
        ]);

        $response = $this->post('/register', [
            'nom'                  => 'Diallo',
            'prenom'               => 'Moussa',
            'email'                => 'test@example.com',
            'password'             => 'Password123!',
            'password_confirmation'=> 'Password123!',
            'telephone'            => '770000000',
            'nom_ecole'            => 'École Test',
            'type_ecole'           => 'publique',
            'region'               => 'Dakar',
            'departement'          => 'Dakar',
            'commune'              => 'Plateau',
            'annee_scolaire'       => '2024-2025',
            'niveau_enseignement'  => 'CE1',
            'access_key'           => 'TEST-KEY-123',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}