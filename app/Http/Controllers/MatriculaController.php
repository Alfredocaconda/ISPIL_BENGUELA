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
    public function index()
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
    

    public function criar($id)
    {
        $inscricao = Inscricao::with('user', 'curso')->findOrFail($id);
        // Verifica se já existe matrícula para esta inscrição
        $matriculaExistente = Matricula::where('n_bilhete', $inscricao->n_bilhete)->first();
        $matriculas = Matricula::with(['user', 'curso'])->get();
        $reconfirmar = $matriculaExistente && $matriculaExistente->reconfirmacao_pendente;

        return view('pages.admin.matricula_formulario', compact('reconfirmar','inscricao','matriculas','matriculaExistente'));
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

   //
    public function store(Request $request)
    {
        $usuario = Auth::user();
        if (!$usuario) {
            return redirect()->back()->with('Error', 'Usuário não autenticado.');
        }

        // Verifica se é reconfirmação
        $reconfirmacao = $request->has('reconfirmacao');

        // Validação do formulário
        $request->validate([
            'email' => 'required|email',
            'telefone' => 'required',
            'n_bilhete' => 'required',
            'turno' => 'required',
            'certificado' => 'nullable|mimes:pdf,jpg,png,jpeg',
            'bilhete' => 'nullable|mimes:pdf,jpg,png,jpeg',
        ]);

        if ($reconfirmacao) {
            // Buscar matrícula existente
            $valor = Matricula::where('user_id', $usuario->id)
                            ->where('reconfirmacao_pendente', true)
                            ->latest()
                            ->first();

            if (!$valor) {
                return redirect()->back()->with('Error', 'Nenhuma matrícula pendente para reconfirmação.');
            }

            // Atualiza os dados da matrícula (não altera o número de matrícula)
            $valor->reconfirmacao_pendente = false;
            $valor->data_matricula = now();
            $valor->estado = 'reconfirmado';
            $valor->ano_academico = $request->ano_academico;  // Atualiza o ano acadêmico

            // Atualiza os dados dos campos
            $valor->email = $request->email;
            $valor->telefone = $request->telefone;
            $valor->n_bilhete = $request->n_bilhete;
            $valor->turno = $request->turno;

            // Processa documentos (se enviados)
            $usuarioNome = $request->name ?? "Usuario_" . $valor->user_id;

            // Upload de documentos
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
                    $valor->$docName = $doc->basename;
                }
            }

        } else {
            // Nova matrícula
            $valor = Matricula::where('user_id', $usuario->id)->latest()->first();

            if ($valor && !$valor->reconfirmacao_pendente) {
                return redirect()->back()->with('info', 'Você já possui uma matrícula ativa.');
            }

            if (!$valor) {
                $valor = new Matricula();
                $valor->user_id = $usuario->id;
            }

            $valor->reconfirmacao_pendente = false;

            // Geração do Código de Matrícula (apenas se não existir ainda)
            if (!$valor->codigo_matricula) {
                $anoIngresso = now()->format('Y');
                $codigoCurso = str_pad($request->curso_id, 3, '0', STR_PAD_LEFT);
                $ultimoId = Matricula::max('id') + 1;
                $valor->codigo_matricula = "{$anoIngresso}{$codigoCurso}" . str_pad($ultimoId, 4, '0', STR_PAD_LEFT);
            }

            // Dados comuns para ambos os casos
            $valor->curso_id = $request->curso_id;
            $valor->email = $request->email;
            $valor->genero = $request->genero;
            $valor->n_bilhete = $request->n_bilhete;
            $valor->telefone = $request->telefone;
            $valor->turno = $request->turno;
            $valor->ano_academico = $request->ano_academico;

            // Data de matrícula deve ser sempre a data atual
            $valor->data_matricula = now();
            $valor->estado = $reconfirmacao ? 'reconfirmado' : 'matriculado';
            // Upload de documentos
            $usuarioNome = $request->name ?? "Usuario_" . $valor->user_id;

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
                    $valor->$docName = $doc->basename;
                }
            }
        }

        // Salvar a matrícula
        $valor->save();

        return redirect()->route('matricula.index', ['id' => $valor->id])
                        ->with('Sucesso', $reconfirmacao ? 'Matrícula reconfirmada com sucesso!' : 'Matrícula efetuada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
        public function gerarPdf($id)
    {
        $matricula = Matricula::with('user', 'curso')->findOrFail($id);

        $pdf = Pdf::loadView('pages.pdfs.comprovativo_matricula', compact('matricula'));

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
