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
            $table->string('nome_completo');
            $table->string('genero');
            $table->date('dt_nascimento');
            $table->string('nome_escola');
            $table->string('provincia');
            $table->string('naturalidade');
            $table->string('numero_bilhete');
            $table->string('pdf_certificado');
            $table->string('pdf_bilhete');
            $table->string('foto');
            $table->string('telefone')->unique();
            $table->string('curso_medio');
            $table->string('curso_superior');
            $table->string('periodo');
            $table->string('data_inscricao');
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
