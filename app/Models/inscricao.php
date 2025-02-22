<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;

    // Relacionamento com Candidato
    public function candidato()
    {
        return $this->belongsTo(Candidato::class, 'candidato_id');
    }

    // Relacionamento com Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
