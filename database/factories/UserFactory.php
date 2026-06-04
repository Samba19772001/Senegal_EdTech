<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'nom'                  => fake()->lastName(),
            'prenom'               => fake()->firstName(),
            'email'                => fake()->unique()->safeEmail(),
            'email_verified_at'    => now(),
            'password'             => static::$password ??= Hash::make('password'),
            'telephone'            => fake()->phoneNumber(),
            'nom_ecole'            => fake()->company(),
            'type_ecole'           => fake()->randomElement(['publique', 'privee']),
            'region'               => fake()->randomElement(['Dakar', 'Thiès', 'Saint-Louis', 'Ziguinchor', 'Kaolack']),
            'departement'          => fake()->city(),
            'commune'              => fake()->city(),
            'annee_scolaire'       => '2024-2025',
            'niveau_enseignement'  => fake()->randomElement(['CI', 'CP', 'CE1', 'CE2', 'CM1', 'CM2']),
            'remember_token'       => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}