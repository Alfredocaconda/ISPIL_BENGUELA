<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;

    protected $fillable = [
        'nota', 'estado', 'codigo_inscricao', 'email', 'genero', 'provincia',
        'municipio', 'naturalidade', 'data_nasc', 'n_bilhete', 'afiliacao',
        'telefone', 'nome_escola', 'curso_medio', 'data_inicio', 'data_termino',
        'data_inscricao', 'certificado', 'bilhete', 'recenciamento', 'foto',
        'curso_id', 'user_id'
    ];

    // Quando a nota for atualizada, mudar o status automaticamente
    public function setNotaAttribute($value)
    {
        $this->attributes['nota'] = $value;
        $this->attributes['estado'] = ($value >= 10) ? 'Admitido' : 'Não Admitido';
    }
    // Relação com o usuário
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Certifique-se de que a chave estrangeira está correta
    }

    // Relacionamento com Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
