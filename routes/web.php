<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UsuarioController,
    CandidatoController,
    InscricaoController,
    MatriculaController,
    ReconfirmacaoController,
    CursoController,
    HomeController,
    FuncionarioController,
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

Route::resource('candidato',CandidatoController::class);
Route::post('user/cadastro',[UsuarioController::class,'cadastrar'])->name('user.register');

Route::get('/inscricao', [InscricaoController::class, 'index'])->name('inscricao.index')->middleware('auth');
Route::post('inscricao/cadastro',[InscricaoController::class,'store'])->name('inscricao.cadastro');

Route::resource('matricula',MatriculaController::class);
Route::post('matricula/cadastro',[MatriculaController::class,'store'])->name('matricula.cadastro');

Route::resource('reconfirmacao',ReconfirmacaoController::class);
Route::post('reconfirmacao/cadastro',[ReconfirmacaoController::class,'store'])->name('reconfirmacao.cadastro');

Route::get('Dashboard',[HomeController::class,'secretaria'])->name('secretaria.index');

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
