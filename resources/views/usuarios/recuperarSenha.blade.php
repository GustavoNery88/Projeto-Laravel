@extends('layouts.app')

@section('title', 'Formulário de Recuperação de Senha')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="card w-50">
            <div class="card-header">
                <h3>Recuperar Senha</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <form action="{{ route('usuarios.recuperarSenha') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nome" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Recuperar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
