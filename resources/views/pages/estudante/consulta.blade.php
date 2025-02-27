@extends('layouts.base')
@section('title', 'CONSULTAR CANDIDATURA')
@section('content')

<!-- Conteúdo Principal -->
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center text-primary">🔍 Consultar Resultado da Inscrição</h2>
        <p class="text-center">Insira seu código de inscrição abaixo para verificar se foi admitido.</p>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('consulta.resultado') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="codigo_inscricao" class="form-label">Código de Inscrição ou Numero do Bilhete de Identidade</label>
                        <input type="text" name="codigo_inscricao" id="codigo_inscricao" class="form-control" placeholder="Digite seu código aqui" required>
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
