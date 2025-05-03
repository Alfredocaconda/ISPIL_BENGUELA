@extends('layouts.base') 
@section('title', 'Resultado da Matrícula')
@section('content')

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center text-success">✅ Resultado da Matrícula</h2>

        <div class="mt-4">
            <p><strong>Nome:</strong> {{ optional($matricula->user)->name }}</p>
            <p><strong>Email:</strong> {{ $matricula->email }}</p>
            <p><strong>Gênero:</strong> {{ $matricula->genero }}</p>
            <p><strong>Data de Nascimento:</strong> {{ \Carbon\Carbon::parse($matricula->data_nasc)->format('d/m/Y') }}</p>
            <p><strong>Nº do Bilhete:</strong> {{ $matricula->n_bilhete }}</p>
            <p><strong>Telefone:</strong> {{ $matricula->telefone }}</p>
            <!--<p><strong>Curso:</strong> {{ optional($matricula->curso)->name }}</p>-->
            <p><strong>Turno:</strong> {{ $matricula->turno }}</p>
            <p><strong>Estado da Matrícula:</strong> {{ $matricula->estado }}</p>
            <p><strong>Data da Matrícula:</strong> {{ \Carbon\Carbon::parse($matricula->data_matricula)->format('d/m/Y H:i') }}</p>
            <!--<p><strong>Reconfirmação Pendente:</strong> {{ $matricula->reconfirmacao_pendente ? 'Sim' : 'Não' }}</p>-->
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">🔙 Voltar</a>
    </div>
</div>

@endsection
