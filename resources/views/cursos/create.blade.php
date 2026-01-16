@extends('layouts.app')

@section('title', 'Formulário de Cadastro de Cursos')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="mb-4 w-50 card p-4">
            <h3>Cadastrar Curso</h3>
            <form action=" {{ route('cursos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nome do Curso</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="nome">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Descrição do Curso</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="descricao"></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
