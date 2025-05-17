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
        $cursos = Curso::all(); // pega todos
        $cursoSelecionado = $request->curso_id ? Curso::find($request->curso_id) : null;
        $valor = inscricao::all();
    
        return view('pages.candidato.inscricao', compact('valor', 'cursos', 'cursoSelecionado'));
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
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'certificado' => 'required|mimes:pdf,jpg,png,jpeg|max:5120',
            'bilhete' => 'required|mimes:pdf,jpg,png,jpeg|max:5120',
            'comprovativo' => 'required|mimes:pdf,jpg,png,jpeg|max:5120',
            'curso_id' => 'required|integer',
            'periodo' => 'required|string|max:10',
        ]);

        $usuario = Auth::user();
        if (!$usuario) {
            return response()->json(['error' => 'Usuário não autenticado.'], 400);
        }

        // VERIFICAÇÃO DE INSCRIÇÃO EXISTENTE
        $existeInscricao = inscricao::where('user_id', $usuario->id)
            ->where('curso_id', $request->curso_id)
            ->exists();

        if ($existeInscricao) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'VOCÊ JÁ SE INSCREVEU NESTE CURSO! POR FAVOR ESCOLHER OUTRO CURSO.');
        }

        // Só cria e preenche a inscrição depois de passar na verificação
        $valor = new inscricao();
        $valor->user_id = $usuario->id;
        $valor->email = $request->email;
        $valor->genero = $request->genero;
        $valor->data_nasc = $request->data_nasc;
        $valor->n_bilhete = $request->n_bilhete;
        $valor->telefone = $request->telefone;
        $valor->periodo = $request->periodo;
        $valor->nome_escola = $request->nome_escola;
        $valor->curso_medio = $request->curso_medio;
        $valor->curso_id = $request->curso_id;
        $valor->data_inscricao = now();
        $valor->estado = "Pendente";
        $valor->codigo_inscricao = 'TEMPORARIO';

        $usuarioNome = $request->name ?? "Usuario_" . $valor->user_id;

        $uploadFile = function ($file) use ($usuarioNome) {
            $directory = 'DocInscricao/' . $usuarioNome;
            return MediaUploader::fromSource($file)
                ->toDirectory($directory)
                ->onDuplicateIncrement()
                ->useFilename(md5($file->getClientOriginalName() . time()))
                ->setAllowedExtensions(['pdf', 'jpg', 'png', 'jpeg'])
                ->upload();
        };

        foreach (['certificado', 'bilhete', 'foto','comprovativo'] as $docName) {
            if ($request->hasFile($docName)) {
                $file = $request->file($docName);
                $doc = $uploadFile($file);
                $valor->$docName = $doc->basename;
            }
        }

        $valor->save();

        // Código de inscrição gerado depois do ID ser definido
        $anoIngresso = now()->format('Y');
        $codigoCurso = str_pad($request->curso_id, 3, '0', STR_PAD_LEFT);
        $codigo_inscricao = "{$anoIngresso}{$codigoCurso}" . str_pad($valor->id, 4, '0', STR_PAD_LEFT);
        $valor->codigo_inscricao = $codigo_inscricao;
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
         $pdf = PDF::loadView('pages.pdfs.comprovativo_inscricao', compact('candidato'));
     
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
         $inscricao->nota=$request->nota;
         $inscricao->save();
         return redirect()->back()->with('SUCESSO', 'Nota adicionada com sucesso!');
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
