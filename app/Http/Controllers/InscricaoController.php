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
    
            // Verifica se a inscrição já existe ou cria uma nova
        $valor = isset($request->id) ? inscricao::find($request->id) : new inscricao();

        // Simulação de pagamento via API Multicaixa Express (antes do upload)
        if (!$this->processarPagamento($request->numero_cartao)) {
            return redirect()->back()->with('error', 'Erro no pagamento. Tente novamente.');
        }
        // Inicializa ou encontra a inscrição
        $valor = null;
        if (isset($request->id)) {
            $valor = inscricao::find($request->id);
        } else {
            $valor = new inscricao();
        }
            // Definindo o nome ou ID do candidato para criar a pasta
            $candidatoNome = $request->name; // Ou você pode usar o ID do candidato, por exemplo, $request->id

            // Função para realizar o upload de arquivos
            $uploadFile = function ($file, $campo) use ($candidatoNome) {
            $directory = 'DocInscricao/' . $candidatoNome; // Definir o diretório do candidato
            return MediaUploader::fromSource($file)
            ->toDirectory($directory) // Usando o diretório específico do candidato
            ->onDuplicateIncrement()
            ->useFilename(md5($file->getClientOriginalName() . time())) // Gerando nome único
            ->setAllowedExtensions(['pdf', 'jpg', 'png', 'jpeg'])
            ->upload();
        };

        // Verificar e fazer o upload dos documentos
        if (request()->hasFile('certificado')) {
            $file = request()->file('certificado');
            $doc = $uploadFile($file, 'certificado');
            $valor->certificado = $doc->basename;
        }

        if (request()->hasFile('recenciamento')) {
            $file = request()->file('recenciamento');
            $doc = $uploadFile($file, 'recenciamento');
            $valor->recenciamento = $doc->basename;
        }

        if (request()->hasFile('atestado')) {
            $file = request()->file('atestado');
            $doc = $uploadFile($file, 'atestado');
            $valor->atestado = $doc->basename;
        }

        if (request()->hasFile('bilhete')) {
            $file = request()->file('bilhete');
            $doc = $uploadFile($file, 'bilhete');
            $valor->bilhete = $doc->basename;
        }

        if (request()->hasFile('foto')) {
            $file = request()->file('foto');
            $doc = $uploadFile($file, 'foto');
            $valor->foto = $doc->basename;
        }
       
        // Preenchendo os dados do formulário
        $valor->candidato_id = $request->candidato_id;
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
        $valor->date_inicio = $request->date_inicio;
        $valor->date_termino = $request->date_termino;
        $valor->curso_Id = $request->curso_Id;
        $valor->data_inscricao = now(); // Usando o helper now() do Laravel
        $valor->status="Pendente";
         // Associando o candidato à inscrição (supondo que o usuário autenticado seja um candidato)
        $valor->candidato_id = Auth::user()->Candidato->id;
        $valor->save();

        return view("pages.estudante.comprovativo");
        
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
