<?php

namespace App\Http\Controllers;

use App\Models\matricula;
use App\Models\Candidato;
use App\Models\inscricao;
use App\Models\curso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Facades\MediaUploader;
use Illuminate\Support\Facades\Mail;
use Exception;
use PDF;


class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Verifica se já existe matrícula para esta inscrição
        $inscricao = Inscricao::all();
        $matriculas = Matricula::all();
        $matriculaExistente = Matricula::all();
        return view('pages.admin.matricula_formulario', compact('inscricao','matriculas','matriculaExistente'));
    }
    public function criar($id)
    {
        $inscricao = Inscricao::with('user', 'curso')->findOrFail($id);
        // Verifica se já existe matrícula para esta inscrição
        $matriculaExistente = Matricula::where('n_bilhete', $inscricao->n_bilhete)->first();
        $matriculas = Matricula::with(['user', 'curso'])->get();
        return view('pages.admin.matricula_formulario', compact('inscricao','matriculas','matriculaExistente'));
    }
    public function index11(Request $request)
    {
        // Verifica se o usuário está autenticado
        $usuario = Auth::user();
        if (!$usuario) {
            return redirect()->back()->with('error', 'Você precisa estar logado para acessar a matrícula.');
        }
    
        // Busca a inscrição do usuário com o curso
        $inscricao = Inscricao::with('curso')
            ->where('user_id', $usuario->id)
            ->first();
    
        // Verifica se existe inscrição
        if (!$inscricao) {
            return redirect()->back()->with('error', 'Você ainda não possui uma inscrição registrada.');
        }
    
        // Verifica se o usuário foi admitido
        if (strtolower(trim($inscricao->estado)) !== 'admitido') {
            return redirect()->back()->with('error', 'Você ainda não foi admitido para realizar a matrícula.');
        }
    
        // Verifica se o curso existe
        $cursoSelecionado = $inscricao->curso ?? null;
    
        // Retorna a view com o curso
        return view('pages.estudante.matricula', compact('cursoSelecionado'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function inf_estudante()
    {
        $valor = Matricula::all();
        return view("pages.admin.estudante", compact('valor'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = Auth::user();
        if (!$usuario) {
            return response()->json(['error' => 'Usuário não autenticado.'], 400);
        }
        
        // Buscar matrícula existente ou criar nova
        $valor = matricula::where('user_id', $usuario->id)->latest()->first();
        
        if (!$valor) {
            $valor = new matricula();
            $valor->user_id = $usuario->id;
            $valor->reconfirmacao_pendente = false;
        } elseif ($valor->reconfirmacao_pendente) {
            $valor->reconfirmacao_pendente = false;
        } else {
            return redirect()->back()->with('info', 'Você já possui uma matrícula ativa.');
        }  
        /* Processar pagamento (se estiver implementado)
        if (!$this->processarPagamento($request->numero_cartao)) {
            return redirect()->back()->with('error', 'Erro no pagamento.');
        }*/ 
        // Preenchimento de dados
        $valor->user_id = $request->user_id;
        $valor->curso_id = $request->curso_id;
        $valor->email = $request->email;
        $valor->genero = $request->genero;
        $valor->n_bilhete = $request->n_bilhete;
        $valor->telefone = $request->telefone;
        $valor->turno = $request->turno;
        $valor->data_matricula = now();
        $valor->estado = 'matriculado';
        // Definindo o diretório para uploads com o nome ou ID do usuário
        $usuarioNome = $request->name ?? "Usuario_" . $valor->user_id;
        // Função para realizar o upload de arquivos
        $uploadFile = function ($file) use ($usuarioNome) {
            $directory = 'DocMatricula/' . $usuarioNome;
            return MediaUploader::fromSource($file)
                ->toDirectory($directory)
                ->onDuplicateIncrement()
                ->useFilename(md5($file->getClientOriginalName() . time()))
                ->setAllowedExtensions(['pdf', 'jpg', 'png', 'jpeg'])
                ->upload();
        };
        // Documentos para upload
        $documentos = ['certificado', 'bilhete'];
    
        foreach ($documentos as $docName) {
            if ($request->hasFile($docName)) {
                $file = $request->file($docName);
                $doc = $uploadFile($file);
                $valor->$docName = $doc->basename;
            }
        }
        // Geração do Código de Matrícula (caso seja nova matrícula)
        if (!$valor->codigo_matricula) {
            $anoIngresso = now()->format('Y'); // Ano atual
            $codigoCurso = str_pad($request->curso_id, 3, '0', STR_PAD_LEFT); // Código do curso com 3 dígitos
            $ultimoId = matricula::max('id') + 1; // Obtendo o próximo ID da tabela
            $codigo_matricula = "{$anoIngresso}{$codigoCurso}" . str_pad($ultimoId, 4, '0', STR_PAD_LEFT);
            $valor->codigo_matricula = $codigo_matricula; // Salvando no banco
        }
    
        // Salvar a matrícula
        $valor->save();
    
        return redirect()->back()->with('Sucesso', 'MATRÍCULA FEITA COM SUCESSO.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function sucesso($id)
    {
        $candidato = matricula::with('user')->findOrFail($id);
        return view('pages.estudante.sucesso', compact('candidato'));
    }
    /**
     * Show the form for editing the specified resource.
     */
        public function gerarPdf($id)
    {
        $matricula = Matricula::with('user', 'curso')->findOrFail($id);

        $pdf = Pdf::loadView('pages.admin.comprovativo', compact('matricula'));

        return $pdf->stream("matricula_{$matricula->user->name}.pdf");
    }
     public function gerarComprovativo(Request $request)
     {
         // Buscar o candidato pelo ID
         $candidato = matricula::findOrFail($request->id);
     
         // Gerar o PDF
         $pdf = PDF::loadView('pages.admin.comprovativo', compact('candidato'));
     
         // Verifica se o candidato tem um e-mail válido
         if (!$candidato->email) {
             return back()->with('error', 'O Estudante não possui um e-mail cadastrado.');
         }
     
         // Se a opção escolhida for "email"
         if ($request->metodo == 'email') {
             try {
                 Mail::send([], [], function ($message) use ($candidato, $pdf) {
                     $message->to($candidato->email)
                         ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')) // Define o remetente correto
                         ->subject('Comprovativo de Matricula')
                         ->attachData($pdf->output(), 'comprovativo.pdf')
                         ->html("<p>Olá {$candidato->nome},</p>
                                 <p>Segue em anexo o seu comprovativo de Matricula.</p>
                                 <br>
                                 <p>Atenciosamente,</p>
                                 <p>Equipe de Suporte</p>");
                 });
     
                 return back()->with('success', 'Comprovativo enviado para o e-mail ' . $candidato->email);
             } catch (\Exception $e) {
                 return back()->with('error', 'Erro ao enviar o e-mail: ' . $e->getMessage());
             }
         }
     
         // Se a opção escolhida for "pdf"
         if ($request->metodo == 'pdf') {
             return $pdf->download('Comprovativo de Matricula.pdf');
         }
     
         return back()->with('error', 'Selecione um método válido.');
     }
    /**
     * Show the form for editing the specified resource.
     */
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
     * Show the form for editing the specified resource.
     */

    public function show()
    {
        $valor = matricula::all();
        return view('pages.admin.estudante', compact('valor'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function consultar(Request $request)
    {
        $codigo = $request->input('codigo_matricula');

        // Procurar por código de matrícula ou número do BI
        $matricula = Matricula::where('codigo_matricula', $codigo)
            ->orWhere('n_bilhete', $codigo)
            ->first();

        if ($matricula) {
            // Se encontrada, enviar os dados para a view
            return view('page.estudante.resultado', ['matricula' => $matricula]);
        } else {
            // Se não encontrada, voltar com mensagem de erro
            return back()->with('erro', 'Matrícula não encontrada. Verifique os dados e tente novamente.');
        }
    }
    public function consultas()
    {
        return view('pages.estudante.consulta');
    }
}
