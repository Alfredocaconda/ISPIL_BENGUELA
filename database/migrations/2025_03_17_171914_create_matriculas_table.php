<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('matriculas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');         // quem fez a matrícula
        $table->unsignedBigInteger('estudante_id');    // quem está sendo matriculado
        $table->unsignedBigInteger('curso_id');
        $table->string('email');
        $table->string('telefone');
        $table->string('genero');
        $table->string('n_bilhete');
        $table->string('turno');
        $table->string('codigo_matricula')->nullable();
        $table->string('certificado')->nullable();
        $table->string('bilhete')->nullable();
        $table->string('estado')->default('matriculado'); // ou reconfirmado
        $table->boolean('reconfirmacao_pendente')->default(false);
        $table->date('data_matricula');
        $table->string('ano_academico');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('estudante_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
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
