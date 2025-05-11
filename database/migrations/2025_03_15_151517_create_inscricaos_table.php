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
            Schema::create('inscricaos', function (Blueprint $table) {
            $table->id();
            $table->decimal('nota', 5, 2)->nullable(); // Adiciona a coluna para a nota
            $table->string('codigo_inscricao');
            $table->string('email');
            $table->string('genero'); 
            $table->date('data_nasc');
            $table->string('n_bilhete');
            $table->string('telefone');
            $table->string('nome_escola');
            $table->string('curso_medio');
            $table->dateTime('data_inscricao')->default(now()); // Padrão para a data de inscrição
            $table->string('certificado');
            $table->string('bilhete');
            $table->string('comprovativo');
            $table->string('periodo');
            $table->string('foto');
            $table->string('estado')->nullable()->default('Pendente'); // Define um valor padrão
            $table->foreignId('curso_id')->unique()->constrained('cursos')->onDelete('cascade'); // Corrigido nome
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
                
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricaos');
    }
};
