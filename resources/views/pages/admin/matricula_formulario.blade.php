@extends('layouts.app')
@section('title', 'Matrícula')
@section('content')

@if(session('Error'))
    <div class="alert alert-danger"><p>{{ session('Error') }}</p></div>
@endif
@if(session('Sucesso'))
    <div class="alert alert-success"><p>{{ session('Sucesso') }}</p></div>
@endif

<div class="container">

    {{-- Lista de estudantes matriculados --}}
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
                <th>Histórico</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matriculas as $matricula)
                <tr>
                    <td>{{ $matricula->estudante->name }}</td>
                    <td>{{ $matricula->genero }}</td>
                    <td>{{ $matricula->telefone }}</td>
                    <td>{{ $matricula->curso->name }}</td>
                    <td>{{ $matricula->turno }}</td>
                    <td>{{ $matricula->data_matricula }}</td>
                    <td>
                        @if($matricula->estado !== 'reconfirmado' || $matricula->ano_academico !== now()->year)
                            <a href="{{ route('matricula.reconfirmar', $matricula->id) }}" class="btn btn-warning btn-sm">Reconfirmar Matrícula</a>
                        @else
                            <span class="badge bg-success">Reconfirmada ({{ $matricula->ano_academico }})</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('matricula.historico', $matricula->user_id) }}" class="btn btn-sm btn-info">Ver Histórico</a>
                    </td>
                    <td>
                        <a href="{{ route('matricula.pdf', $matricula->id) }}" class="btn btn-sm btn-secondary" target="_blank">Imprimir Matrícula</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Selecionar estudante para matrícula --}}
    <hr>
    <h3>Selecionar Estudante para Matrícula</h3>
    <form method="GET" id="formSelecionarEstudante">
        <select name="estudante_id" class="form-control" onchange="this.form.submit()">
            <option value="">-- Selecione o estudante --</option>
            @foreach($inscricoes as $inscricao)
             <!-- Mostrar botão de matrícula se a nota for suficiente -->
            @if ($inscricao->nota !== null && $inscricao->nota >= 10)
               <option value="{{ $inscricao->id }}" {{ request('estudante_id') == $inscricao->id ? 'selected' : '' }}>
                    {{ $inscricao->user->name }} - {{ $inscricao->curso->name }}
                </option> 
            @endif
            @endforeach
        </select>
    </form>

    {{-- Formulário de matrícula/reconfirmação --}}
    @if($inscricaoSelecionada)
        <hr>
        <h3>{{ $reconfirmar ? 'Reconfirmação de Matrícula' : 'Formulário de Matrícula' }}</h3>
        <form action="{{ route('matricula.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="estudante_id" value="{{ $inscricaoSelecionada->user_id }}">
            <input type="hidden" name="curso_id" value="{{ $inscricaoSelecionada->curso->id }}">
            <input type="hidden" name="reconfirmacao" value="1">


            <div class="row">
                <div class="form-group col-md-6">
                    <label>Nome</label>
                    <input type="text" class="form-control" value="{{ $inscricaoSelecionada->user->name }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Genero</label>
                    <input type="text" name="genero" id="genero" class="form-control" value="{{ $inscricaoSelecionada->genero}}">
                </div>
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $inscricaoSelecionada->email }}">
                </div>
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="ano_academico">Ano Academico</label>
                    <div class="form-input">
                        <select name="ano_academico" id="ano_academico" class="form-control" value="{{ $inscricaoSelecionada->ano_academico }}" >
                            <option value="">Selecionar o ano</option>
                            <option value="1º Ano">1º Ano</option>
                            <option value="2º Ano">2º Ano</option>
                            <option value="3º Ano">3º Ano</option>
                            <option value="4º Ano">4º Ano</option>
                            <option value="5º Ano">5º Ano</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Periodo</label>
                    <input type="text" name="turno" class="form-control" value="{{ $inscricaoSelecionada->periodo }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Nº do Bilhete</label>
                    <input type="text" name="n_bilhete" class="form-control" value="{{ $inscricaoSelecionada->n_bilhete }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Telefone</label>
                    <input type="text" name="telefone" class="form-control" value="{{ $inscricaoSelecionada->telefone }}">
                </div>
                <div class="form-group col-md-6">
                    <label>certificado</label>
                    <input type="file" accept=".txt,.pdf,.docx" name="certificado" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Bilhete</label>
                    <input type="file" accept=".txt,.pdf,.docx" name="bilhete" class="form-control">
                </div>
                 <div class="form-group col-md-6">
            <button type="submit" class="btn btn-{{ $reconfirmar ? 'warning' : 'primary' }}">
                {{ $reconfirmar ? 'Reconfirmar Matrícula' : 'Finalizar Matrícula' }}
            </button>
            </div>
        </form>
    @endif

</div>
@endsection
