@extends('layouts.app')

@section('title', 'Lista de Usuários')

@section('content')
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                    <tr>
                        <th scope="row">{{ $usuario->id }}</th>
                        <td>{{ $usuario->nome }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td class="botoes-usuarios">
                            <a href="{{ route('usuarios.show', ['usuario' => $usuario->id]) }}"><i class="bi bi-eye-fill acoes btn btn-primary"></i></a>
                            <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id]) }}"><i class="bi bi-pencil-square acoes btn btn-secondary"></i></a>

                            <form id="delete-form-{{ $usuario->id }}" action="{{ route('usuarios.destroy', ['usuario' => $usuario->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="button" onclick="confirmDelete({{ $usuario->id }})"> <i class="bi bi-trash3-fill btn btn-danger"></i></button>
                            </form>
                            
                        </td>
                    </tr>
                @empty
                    <p>Nenhum usuário encontrado.</p>
                @endforelse
            </tbody>
        </table>
        <div>
            {!! $usuarios->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>
@endsection
