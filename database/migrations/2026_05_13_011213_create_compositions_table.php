<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classe_id')->constrained('classes')->cascadeOnDelete();
            $table->tinyInteger('trimestre');
            $table->string('libelle', 100);
            $table->date('date_composition')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
            $table->unique(['classe_id', 'trimestre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compositions');
    }
};