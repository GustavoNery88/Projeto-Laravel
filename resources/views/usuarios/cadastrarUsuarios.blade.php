@extends('layouts.app')

@section('title', 'Formulário de Cadastro de Usuários')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Cadastrar Usuário</h3>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{ old('password') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
            <div class="search-form mb-5">
                <h5>Poucos Registros</h5>
                <form action="{{ route('usuarios.importCsv') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="input-group mb-3 d-flex gap-2">
                        <label class="input-group-text" for="inputGroupFile01">Upload CSV</label>
                        <input type="file" name="file" class="form-control" id="inputGroupFile01" accept=".csv">
                        <button class="btn btn-success" type="submit">Importar</button>
                    </div>
                </form>
            </div>
            <div class="search-form">
                <h5>Muitos Registros</h5>
                <form action="{{ route('usuarios.importCsvJobs') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="input-group mb-3 d-flex gap-2">
                        <label class="input-group-text" for="inputGroupFile01">Upload CSV</label>
                        <input type="file" name="file" class="form-control" id="inputGroupFile01" accept=".csv">
                        <button class="btn btn-success" type="submit">Importar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
