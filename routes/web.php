<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\InscricaoController;

Route::get('/', function () {
    return view('index'); 
});


Route::get('cadastrar',function(){
    return view('auth.cadastrar');
})->name('form');

Route::post('auth',[UsuarioController::class,'auth'])->name('user.auth');
Route::post('user/cadastro',[UsuarioController::class,'cadastrar'])->name('user.register');
Route::resource('candidato',CandidatoController::class);
Route::get('inscricao',[InscricaoController::class,'index'])->name('inscricao.index');

Route::get('entrar',function(){
    return view('auth.login');
})->name('auth.login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
