@extends('layouts.app')

@section('title', 'Detalhes do Curso')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Detalhes do Curso</h3>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Nome:</b> {{ $curso->nome }}</li>
                <li class="list-group-item"><b>Autor:</b> {{ $curso->usuario->nome }}</li>
                <li class="list-group-item"><b>Descrição:</b> {{ $curso->descricao }}</li>
                <li class="list-group-item"><b>Criado:</b>
                    {{ \Carbon\Carbon::parse($curso->created_at)->Format('d/m/Y H:i:s') }}</li>
                <li class="list-group-item"><b>Editado:</b>
                    {{ \Carbon\Carbon::parse($curso->updated_at)->Format('d/m/Y H:i:s') }}</li>
                <li class="list-group-item"><b>Inscritos:</b> {{ $curso->usuarios->count() }}</li>

                <li class="list-group-item"><b>Participantes:</b></li>

                @if ($curso->usuarios->isEmpty())
                    <li class="list-group-item text-muted">Nenhum participante inscrito</li>
                @else
                    @foreach ($curso->usuarios as $participante)
                        <li class="list-group-item">
                            {{ $participante->nome }} <br>
                            <small class="text-muted">
                                Inscrito em:
                                {{ \Carbon\Carbon::parse($participante->pivot->created_at)->format('d/m/Y H:i') }}
                            </small>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endsection
