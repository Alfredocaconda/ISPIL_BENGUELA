<?php

namespace App\Http\Controllers;

use App\Models\inscricao;
use App\Models\Candidato;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Facades\MediaUploader;
use Illuminate\Support\Facades\Mail;
use Exception;
use PDF;


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
        $valor->estado = "Pendente";
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
        // Geração do Código de Matrícula
        $anoIngresso = now()->format('Y'); // Ano atual
        $codigoCurso = str_pad($request->curso_id, 3, '0', STR_PAD_LEFT); // Código do curso com 3 dígitos
        $ultimoId = inscricao::max('id') + 1; // Obtendo o próximo ID da tabela
        $codigo_inscricao = "{$anoIngresso}{$codigoCurso}" . str_pad($ultimoId, 4, '0', STR_PAD_LEFT);
        $valor->codigo_inscricao = $codigo_inscricao; // Salvando no banco
        // Salvar a inscrição
        $valor->save();

        return redirect()->route('inscricao.sucesso', ['id' => $valor->id]);
    }
    
    /**
     * Show the form for editing the specified resource.
     */

     public function sucesso($id)
     {
         $candidato = inscricao::with('user')->findOrFail($id);
     
         return view('pages.candidato.sucesso', compact('candidato'));
     }
     

    /**
     * Show the form for editing the specified resource.
     */

     public function gerarComprovativo(Request $request)
     {
         // Buscar o candidato pelo ID
         $candidato = inscricao::findOrFail($request->id);
     
         // Gerar o PDF
         $pdf = PDF::loadView('pages.candidato.comprovativo', compact('candidato'));
     
         // Verifica se o candidato tem um e-mail válido
         if (!$candidato->email) {
             return back()->with('error', 'O candidato não possui um e-mail cadastrado.');
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

    

     public function adicionarNota(Request $request)
     {
         // Validação da nota
         $request->validate([
             'id' => 'required|exists:inscricaos,id',
             'nota' => 'required|numeric|min:0|max:20',
         ]);
     
         // Buscar a inscrição pelo ID
         $inscricao = Inscricao::findOrFail($request->id);
     
         // Atualizar a nota
         $inscricao->nota = $request->nota;
         $inscricao->save();
     
         return redirect()->back()->with('success', 'Nota adicionada com sucesso!');
     }
     

    /**
     * Update the specified resource in storage.
     */
    public function atualizarNota(Request $request, $id)
    {
        $request->validate([
            'nota' => 'required|numeric|min:0|max:20',
        ]);

        $inscricao = Inscricao::findOrFail($id);
        $inscricao->nota = $request->nota;
        $inscricao->estado = ($request->nota >= 10) ? 'Admitido' : 'Não Admitido';
        $inscricao->save();

        return redirect()->back()->with('success', 'Nota atualizada com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function consulta()
    {
        
        return view('pages.candidato.consulta');
    }
}
