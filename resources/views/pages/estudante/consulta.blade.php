@extends('layouts.base')
@section('title', 'CONSULTAR CANDIDATURA')
@section('content')

<!-- Conteúdo Principal -->
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center text-primary">🔍 Consultar Resultado da Matrícula</h2>
        <p class="text-center">Insira seu código de Matrícula abaixo para verificar o estado.</p>

        <div class="row justify-content-center">
            <div class="col-md-6">
                    @if(session('erro'))
                    <div class="alert alert-danger mt-3 text-center">
                        {{ session('erro') }}
                    </div>
                    @endif

            <form action="{{ route('consulta-matricula') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="codigo_matricula" class="form-label">
                        Código de Matrícula ou Número do Bilhete de Identidade
                    </label>
                    <input type="text" name="codigo_matricula" id="codigo_matricula"
                        class="form-control" placeholder="Digite seu código aqui" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Verificar <i class="fa fa-search ms-2"></i>
                </button>
            </form>

            </div>
        </div>
    </div>
</div>
@endsection
