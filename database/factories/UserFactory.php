<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'telephone' => fake()->numerify('##########'),
            'nom_ecole' => fake()->word(),
            'type_ecole' => fake()->randomElement(['publique', 'privee']),
            'region' => fake()->word(),
            'departement' => fake()->word(),
            'commune' => fake()->word(),
            'annee_scolaire' => '2025-2026',
            'niveau_enseignement' => fake()->randomElement(['CP', 'CE1', 'CE2']),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
