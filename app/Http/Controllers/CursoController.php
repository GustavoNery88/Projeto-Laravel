<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    public function index()
    {
        // Recupera os cursos ordenados por ID decrescente e paginados
        $cursos = Curso::orderByDesc('id')->paginate(3);

        // passar usuarios para a view
        $usuarios = Usuario::all();
        return view('cursos.index', compact('cursos', 'usuarios'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'descricao' => 'required',
        ]);

        try {

            // Pegar usuario logado
            $usuario = Auth::user();

            Curso::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'id_usuario' => $usuario->id,
            ]);

            return redirect()->route('cursos.index')->with('success', 'Curso cadastrado com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao cadastrar curso!');
        }
    }

    public function inscreverCurso(Curso $curso)
    {

        try {
            $usuarioId = Auth::id();

            // Evita duplicar inscrição
            if (! $curso->usuarios()->where('usuarios.id', $usuarioId)->exists()) {
                $curso->usuarios()->attach(Auth::id(), [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                return redirect()->back()->with('error', 'Você já está inscrito neste curso!');
            }

            return redirect()->route('cursos.index')->with('success', 'Inscrição realizada com sucesso!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao cadastrar participante!' . $e->getMessage());
        }
    }

    public function show(Curso $curso)
    {
        return view('cursos.show', compact('curso'));
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso excluído com sucesso!');
    }

}
