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
    <h2>Estudantes Matriculados</h2>
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
                    @if($matricula->estado !== 'reconfirmado' || $matricula->ano_academico !== now()->year)
                    <td>
                        <a href="" class="btn btn-warning btn-sm">
                            Reconfirmar Matrícula
                        </a>
                    </td>
                    @else
                    <td>
                        <span class="badge bg-success">Reconfirmada ({{ $matricula->ano_academico }})</span>
                    </td>
                    @endif
                    <td>
                    <a href="{{ route('matricula.historico', $matricula->user_id) }}" class="btn btn-sm btn-info">
                        Ver Histórico
                    </a>
                    </td>
                    <td>
                    <a href="{{ route('matricula.pdf', $matricula->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                        Imprimir Matrícula
                    </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if(!$matriculaExistente || $reconfirmar)

<div class="container mt-4">
<h2>{{ $reconfirmar ? 'Reconfirmação de Matrícula' : 'Formulário de Matrícula' }}</h2>
    <form action="{{ route('matricula.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $inscricao->user->id }}">
        <input type="hidden" name="curso_id" value="{{ $inscricao->curso->id }}">
        @if($reconfirmar)
            <input type="hidden" name="reconfirmacao" value="1">
        @endif


        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" value="{{ $inscricao->user->name }}" readonly>
        </div>

        <div class="form-group">
            <label>Gênero</label>
            <input type="text" name="genero" class="form-control" value="{{ $inscricao->genero }}" readonly>
        </div>

        <div class="form-group">
            <label>Nº Bilhete</label>
            <input type="text" name="n_bilhete" class="form-control" value="{{ $inscricao->n_bilhete }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="{{ $inscricao->email }}">
        </div>
        <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control" value="{{ $inscricao->telefone }}">
        </div>

        <div class="form-group">
            <label>Curso</label>
            <input type="text" name="curso" class="form-control" value="{{ $inscricao->curso->name }}" readonly>
        </div>

        <div class="form-group">
            <label>Turno</label>
            <select name="turno" class="form-control" required>
                <option value="">Selecione o turno</option>
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
                <option value="Noite">Noite</option>
            </select>
        </div>
        <div class="form-group">
            <label>Ano Acadêmico</label>
            <select name="ano_academico" class="form-control" required>
                <option value="">Selecione</option>
                <option value="1º Ano">1º Ano</option>
                <option value="2º Ano">2º Ano</option>
                <option value="3º Ano">3º Ano</option>
                <option value="4º Ano">4º Ano</option>
                <option value="5º Ano">5º Ano</option>
            </select>
        </div>
        <div class="form-group">
            <label>Certificado Original</label>
            <input type="file" name="certificado" class="form-control" accept=".pdf,.docx">
        </div>

        <div class="form-group">
            <label>Cópia do Bilhete</label>
            <input type="file" name="bilhete" class="form-control" accept=".pdf,.docx">
        </div>
        <button type="submit" class="btn btn-{{ $reconfirmar ? 'warning' : 'primary' }}">
            {{ $reconfirmar ? 'Reconfirmar Matrícula' : 'Finalizar Matrícula' }}
        </button>
    </form>
</div>
@endif

@endsection
