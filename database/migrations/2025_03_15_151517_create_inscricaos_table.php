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
            $table->string('codigo_inscricao');
            $table->string('email');
            $table->string('genero'); 
            $table->string('provincia');
            $table->string('municipio');
            $table->string('naturalidade');
            $table->date('data_nasc');
            $table->string('n_bilhete')->unique();
            $table->string('afiliacao');
            $table->string('telefone')->unique();
            $table->string('nome_escola');
            $table->string('curso_medio');
            $table->date('data_inicio'); // Corrigido nome
            $table->date('data_termino'); // Corrigido nome
            $table->dateTime('data_inscricao')->default(now()); // Padrão para a data de inscrição
            $table->string('certificado');
            $table->string('bilhete');
            $table->string('recenciamento')->nullable();
            $table->string('foto');
            $table->string('status')->nullable()->default('Pendente'); // Define um valor padrão
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade'); // Corrigido nome
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
