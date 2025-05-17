@extends('layouts.app')
@section('title', 'Histórico Acadêmico')

@section('content')
<div class="container">
    <h3>Histórico Acadêmico de {{ $inscricao->user->name }}</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código de Natrícula</th>
                <th>Ano Acadêmico</th>
                <th>Curso</th>
                <th>Turno</th>
                <th>Data da Matrícula</th>
                <th>Estado</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matriculas as $matricula)
                <tr>
                    <td>{{ $matricula->codigo_matricula }}</td>
                    <td>{{ $matricula->ano_academico }}</td>
                    <td>{{ $matricula->curso->name }}</td>
                    <td>{{ $matricula->turno }}</td>
                    <td>{{ \Carbon\Carbon::parse($matricula->data_matricula)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($matricula->estado) }}</td>
                    <td>
                        <a href="{{ route('matricula.historico.pdf2', $usuario->id) }}" class="btn btn-sm btn-danger mb-3" target="_blank">
                            Exportar PDF
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
