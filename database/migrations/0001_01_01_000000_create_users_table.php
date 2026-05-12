<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone', 20)->nullable();
            $table->string('nom_ecole', 150);
            $table->enum('type_ecole', ['publique', 'privee']);
            $table->string('region', 100);
            $table->string('departement', 100)->nullable();
            $table->string('commune', 100)->nullable();
            $table->string('annee_scolaire', 9);
            $table->string('niveau_enseignement', 20);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};