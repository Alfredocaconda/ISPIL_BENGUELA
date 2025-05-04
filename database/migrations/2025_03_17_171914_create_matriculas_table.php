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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->String('genero');
            $table->string('n_bilhete')->unique();
            $table->string('telefone');
            $table->string('codigo_matricula');
            $table->timestamp('data_matricula');
            $table->string('certificado');
            $table->string('turno');
            $table->string('bilhete');
            $table->string('estado')->nullable();
            $table->boolean('reconfirmacao_pendente')->default(false);
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
