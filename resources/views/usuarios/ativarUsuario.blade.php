@extends('layouts.app')

@section('title', 'Formulário de Confimar Senha')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Confimar Senha</h3>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <form action="{{ route('usuarios.ativarUsuario') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="senha_ativação" class="form-label">Senha de Ativação</label>
                        <input type="text" class="form-control" id="senha_ativação" name="senha_ativação"
                            value="{{ old('senha_ativação') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{ old('password') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nome" class="form-label">Confimar senha</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            value="{{ old('password_confirmation') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
