<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_usuario')->constrained('usuarios')->cascadeOnDelete();

            $table->foreignId('id_curso')->constrained('cursos')->cascadeOnDelete();

            $table->timestamps();

            // Evita duplicidade (mesmo usuário no mesmo curso)
            $table->unique(['id_usuario', 'id_curso']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
