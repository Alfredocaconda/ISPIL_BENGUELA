<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
    
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
