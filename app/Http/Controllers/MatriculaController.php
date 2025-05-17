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

public function ind12x(Request $request)
{
    $inscricaoId = $request->get('inscricao_id'); // Pegamos o ID da inscrição via GET
    $inscricao = Inscricao::with(['user', 'curso'])->find($inscricaoId); // Buscamos a inscrição selecionada

    $matriculas = Matricula::with(['estudante', 'curso'])->get();

    $matriculaExistente = null;
    $reconfirmar = false;

    if ($inscricao) {
        $matriculaExistente = Matricula::where('n_bilhete', $inscricao->n_bilhete)->first();
        $reconfirmar = $matriculaExistente && $matriculaExistente->reconfirmacao_pendente;
    }

    $inscricoesDisponiveis = Inscricao::with(['user', 'curso'])->get(); // Para permitir seleção no formulário

    return view('pages.admin.matricula_formulario', compact(
        'inscricao',
        'inscricoesDisponiveis',
        'matriculas',
        'matriculaExistente',
        'reconfirmar'
    ));
}

public function index(Request $request)
{
    $inscricoes = Inscricao::with(['user', 'curso'])->get();
    $matriculas = Matricula::with(['user', 'curso'])->get();
    $estudantes = User::all(); 
    $inscricaoSelecionada = null;
    $matriculaExistente = null;
    $reconfirmar = false;

    if ($request->filled('estudante_id')) {
        $inscricaoSelecionada = Inscricao::with(['user', 'curso'])->find($request->estudante_id);

        if ($inscricaoSelecionada) {
            $matriculaExistente = Matricula::where('n_bilhete', $inscricaoSelecionada->n_bilhete)->first();
            $reconfirmar = $matriculaExistente && $matriculaExistente->reconfirmacao_pendente;
        }
    }

    return view('pages.admin.matricula_formulario', compact(
        'inscricoes',
        'matriculas',
        'inscricaoSelecionada',
        'matriculaExistente',
        'reconfirmar',
        'estudantes'
    ));
}



    public function i11ndex()
    {
        // Carregar a primeira inscrição para exibir no formulário
        $inscricao = Inscricao::with(['user', 'curso'])->first();
    
        // Todas as matrículas com os dados dos usuários e cursos
        $matriculas = Matricula::with(['user', 'curso'])->get();
    
        // Verificar se o aluno já tem uma matrícula e se precisa reconfirmar
        $matriculaExistente = null;
        $reconfirmar = false;
    
        if ($inscricao) {
            $matriculaExistente = Matricula::where('n_bilhete', $inscricao->n_bilhete)->first();
            $reconfirmar = $matriculaExistente && $matriculaExistente->reconfirmacao_pendente;
        }
    
        return view('pages.admin.matricula_formulario', compact(
            'inscricao',
            'matriculas',
            'matriculaExistente',
            'reconfirmar'
        ));
    }
     /**
     * Show the form for creating a new resource.
     */
    public function criar($id)
    {
        $inscricao = Inscricao::with('user', 'curso')->findOrFail($id);
        // Verifica se já existe matrícula para esta inscrição
        $matriculaExistente = Matricula::where('n_bilhete', $inscricao->n_bilhete)->first();
        $matriculas = Matricula::with(['user', 'curso'])->get();
        $reconfirmar = $matriculaExistente && $matriculaExistente->reconfirmacao_pendente;

        return view('pages.admin.matricula_formulario', compact('reconfirmar','inscricao','matriculas','matriculaExistente'));
    }
     /**
     * Show the form for creating a new resource.
     */
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
   
     # $usuario = Auth::user();
    #$inscricao = Inscricao::with(['user', 'curso'])->where('user_id', $usuario->id)->first();-->
     /**
     * Store a newly created resource in storage.
     */
    public function historico($user_id)
    {
        $usuario = User::findOrFail($user_id);
        // Carregar a primeira inscrição para exibir no formulário
        $inscricao = Inscricao::with(['user', 'curso'])->first();
        $matriculas = Matricula::where('user_id', $user_id)
            ->orderBy('ano_academico')
            ->get();

        return view('pages.admin.historico_academico', compact('inscricao','usuario', 'matriculas'));
    }
    public function historico2($user_id)
    {
        $usuario = User::findOrFail($user_id);
        // Carregar a primeira inscrição para exibir no formulário
        $inscricao = Inscricao::with(['user', 'curso'])->first();
        $matriculas = Matricula::where('user_id', $user_id)
            ->orderBy('ano_academico')
            ->get();

        return view('pages.estudante.historico_academico', compact('inscricao','usuario', 'matriculas'));
    }
    //CODIGO PARA RECONFIRMAAR MATRICULA
    public function reconfirmar($id)
    {
        $inscricao = Inscricao::with('user', 'curso')->findOrFail($id);
        $matricula = Matricula::findOrFail($id);
        $matriculas = Matricula::all(); // ou como você quiser listar os matriculados

        return view('pages.admin.matricula_formulario', [
            'reconfirmar' => true,
            'matriculaExistente' => true, // ou false, conforme seu caso
            'matricula' => $matricula,
            'matriculas' => $matriculas,
            'inscricao' => $inscricao,
        ]);
    }

    //GERAR O HISTORICO
    public function gerarHistoricoPdf($user_id)
    {
        $usuario = User::findOrFail($user_id);
         // Carregar a primeira inscrição para exibir no formulário
        $inscricao = Inscricao::with(['user', 'curso'])->first();
        $matriculas = Matricula::where('user_id', $user_id)
            ->orderBy('ano_academico')
            ->get();

        $pdf = Pdf::loadView('pages.pdfs.historico_academico_pdf', compact('inscricao','usuario', 'matriculas'));
        return $pdf->stream('historico_academico.pdf');
    }
    //GERAR O HISTORICO
    public function gerarHistoricoPdf2($user_id)
    {
        $usuario = User::findOrFail($user_id);
         // Carregar a primeira inscrição para exibir no formulário
        $inscricao = Inscricao::with(['user', 'curso'])->first();
        $matriculas = Matricula::where('user_id', $user_id)
            ->orderBy('ano_academico')
            ->get();

        $pdf = Pdf::loadView('pages.pdfs.estudante_pdf', compact('inscricao','usuario', 'matriculas'));
        return $pdf->stream('historico_academico.pdf');
    }
     /**
     * Show the form for creating a new resource.
     */
   public function store(Request $request)
{
    $usuario = Auth::user();
    if (!$usuario) {
        return redirect()->back()->with('Error', 'Usuário não autenticado.');
    }

    $request->validate([
        'estudante_id' => 'required|exists:users,id',
        'curso_id' => 'required|exists:cursos,id',
        'email' => 'required|email',
        'telefone' => 'required',
        'genero' => 'required',
        'n_bilhete' => 'required',
        'turno' => 'required',
        'ano_academico' => 'required',
        'certificado' => 'nullable|mimes:pdf,jpg,png,jpeg',
        'bilhete' => 'nullable|mimes:pdf,jpg,png,jpeg',
    ]);

    $reconfirmacao = $request->input('reconfirmacao') == 1;

    // ⚠️ Verifica duplicação apenas para novas matrículas
    if (!$reconfirmacao && Matricula::where('n_bilhete', $request->n_bilhete)->exists()) {
        return redirect()->back()->with('info', 'Este número de bilhete já está cadastrado.');
    }

    $matricula = new Matricula();
    $matricula->user_id = $usuario->id; // quem realiza a matrícula
    $matricula->estudante_id = $request->estudante_id; // estudante a ser matriculado
    $matricula->curso_id = $request->curso_id;
    $matricula->email = $request->email;
    $matricula->telefone = $request->telefone;
    $matricula->genero = $request->genero;
    $matricula->n_bilhete = $request->n_bilhete;
    $matricula->turno = $request->turno;
    $matricula->ano_academico = $request->ano_academico;
    $matricula->data_matricula = now();
    $matricula->estado = $reconfirmacao ? 'reconfirmado' : 'matriculado';
    $matricula->reconfirmacao_pendente = false;

    // Código de matrícula
    $anoIngresso = now()->format('Y');
    $codigoCurso = str_pad($request->curso_id, 3, '0', STR_PAD_LEFT);
    $ultimoId = Matricula::max('id') + 1;
    $matricula->codigo_matricula = "{$anoIngresso}{$codigoCurso}" . str_pad($ultimoId, 4, '0', STR_PAD_LEFT);

    // Upload
    $usuarioNome = "Usuario_" . $matricula->estudante_id;
    $uploadFile = function ($file) use ($usuarioNome) {
        $directory = 'DocMatricula/' . $usuarioNome;
        return MediaUploader::fromSource($file)
            ->toDirectory($directory)
            ->onDuplicateIncrement()
            ->useFilename(md5($file->getClientOriginalName() . time()))
            ->setAllowedExtensions(['pdf', 'jpg', 'png', 'jpeg'])
            ->upload();
    };

    foreach (['certificado', 'bilhete'] as $docName) {
        if ($request->hasFile($docName)) {
            $file = $request->file($docName);
            $doc = $uploadFile($file);
            $matricula->$docName = $doc->basename;
        }
    }

    $matricula->save();

    return redirect()->route('matricula.index', ['id' => $matricula->id])
                    ->with('Sucesso', $reconfirmacao ? 'Matrícula reconfirmada com sucesso!' : 'Matrícula efetuada com sucesso!');
}

    /**
     * Show the form for editing the specified resource.
     */
        public function gerarPdf($id)
    {
        $matricula = Matricula::with('user', 'curso')->findOrFail($id);
        $inscricao = Inscricao::with(['user', 'curso'])->first();
        $pdf = Pdf::loadView('pages.pdfs.comprovativo_matricula', compact('inscricao','matricula'));

        return $pdf->stream("matricula_{$matricula->user->name}.pdf");
    }
     /**
     * Show the form for creating a new resource.
     */
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
