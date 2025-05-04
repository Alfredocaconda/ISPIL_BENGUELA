<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matricula extends Model
{
    use HasFactory;
        // No modelo Matricula
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id'); // Relacionamento com a tabela de cursos
    }
     // Relação com o usuário
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id'); // Certifique-se de que a chave estrangeira está correta
     }

}
