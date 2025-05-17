<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matricula extends Model
{
    use HasFactory;
    protected $fillable = [
    'user_id',
    'estudante_id',
    'curso_id',
    'email',
    'genero',
    'n_bilhete',
    'telefone',
    'turno',
    'ano_academico',
    'data_matricula',
    'estado',
    'certificado',
    'bilhete',
    'codigo_matricula',
    'reconfirmacao_pendente',
];
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
     // O estudante que está sendo matriculado
    public function estudante()
    {
        return $this->belongsTo(User::class, 'estudante_id');
    }

}
