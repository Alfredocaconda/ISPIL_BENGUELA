@extends('layouts.base')

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
                        <label for="codigo_inscricao" class="form-label">Código de Inscrição</label>
                        <input type="text" name="codigo_inscricao" id="codigo_inscricao" class="form-control" placeholder="Digite seu código aqui" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Verificar <i class="fa fa-search ms-2"></i>
                    </button>
                </form>

                @if(session('resultado'))
                    <div class="mt-4 text-center">
                        @if(session('resultado') == 'Admitido')
                            <div class="">
                                🎉 Parabéns! Você foi <strong>Admitido</strong>!  
                                <br> Aguarde mais informações sobre a matrícula.
                            </div>
                        @else
                            <div class="">
                                ❌ Infelizmente, você <strong>não foi admitido</strong>.  
                                <br> Você pode tentar novamente no próximo período.
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
