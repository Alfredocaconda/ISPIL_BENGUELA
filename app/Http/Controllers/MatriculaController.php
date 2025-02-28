<?php

namespace App\Http\Controllers;

use App\Models\matricula;
use App\Models\Candidato;
use App\Models\Inscricao;
use App\Models\Curso;
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
        // Verifica se o usuário está autenticado
        $usuario = Auth::user();
        if (!$usuario) {
            return response()->json(['error' => 'Usuário não autenticado.'], 400);
        }
    
        // Buscar a inscrição do usuário logado com o curso associado
        $inscricao = Inscricao::with('curso') // Carrega o curso associado à inscrição
            ->where('user_id', $usuario->id)   // Filtra pela inscrição do usuário logado
            ->first(); // Aqui pegamos a primeira inscrição do usuário (caso o usuário tenha mais de uma)
    
        // Verifica se a inscrição existe e se o curso associado também existe
        if ($inscricao && $inscricao->curso) {
            $cursoSelecionado = $inscricao->curso; // Pega o curso que o usuário selecionou na inscrição
        } else {
            $cursoSelecionado = null; // Caso não haja inscrição ou o curso não exista
        }
    
        // Retorna a view com a variável cursoSelecionado
        return view('pages.estudante.matricula', compact('cursoSelecionado'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function inf_estudante()
    {
        //
        $valor = matricula::all();
        $cursos = Curso::all();
        return view("pages.admin.matricula", compact('valor', 'cursos'));
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
        // Buscar matrícula existente ou criar uma nova
        $valor = matricula::where('user_id', $usuario->id)->latest()->first();
        
        if (!$valor) {
            $valor = new matricula();
            $valor->user_id = $usuario->id;
            $valor->reconfirmacao_pendente = false; // Se é nova, não precisa de reconfirmação
        } elseif ($valor->reconfirmacao_pendente) {
            // Se a reconfirmação for necessária, permitir a atualização
            $valor->reconfirmacao_pendente = false; // Após a atualização, remove a necessidade de reconfirmação
        } else {
            return redirect()->back()->with('info', 'Você já possui uma matrícula ativa.');
        }
    
        // Simulação de pagamento via API Multicaixa Express (antes do upload)
        if (!$this->processarPagamento($request->numero_cartao)) {
            return redirect()->back()->with('error', 'Erro no pagamento. Tente novamente.');
        }
        $valor->user_id = $usuario->id;
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
        $valor->turno = $request->turno;
        $valor->curso_id = $request->curso_id;
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
        $documentos = ['certificado', 'recenciamento', 'atestado', 'bilhete', 'foto'];
    
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
    
        return redirect()->route('matricula.sucesso', ['id' => $valor->id]);
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

     public function gerarComprovativo(Request $request)
     {
         // Buscar o candidato pelo ID
         $candidato = matricula::findOrFail($request->id);
     
         // Gerar o PDF
         $pdf = PDF::loadView('pages.estudante.comprovativo', compact('candidato'));
     
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
                         ->subject('Comprovativo de Inscrição')
                         ->attachData($pdf->output(), 'comprovativo.pdf')
                         ->html("<p>Olá {$candidato->nome},</p>
                                 <p>Segue em anexo o seu comprovativo de inscrição.</p>
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
             return $pdf->download('comprovativo.pdf');
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

    /**
     * Remove the specified resource from storage.
     */
    public function consulta()
    {
        return view('pages.estudante.consulta');
    }
}
