<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nota extends Model
{
    use HasFactory;

    protected $fillable = ['candidato_id', 'curso_id', 'nota'];
    
    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
