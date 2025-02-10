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
            $table->string('name');
            $table->string('email');
            $table->String('genero');
            $table->string('provincia');
            $table->string('municipio');
            $table->string('naturalidade');
            $table->date('data_nasc');
            $table->string('n_bilhete');
            $table->string('afiliacao');
            $table->string('telefone');
            $table->string('nome_escola');
            $table->string('curso_medio');
            $table->date('date_inicio');
            $table->date('date_termino');
            $table->dateTime('data_inscricao');
            $table->string('curso_superior');
            $table->string('atestado');
            $table->string('certificado');
            $table->string('bilhete');
            $table->string('recenciamento');
            $table->string('foto');
            $table->string('status')->nullable();
            $table->foreignId('user_id')->constrained('users');
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
