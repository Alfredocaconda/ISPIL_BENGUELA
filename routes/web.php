<?php

use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index'); 
});
Route::resource('cadastro',CadastroController::class);
#Route::get('apagar/{id}/cadastro',[CadastroController,'apagar'])->name('cadastro.apagar');

Route::post('auth',[CadastroController::class,'auth'])->name('user.auth');
Route::get('entrar',function(){
    return view('auth.login');
})->name('auth.login');

Auth::routes();

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
