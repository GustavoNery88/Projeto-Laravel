@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Detalhes do Usuário</h3>
            <div>
                <a class="btn btn-secondary" href="{{ route('usuarios.generatePdf', ['usuario' => $usuario->id]) }}">Gerar PDF</a>
                <a class="btn btn-secondary" href="{{ route('usuarios.enviarEmailPdf', ['usuario' => $usuario->id]) }}">Enviar E-mail</a>
            </div>

        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Nome:</b> {{ $usuario->nome }}</li>
                <li class="list-group-item"><b>E-mail:</b> {{ $usuario->email }}</li>
                <li class="list-group-item"><b>Criado:</b> {{ \Carbon\Carbon::parse($usuario->created_at)->Format('d/m/Y H:i:s') }}</li>
                <li class="list-group-item"><b>Editado:</b> {{ \Carbon\Carbon::parse($usuario->updated_at)->Format('d/m/Y H:i:s') }}</li>
            </ul>
        </div>
    </div>
@endsection
