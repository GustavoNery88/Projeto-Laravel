@extends('layouts.app')

@section('title', 'Formulário de Login de Usuários')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="card w-50">
            <div class="card-header">
                <h3>Login de Usuário</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                            <div>
                                <a href="#">Esqueci minha senha</a> <br>
                                <a href="{{ route('usuarios.create') }}">Cadastra-se</a>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p>E-mail: teste@gmail.com</p>
                            <p>Senha: teste123</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
