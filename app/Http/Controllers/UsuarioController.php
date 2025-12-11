<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioPdfMail;
use Carbon\Carbon;

class UsuarioController extends Controller
{
    // Método para exibir a página inicial
    // Recuperar registros do banco de dados
    public function index()
    {

        // Recupera os usuários ordenados por ID decrescente e paginados
        $usuarios = Usuario::orderByDesc('id')->paginate(3);

        return view('usuarios.listarUsuarios', compact('usuarios'));
    }

    // Método para exibir o formulário de cadastro de usuário
    public function create()
    {
        return view('usuarios.cadastrarUsuarios');
    }

    // Método para armazenar um novo usuário no banco de dados
    public function store(UsuarioRequest $request)
    {
        try {

            // Criar um novo usuário com os dados do formulário
            Usuario::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'password' => ($request->password),
            ]);
            return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao cadastrar usuário!');
        }
    }

    // Método para exibir o formulário de edição de usuário
    public function edit(Usuario $usuario)
    {
        // Passa o usuário para a view de edição
        return view('usuarios.editarUsuarios', compact('usuario'));
    }

    // Método para atualizar um usuário existente no banco de dados
    // Pegando os dados e o usuário pelo id que veio da view
    public function update(UsuarioRequest $request, Usuario $usuario)
    {
        try {
            $usuario->update([
                'nome' => $request->nome,
                'email' => $request->email,
            ]);
            return redirect()->route('usuarios.index')->with('success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao editar usuário!');
        }
    }

    // Método para exibir os detalhes de um usuário específico
    public function show(Usuario $usuario)
    {
        // Passa o usuário para a view de visualização
        return view('usuarios.visualizarUsuarios', compact('usuario'));
    }

    // Método para excluir um usuário do banco de dados
    public function destroy(Usuario $usuario)
    {
        try {
            // Exclui o usuário do banco de dados
            $usuario->delete();
            return redirect()->route('usuarios.index')->with('success', 'Usuário excluido com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao excluir usuário!');
        }
    }

    // Método para gerar PDF dos detalhes do usuário
    public function generatePdf(Usuario $usuario)
    {
        try {
            // Passa os dados para a view de geração de PDF
            // Passa os dados para usuario/geradorPdf.blade.php
            $pdf = Pdf::loadView('usuarios.geradorPdf', compact('usuario'))->setPaper('a4', 'portrait');

           // Gerar e baixar o PDF com os dados do usuário com nome do arquivo e extensão do PDF
            return $pdf->download('DadosUsuario.pdf');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao gerar PDF do usuário!');
        }
    }

    // Método para enviar o PDF dos detalhes do usuário por email
    public function enviarEmailPdf(Usuario $usuario)
    {
        try {
            // Passar os dados para a view de geração de PDF
            $pdf = Pdf::loadView('usuarios.geradorPdf', compact('usuario'))->setPaper('a4', 'portrait');

            // Caminho para salvar o PDF temporariamente
            $pdfPath = storage_path("app/public/{$usuario->id}.pdf");

            // Salvar o PDF localmente
            $pdf->save($pdfPath);

            // Enviar o email com o PDF em anexo
            Mail::to($usuario->email)->send(new UsuarioPdfMail($pdfPath, $usuario));

            // Remover o arquivo PDF temporário após o envio do email
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            return redirect()->route('usuarios.index')->with('success', 'Email enviado com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao gerar PDF do usuário!');
        }
    }

    // Método para buscar usuários pelo nome ou email
    public function search(Request $request)
    {
        // Consulta na tabela usuários
        $query = Usuario::query();

        // Filtrar por nome se fornecido
        if ($request->filled('nome')) {
            // Filtrar por nome
            $query->where('nome', 'LIKE', '%' . $request->nome . '%');
        }
        // Filtrar por nome se fornecido
        if ($request->filled('email')) {
            // Filtrar por email
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }
        // Filtrar por nome se fornecido
        if ($request->filled('data_criacao_inicio')) {
            // Filtrar por data de criação inicial
            $query->where('created_at', '>=', Carbon::parse($request->data_criacao_inicio));
        }
        // Filtrar por data de criação final se fornecido
        if ($request->filled('data_criacao_final')) {
            // Filtrar por data de criação final
            $query->where('created_at', '<=', Carbon::parse($request->data_criacao_final));
        }

        // Coloca na variável usuários os resultados da query com paginação e ordenação
        $usuarios = $query->orderByDesc('id')
            ->paginate(3)
            ->withQueryString();

        return view('usuarios.listarUsuarios', compact('usuarios'));
    }

    // Método para gerar PDF da busca de pesquisa de usuários
    public function generatePdfSearch(Request $request)
    {
        try {
            // Consulta na tabela usuários
            $query = Usuario::query();

            // Filtrar por nome se fornecido
            if ($request->filled('nome')) {
                // Filtrar por nome
                $query->where('nome', 'LIKE', '%' . $request->nome . '%');
            }
            // Filtrar por nome se fornecido
            if ($request->filled('email')) {
                // Filtrar por email
                $query->where('email', 'LIKE', '%' . $request->email . '%');
            }
            // Filtrar por nome se fornecido
            if ($request->filled('data_criacao_inicio')) {
                // Filtrar por data de criação inicial
                $query->where('created_at', '>=', Carbon::parse($request->data_criacao_inicio));
            }
            // Filtrar por data de criação final se fornecido
            if ($request->filled('data_criacao_final')) {
                // Filtrar por data de criação final
                $query->where('created_at', '<=', Carbon::parse($request->data_criacao_final));
            }

            // Coloca na variável os usuários do resultado da query
            $usuarios = $query->orderByDesc('id')->get();

            // Passa os dados para a view de geração de PDF
            // Passa os dados para usuario/geradorPdfPesquisa.blade.php
            $pdf = Pdf::loadView('usuarios.geradorPdfPesquisa', compact('usuarios'))->setPaper('a4', 'portrait');

            // Gerar e baixar o PDF com os dados do usuário com nome do arquivo e extensão do PDF
            return $pdf->download('DadosUsuario.pdf');
        
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao gerar PDF da pesquisa!');
        }
    }
}
