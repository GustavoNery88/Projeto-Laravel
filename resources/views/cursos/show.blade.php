@extends('layouts.app')

@section('title', 'Detalhes do Curso')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Detalhes do Curso</h3>
        </div>

        <div class="card-body container">
            <div class="row">
                <div class="col-4">
                    <label><b>Nome do Curso:</b></label>
                    <p>{{ $curso->nome }}</p>
                </div>

                <div class="col-4">
                    <label><b>Descrição:</b></label>
                    <p>{{ $curso->descricao }}</p>
                </div>
                <div class="col-4">
                    <label><b>Autor:</b></label>
                    <p>{{ $curso->usuario->nome }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label><b>Data de Criação:</b></label>
                    <p>{{ $curso->created_at }}</p>
                </div>
                <div class="col-4">
                    <label><b>Data de Atualização:</b></label>
                    <p>{{ $curso->updated_at }}</p>
                </div>
            </div>
        </div>
    </div>

@endsection
