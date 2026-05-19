<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_keys', function (Blueprint $table) {
            $table->id();
            $table->string('cle', 32)->unique();
            $table->boolean('est_utilisee')->default(false);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('note')->nullable(); // note admin ex: "Pour école de Dakar"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_keys');
    }
};