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
};
use Plank\Mediable\Media;




Route::get('password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');


Route::get('/', function () {
    return view('index'); 
});


Route::get('cadastrar',function(){
    return view('auth.cadastrar');
})->name('form');

Route::post('auth',[UsuarioController::class,'auth'])->name('user.auth');

Route::resource('candidato',CandidatoController::class);
Route::post('user/cadastro',[UsuarioController::class,'cadastrar'])->name('user.register');

Route::resource('inscricao',InscricaoController::class);
Route::post('inscricao/cadastro',[InscricaoController::class,'store'])->name('inscricao.cadastro');

Route::resource('matricula',MatriculaController::class);
Route::post('matricula/cadastro',[MatriculaController::class,'store'])->name('matricula.cadastro');

Route::resource('reconfirmacao',ReconfirmacaoController::class);
Route::post('reconfirmacao/cadastro',[ReconfirmacaoController::class,'store'])->name('reconfirmacao.cadastro');

Route::resource('cursos',CursoController::class);
Route::post('cursos/cadastro',[CursoController::class,'store'])->name('cursos.cadastro');


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
