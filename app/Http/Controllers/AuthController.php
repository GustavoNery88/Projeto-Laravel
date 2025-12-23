<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Exception;
use App\Http\Requests\AuthLoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Método para exibir o formulário de login
    public function index()
    {
        return view('auth.login');
    }

    // Método para processar o formulário de login
    public function loginProcess(AuthLoginRequest $request)
    {
        try {

            // Buscar o usuário pelo email
            $usuario = Usuario::where('email', $request->email)->first();

            // Verificar se o usuário já foi ativado
            if (!$usuario->ativo) {
                return back()->with('error', 'Usuário não ativou o acesso! Favor verificar seu e-mail.');
            }

            // Validar senha e email
            // O attempt() serve para autenticar o usuário e retornar um boolean
            $autendicado = Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Verificar se senha e email estão corretos
            if (!$autendicado) {
                return back()->with('error', 'Email ou senha inválidos!');
            }

            return redirect()->route('usuarios.index')->with('success', 'Login efetuado com sucesso!');

            // Verificar email e senha de login são válidas
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao logar usuário!');
        }
    }

    // Método para deslogar o usuário
    public function logout()
    {
        try {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Logout efetuado com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao logar usuário!');
        }
    }
}
