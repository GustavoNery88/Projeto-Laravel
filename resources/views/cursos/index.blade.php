@extends('layouts.app')

@section('title', 'Lista de Usuários')

@section('content')
    <div>
        <div class="search-form mb-5">
            <a class="btn btn-primary" href="{{ route('cursos.create') }}">Cadastrar</a>
        </div>
        <div class="search-form mb-5">
            <div class="d-flex gap-2 mb-3">
                <input id="search" type="search" class="form-control" placeholder="Buscar curso" onchange="buscarCursos()">


            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cursos as $curso)
                    <tr>
                        <th scope="row">{{ $curso->id }}</th>
                        <td>{{ $curso->nome }}</td>
                        <td>{{ $curso->usuario->nome }}</td>
                        <td class="botoes-usuarios">
                            <a href="{{ route('cursos.show', $curso->id) }}"><i
                                    class="bi bi-eye-fill acoes btn btn-primary"></i></a>
                            <a href="#"><i class="bi bi-pencil-square acoes btn btn-secondary"></i></a>
                            <div>
                                <button class="bi bi-trash3-fill btn btn-danger " type="button" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"></button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            Tem certeza que deseja excluir esse curso?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>

                                            <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="" action="{{ route('cursos.inscreverCurso', $curso->id) }}" method="POST">
                                @csrf
                                <button type="submit"> <i class="bi bi-journal-plus btn btn-success"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <p>Nenhum curso encontrado.</p>
                @endforelse
            </tbody>
        </table>

        <div>
            {!! $cursos->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>

@endsection
