<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('moyennes_manuelles', function (Blueprint $table) {
            $table->string('annee_scolaire')->nullable()->after('trimestre');
            
            // Mettre à jour la contrainte unique
            $table->dropUnique(['eleve_id', 'trimestre']);
            $table->unique(['eleve_id', 'trimestre', 'annee_scolaire']);
        });
    }

    public function down(): void
    {
        Schema::table('moyennes_manuelles', function (Blueprint $table) {
            $table->dropColumn('annee_scolaire');
        });
    }

};
