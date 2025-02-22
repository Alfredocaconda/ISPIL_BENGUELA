<?php

namespace App\Http\Controllers;

use App\Models\nota;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inscricao;
use App\Models\Curso;
use App\Models\Candidato;

class NotaController extends Controller
{
    public function index()
    {
    $inscricoes = inscricao::with(['candidato', 'curso'])->get(); // Carrega inscrições com candidato e curso
    return view('pages.admin.notas', compact('inscricoes'));
    }
    
    
    
        public function store(Request $request)
        {
            // Validação
            $request->validate([
                'candidato_id' => 'required|exists:candidatos,id',
                'curso_id' => 'required|exists:cursos,id',
                'nota' => 'required|numeric|min:0|max:10',
            ]);
    
            // Criar a nota
            $nota = Nota::create([
                'candidato_id' => $request->candidato_id,
                'curso_id' => $request->curso_id,
                'nota' => $request->nota,
            ]);
    
            $status = $nota->nota >= 7 ? 'Aprovado' : 'Reprovado';
    
            return view('notas.resultado', compact('nota', 'status'));
        }
        public function getCurso($candidato_id)
        {
            $candidato = Candidato::with('curso')->find($candidato_id);

            if ($candidato) {
                return response()->json([
                    'curso_id' => $candidato->curso->id,
                    'curso_nome' => $candidato->curso->nome
                ]);
            }

            return response()->json(['error' => 'Candidato não encontrado'], 404);
        }

    }
    