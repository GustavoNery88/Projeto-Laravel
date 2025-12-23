@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Detalhes do Usuário</h3>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Nome:</b> {{Auth::user()->nome}}</li>
                <li class="list-group-item"><b>E-mail:</b> {{Auth::user()->email}}</li>
            </ul>
        </div>
    </div>
@endsection
