<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
  // App\Models\Curso.php
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'curso_id'); // Definindo o relacionamento reverso
    }

    // No modelo Curso
    public function matriculas()
    {
        return $this->hasMany(Matricula::class); // Um curso pode ter várias matrículas
    }

}
