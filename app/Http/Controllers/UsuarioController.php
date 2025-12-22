<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmarSenhaRequest;
use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioPdfMail;
use App\Mail\UsuarioSenhaMail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


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

            // Gerar uma senha aleatória, sem criptografia
            $senhaGerada = Str::random(8);

            // Criar um novo usuário com os dados do formulário
            Usuario::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'password' => $senhaGerada,
            ]);

            // Enviar email de confirmação de cadastro
            Mail::to($request->email)->send(new UsuarioSenhaMail($request->nome, $request->email, $senhaGerada));

            return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao cadastrar usuário!');
        }
    }

    // Exibe a página de confirmação de senha
    public function ativarUsuarioForm()
    {
        return view('usuarios.ativarUsuario');
    }

    //  Confirmar senha enviada por email
    public function ativarUsuario(ConfirmarSenhaRequest $request)
    {
        try {
            // Buscar o usuário pelo email
            $usuario = Usuario::where('email', $request->email)->first();

            if (!$usuario) {
                return back()->witkh('error', 'Usuário não encontrado!');
            }

            // Verificar se o usuário já ativou o acesso
            if ($usuario->ativo) {
                return back()->with('error', 'Usuário já ativou o acesso!');
            }

            // Verificar senha atual (a que veio por e-mail)
            if (!Hash::check($request->senha_ativação, $usuario->password)) {
                return back()->with('error', 'Senha de ativação inválida!');
            }

            // Criar senha temporária e ativar usuário
            $usuario->update([
                'password' => $request->password,
                'ativo' => true,
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Senha confirmada com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao confirmar senha!');
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

    // Método para gerar CSV da busca de pesquisa de usuários
    public function generateCsvSearch(Request $request)
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

            // Coloca na variável os usuários do resultado da query. Ordenados por nome
            $usuarios = $query->orderByDesc('nome')->get();

            // Criar um arquivo temporario CSV
            // Str::ulid() gera caracteres únicos para o nome do arquivo
            $csvFileName = tempnam(sys_get_temp_dir(), 'usuarios_' . Str::ulid());

            // Abrir o arquivo para escrita
            $openFile = fopen($csvFileName, 'w');

            // Adicionar a linha de cabeçalho
            $header = ['id', 'nome', 'email', 'data_criacao'];

            // Escrever o cabeçalho no arquivo CSV
            // Cada valor separado por ;
            fputcsv($openFile, $header, ';');

            // Ler cada usuário e adicionar ao arquivo CSV
            foreach ($usuarios as $usuario) {
                $userArray = [
                    'id' => $usuario->id,
                    'nome' => $usuario->nome,
                    'email' => $usuario->email,
                    $usuario->created_at->format('d/m/Y H:i:s'),
                ];

                // Escrever os dados do usuário no arquivo CSV
                fputcsv($openFile, $userArray, ';');
            }

            // Fechar o arquivo após a escrita
            fclose($openFile);
            // Realizar download do arquivo CSV
            // Str::ulid() gera caracteres únicos para o nome do arquivo
            return response()->download($csvFileName, 'usuarios_pesquisa_' . Str::ulid() . '.csv');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao gerar CSV da pesquisa!');
        }
    }

    // Método para logar usuário
    public function login(Request $request)
    {
        try {
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao logar usuário!');
        }
    }
}
