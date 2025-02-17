<?php

namespace App\Http\Controllers;

use App\Models\matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=matricula::all();
        return view('pages.estudante.matricula',compact('valor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
            // Verifica se a inscrição já existe ou cria uma nova
        $valor = isset($request->id) ? Matricula::find($request->id) : new Matricula();

        // Simulação de pagamento via API Multicaixa Express (antes do upload)
        if (!$this->processarPagamento($request->numero_cartao)) {
            return redirect()->back()->with('error', 'Erro no pagamento. Tente novamente.');
        }
        // Inicializa ou encontra a inscrição
        $valor = null;
        if (isset($request->id)) {
            $valor = matricula::find($request->id);
        } else {
            $valor = new matricula();
        }
            // Definindo o nome ou ID do candidato para criar a pasta
            $candidatoNome = $request->name; // Ou você pode usar o ID do candidato, por exemplo, $request->id

            // Função para realizar o upload de arquivos
            $uploadFile = function ($file, $campo) use ($candidatoNome) {
            $directory = 'DocMatricula/' . $candidatoNome; // Definir o diretório do candidato
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
        $valor->name = $request->name;
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
        $valor->data_Matricula = now(); // Usando o helper now() do Laravel
        $valor->status = "Enviado";
        $valor->user_id = Auth::user()->Candidato->id;

         // Geração do Código de Matrícula
        $anoIngresso = now()->format('Y'); // Ano atual
        $codigoCurso = str_pad($request->curso_Id, 3, '0', STR_PAD_LEFT); // Código do curso com 3 dígitos
        $ultimoId = Matricula::max('id') + 1; // Obtendo o próximo ID da tabela
        $codigoMatricula = "{$anoIngresso}{$codigoCurso}" . str_pad($ultimoId, 4, '0', STR_PAD_LEFT);

        $valor->codigo_matricula = $codigoMatricula; // Salvando no banco
        $valor->save();

        // Gerar o PDF com o código de matrícula
        $data = [
            'valor' => $valor,
            'codigo_matricula' => $codigoMatricula, // Passando o código para a view
        ];
        $pdf = Pdf::loadView('pages.estudante.comprovativo', $data);
        return $pdf->download('comprovativo.pdf');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(matricula $matricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function reconfirmar(Request $request)
    {
    // Buscar a matrícula do estudante pelo ID ou código de matrícula
    $matricula = Matricula::where('user_id', Auth::id())->first();

    // Verificar se a matrícula existe
    if (!$matricula) {
        return redirect()->back()->with('error', 'Matrícula não encontrada.');
    }

    // Simulação de pagamento via API Multicaixa Express
    if (!$this->processarPagamento($request->numero_cartao)) {
        return redirect()->back()->with('error', 'Erro no pagamento. Tente novamente.');
    }

    // Atualizar status da matrícula
    $matricula->status = 'Confirmado';
    $matricula->data_confirmacao = now();
    $matricula->save();

    // Gerar comprovativo de matrícula confirmada
        $data = [
            'matricula' => $matricula
        ];
    
        $pdf = Pdf::loadView('pages.estudante.comprovativo_confirmacao', $data);
        
        return $pdf->download('comprovativo_confirmacao.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     */
        public function reconfirmacaoView()
    {
        $matricula = Matricula::where('user_id', Auth::id())->first();

        if (!$matricula) {
            return redirect()->back()->with('error', 'Matrícula não encontrada.');
        }

        return view('pages.estudante.reconfirmacao', compact('matricula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function baixarComprovativo()
    {
        $matricula = Matricula::where('user_id', Auth::id())->first();

        if (!$matricula || $matricula->status !== 'Confirmado') {
            return redirect()->back()->with('error', 'Matrícula não confirmada.');
        }

        $data = ['matricula' => $matricula];
        $pdf = Pdf::loadView('pages.estudante.comprovativo', $data);
        
        return $pdf->download('comprovativo_confirmacao.pdf');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, matricula $matricula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(matricula $matricula)
    {
        //
    }
}
