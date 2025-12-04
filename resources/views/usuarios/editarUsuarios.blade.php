@extends('layouts.app')

@section('title', 'Formulário de Edição de Usuários')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Editar Usuários</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.update', ['usuario' => $usuario->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $usuario->nome) }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email) }}">
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
@endsection
