<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ImportCsvUsuario;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/usuarios/cadastrar', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios/cadastrar', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/ativar-usuario', [UsuarioController::class, 'ativarUsuarioForm'])->name('usuarios.ativarUsuarioForm');
Route::post('/usuarios/ativar-usuario', [UsuarioController::class, 'ativarUsuario'])->name('usuarios.ativarUsuario');
Route::get('/usuarios/recuperar-senha', [UsuarioController::class, 'recuperarSenhaForm'])->name('usuarios.recuperarSenhaForm');
Route::post('/usuarios/recuperar-senha', [UsuarioController::class, 'recuperarSenha'])->name('usuarios.recuperarSenha');

// Rotas de autenticação tem que ter o nome login, login.process e logout
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Rotas restritas

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/editar/{usuario}', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('usuarios/atualizar/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::get('/usuarios/visualizar/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
    Route::delete('/usuarios/excluir/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    Route::get('/usuarios/gerar-pdf/{usuario}', [UsuarioController::class, 'generatePdf'])->name('usuarios.generatePdf');
    Route::get('/usuarios/enviar-pdf/{usuario}', [UsuarioController::class, 'enviarEmailPdf'])->name('usuarios.enviarEmailPdf');
    Route::get('/usuarios/buscar', [UsuarioController::class, 'search'])->name('usuarios.search');
    Route::get('/usuarios/gerar-pdf-pesquisa', [UsuarioController::class, 'generatePdfSearch'])->name('usuarios.generatePdfSearch');
    Route::get('/usuarios/gerar-csv-pesquisa', [UsuarioController::class, 'generateCsvSearch'])->name('usuarios.generateCsvSearch');
    Route::get('/perfil', [UsuarioController::class, 'perfilUsuario'])->name('perfil');

