<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('index'); 
});

Route::get('cadastro',[UsuarioController::class,'index'])->name('cadastro.index');

Route::get('login',[UsuarioController::class,'entrar'])->name('login.entrar');

Route::post('user/cadastro',[UsuarioController::class,'store'])->name('user.store');

Route::get('cadastrar',function(){
    return view('auth.cadastrar');
})->name('form');

Route::post('auth',[UsuarioController::class,'auth'])->name('user.auth');

Route::get('entrar',function(){
    return view('auth.login');
})->name('auth.login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
