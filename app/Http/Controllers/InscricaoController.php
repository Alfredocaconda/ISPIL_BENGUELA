<?php

namespace App\Http\Controllers;

use App\Models\inscricao;
use App\Models\Candidato;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Facades\MediaUploader;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
class InscricaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $cursos = Curso::find($request->curso_id); // Pega o curso da URL
        $valor=inscricao::all();
        return view('pages.candidato.inscricao',compact('valor','cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function inf_candidato()
    {
        //
        $valor = inscricao::all();
        $cursos = Curso::all();
        return view("pages.admin.inscricao", compact('valor', 'cursos'));
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifica se o usuário está autenticado
        $usuario = Auth::user();
        if (!$usuario) {
            return response()->json(['error' => 'Usuário não autenticado.'], 400);
        }
    
        // Buscar ou criar nova inscrição
        $valor = $request->id ? inscricao::find($request->id) : new inscricao();
        
        // Simulação de pagamento via API Multicaixa Express (antes do upload)
        if (!$this->processarPagamento($request->numero_cartao)) {
            return redirect()->back()->with('error', 'Erro no pagamento. Tente novamente.');
        }
    
        // Atribuindo o ID do usuário logado
        $valor->user_id = $usuario->id; // Aqui pegamos o ID do usuário logado diretamente
    
        // Preenchendo os dados do formulário
        $valor->email = $request->email;
        $valor->genero = $request->genero;
        $valor->provincia = $request->provincia;
        $valor->municipio = $request->municipio;
        $valor->naturalidade = $request->naturalidade;
        $valor->data_nasc = $request->data_nasc;
        $valor->n_bilhete = $request->n_bilhete;
        $valor->afiliacao = $request->afiliacao;
        $valor->telefone = $request->telefone;
        $valor->nome_escola = $request->nome_escola;
        $valor->curso_medio = $request->curso_medio;
        $valor->data_inicio = $request->data_inicio;
        $valor->data_termino = $request->data_termino;
        $valor->curso_id = $request->curso_id;
        $valor->data_inscricao = now();
        $valor->status = "Pendente";
    
        // Definindo o diretório para uploads com o nome ou ID do usuário
        $usuarioNome = $request->name ?? "Usuario_" . $valor->user_id;
    
        // Função para realizar o upload de arquivos
        $uploadFile = function ($file) use ($usuarioNome) {
            $directory = 'DocInscricao/' . $usuarioNome;
            return MediaUploader::fromSource($file)
                ->toDirectory($directory)
                ->onDuplicateIncrement()
                ->useFilename(md5($file->getClientOriginalName() . time()))
                ->setAllowedExtensions(['pdf', 'jpg', 'png', 'jpeg'])
                ->upload();
        };
    
        // Documentos para upload
        $documentos = ['certificado', 'recenciamento', 'atestado', 'bilhete', 'foto'];
    
        foreach ($documentos as $docName) {
            if ($request->hasFile($docName)) {
                $file = $request->file($docName);
                $doc = $uploadFile($file);
                $valor->$docName = $doc->basename;
            }
        }
    
        // Salvar a inscrição
        $valor->save();
    
        return view("pages.candidato.comprovativo");
    }
    

    
    private function processarPagamento($cartao)
    {
        $status = rand(0, 1) ? 'sucesso' : 'falha';
        \Log::info("Simulação de pagamento: {$status} para cartão {$cartao}");

        return $status === 'sucesso';
    }


  /*  private function processarPagamento($cartao)
    {
        // Aqui deve entrar a API da EMIS para pagamento Multicaixa Express
        // Por enquanto, simulamos um pagamento bem-sucedido
        $response = Http::post('https://api.emis.ao/pagar', [
            'cartao' => $cartao,
            'valor' => 5000,
            'referencia' => '123456789',
        ]);

        return $response->successful();
    }

    /**
     * Display the specified resource.
     */
    public function alterarStatus($id)
    {
        $dados = Inscricao::findOrFail($id);
    
        // Lista dos estados possíveis
        $estados = ['pendente', 'admitido', 'nao_admitido'];
    
        // Pega o índice do estado atual
        $indexAtual = array_search($dados->status, $estados);
    
        // Alterna para o próximo estado (cíclico)
        $novoIndex = ($indexAtual + 1) % count($estados);
        $dados->status = $estados[$novoIndex];
    
        $dados->save();
    
        return redirect()->back()->with('success', 'Status atualizado com sucesso!');
    }
    

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(inscricao $inscricao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, inscricao $inscricao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inscricao $inscricao)
    {
        //
    }
}
