<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moyennes_manuelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('eleve_id')->constrained('eleves')->cascadeOnDelete();
            $table->tinyInteger('trimestre'); // 1, 2 ou 3
            $table->decimal('moyenne', 4, 2); // moyenne sur 10
            $table->timestamps();
            $table->unique(['eleve_id', 'trimestre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moyennes_manuelles');
    }
};