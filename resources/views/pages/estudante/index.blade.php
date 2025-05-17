@extends('layouts.app')
@section('title', 'Matrícula')
@section('content')
@if(session('Error'))
                    <div class="alert alert-danger">
                        <p>{{session('Error')}}</p>
                    </div>
                @endif
                @if(session('Sucesso'))
                    <div class="alert alert-success">
                        <p>{{session('Sucesso')}}</p>
                    </div>
                @endif
<div class="container">
    <h2>Estudante Matriculados</h2>
    <table class="table table-striped">
        <thead>
        
            <tr>
                <th>Nome</th>
                <th>Gênero</th>
                <th>Telefone</th>
                <th>Curso</th>
                <th>Turno</th>
                <th>Data de Matrícula</th>
                <th>Documentos</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($matriculas as $matricula)
                <tr>
                    <td>{{ $inscricao->user->name }}</td>
                    <td>{{ $matricula->genero }}</td>
                    <td>{{ $matricula->telefone }}</td>
                    <td>{{ $matricula->curso->name }}</td>
                    <td>{{ $matricula->turno }}</td>
                    <td>{{ $matricula->data_matricula }}</td>
                    <td>
                    <a href="" class="btn btn-sm btn-info">
                        Ver Histórico
                    </a>
                    </td>
                    <td>
                    <a href="" class="btn btn-sm btn-secondary" target="_blank">
                        Imprimir Matrícula
                    </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
