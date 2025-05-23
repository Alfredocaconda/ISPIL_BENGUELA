<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\inscricao;
use App\Http\Controllers\{
    UsuarioController,
    CandidatoController,
    InscricaoController,
    MatriculaController,
    CursoController,
    HomeController,
    FuncionarioController,
    NotaController,

};
use Plank\Mediable\Media;




Route::get('password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

/*use App\Models\Curso;
use App\Models\Professor;
use App\Models\Aluno;
use App\Models\Disciplina;

Route::get('/', function () {
    $cursos = Curso::all();
    $professores = Professor::all();
    $alunos = Aluno::all();
    $disciplinas = Disciplina::all();
    
    return view('index', compact('cursos', 'professores', 'alunos', 'disciplinas'));
});
*/
use App\Models\Matricula;

use App\Models\Curso;

Route::get('/', function () {
    $cursos = Curso::all(); // Buscar todos os cursos
    return view('index', compact('cursos')); // Enviar para a view
});



Route::get('cadastrar',function(){
    return view('auth.cadastrar');
})->name('form');

Route::get('perfil',[UsuarioController::class,'perfil'])->name('perfil');

Route::post('auth',[UsuarioController::class,'auth'])->name('user.auth');
/*
  INCIO DAS ROTAS DE CANDIDATOS
*/
Route::resource('candidato',CandidatoController::class);
Route::post('user/cadastro',[UsuarioController::class,'cadastrar'])->name('user.register');
Route::get('Inf/Candidato',[InscricaoController::class,'inf_candidato'])->name('candidato.inf_candidato');
/*
  INCIO DAS ROTAS DE INSCRICAO
*/
Route::get('/inscricao', [InscricaoController::class, 'index'])->name('inscricao.index')->middleware('auth');
Route::post('inscricao/cadastro',[InscricaoController::class,'store'])->name('inscricao.cadastro');
Route::get('/inscricao/sucesso/{id}', [InscricaoController::class, 'sucesso'])->name('inscricao.sucesso');
Route::post('/inscricao/comprovativo', [InscricaoController::class, 'gerarComprovativo'])->name('inscricao.comprovativo');
Route::post('/inscricao/adicionarNota', [InscricaoController::class, 'adicionarNota'])->name('inscricao.adicionarNota');
Route::get('/consulta-inscricao', [InscricaoController::class, 'consulta'])->name('inscricao.consulta');
/*
  INCIO DAS ROTAS DE MATRICULA
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/matricula', [MatriculaController::class, 'index'])->name('matricula.index');
});
Route::get('/matricula/{id}', [MatriculaController::class, 'criar'])->name('matricula.iniciar');
Route::get('/historico-academico/{user_id}', [MatriculaController::class, 'historico'])->name('matricula.historico');
Route::get('/historico-academico/{user_id}/pdf', [MatriculaController::class, 'gerarHistoricoPdf'])->name('matricula.historico.pdf');

//Route::get('/matricula', [MatriculaController::class, 'index'])->name('matricula.index')->middleware('auth');
Route::resource('/matricula',MatriculaController::class);
Route::post('/matricula/store',[MatriculaController::class,'store'])->name('matricula.store');
Route::get('/matricula/sucesso/{id}', [MatriculaController::class, 'sucesso'])->name('matricula.sucesso');
Route::get('/matricula/pdf/{id}', [MatriculaController::class, 'gerarPdf'])->name('matricula.pdf');
Route::get('/consultas-matricula', [MatriculaController::class, 'consultas'])->name('matricula.consulta');
// Correto
Route::get('/matricula/reconfirmar/{id}', [MatriculaController::class, 'reconfirmar'])->name('matricula.reconfirmar');


Route::post('/consulta-matricula', [MatriculaController::class, 'consultar'])->name('consulta-matricula');

Route::get('/matricula/inf_estudante', [MatriculaController::class, 'inf_estudante'])->name('matricula.inf_estudante');

/*
  INCIO DAS ROTAS DE CONSULTAS
*/
Route::post('/consulta-resultado', function (Request $request) {
    $codigo = $request->input('codigo_inscricao');
    $bi = $request->input('codigo_inscricao');

    // Buscar a inscrição pelo código ou pelo BI
    $inscricao = Inscricao::where('codigo_inscricao', $codigo)
                          ->orWhere('n_bilhete', $bi)
                          ->first();

    if ($inscricao) {
        // Se a nota ainda não estiver lançada
        if (is_null($inscricao->nota)) {
            return redirect()->back()->with('resultado', 'Os resultados ainda não estão disponíveis e serão divulgados no dia 20/08/2025.');
        }

        // Determinar se foi admitido ou não
        $resultado = $inscricao->nota >= 10 ? 'Admitido' : 'Não Admitido';

        // Retornar uma view com os dados do candidato
        return view('pages.candidato.resultado', [
            'inscricao' => $inscricao,
            'resultado' => $resultado
        ]);
    }

    return redirect()->back()->with('resultado', 'Candidato não encontrado.');
})->name('consulta.resultado');

Route::post('/consulta-matricula', function (Request $request) {
    $codigo = $request->input('codigo_matricula');

    // Verificar se o código corresponde ao código de matrícula OU ao número do bilhete
    $matricula = Matricula::where('codigo_matricula', $codigo)
                    ->orWhere('n_bilhete', $codigo)
                    ->first();

    if (!$matricula) {
        return redirect()->back()->with('matricula', 'Candidato não encontrado.');
    }

    if ($matricula->estado === 'Matriculado') {
        return redirect()->back()->with('matricula', 'Estudante já está matriculado.');
    }

    return redirect()->back()->with('matricula', 'Estudante ainda não está matriculado.');
})->name('consulta-matricula');




Route::get('/notas', [NotaController::class, 'index'])->name('notas.index'); // Exibe o formulário
Route::post('/notas', [NotaController::class, 'store'])->name('notas.store'); // Processa o formulário

Route::get('/get-curso/{candidato_id}', [NotaController::class, 'getCurso']); // AJAX para buscar o curso



Route::resource('matricula',MatriculaController::class);
Route::post('matricula/cadastro',[MatriculaController::class,'store'])->name('matricula.cadastro');

Route::get('/reconfirmacao', [MatriculaController::class, 'reconfirmacaoView'])->name('matricula.reconfirmacao');
Route::get('/comprovativo', [MatriculaController::class, 'baixarComprovativo'])->name('matricula.comprovativo');

Route::get('Dashboard',[HomeController::class,'admin'])->name('admin.index');

Route::resource('funcio',FuncionarioController::class);
Route::get('apagar/{id}/funcio',[FuncionarioController::class,'apagar'])->name('funcio.apagar');

Route::resource('Curso',CursoController::class);
Route::get('apagar/{id}/Curso', [CursoController::class, 'apagar'])->name('Curso.apagar');

Route::group(['middleware'=>'auth'],function(){

Route::get('entrar',function(){
    return view('auth.login');
})->name('auth.login');
 Route::get('getfile/{nome}',function($name){
        $path = '';
            $media = Media::whereBasename($name)->first();

            if ($media != null) {
                $path = $media->getDiskPath();
            } else {
                $path = 'default.png';
            }
            $img = Image::make($media->getAbsolutePath())->resize(300, 200);
            $img->stream();
            dd($img->__toString());
            //Log::debug(storage_path() . '/app/' . $path);
            return (new Response($img->__toString(), 200))
                ->header('Content-Type', '*');
    })->name('getfile');


    Route::get('download/{nome}',function($nome){
        $path = Storage::path('public/docEmpresa/'.$nome); // Update the path as per your PDF file location.

        return \Illuminate\Support\Facades\Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename='.$nome, // You can change the filename here.
        ]);
    })->name('baixar');

});
Auth::routes();

Route::get('/principal', [App\Http\Controllers\HomeController::class, 'index2'])->name('principal');
Route::get('/cursos', [App\Http\Controllers\HomeController::class, 'cursos'])->name('cursos');

