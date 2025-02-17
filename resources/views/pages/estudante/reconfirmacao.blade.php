@extends('layouts.app')

@section('reconfirmacao')
<div class="container">
    <h2 class="text-center">Reconfirmação de Matrícula</h2>

    <!-- Exibir status atual da matrícula -->
    <div class="alert 
        @if($matricula->status == 'Confirmado') alert-success 
        @elseif($matricula->status == 'Pendente') alert-warning 
        @else alert-danger @endif">
        Status da Matrícula: <strong>{{ $matricula->status }}</strong>
    </div>

    <!-- Se matrícula estiver confirmada, exibir botão para baixar comprovativo -->
    @if($matricula->status == 'Confirmado')
        <div class="text-center mb-3">
            <a href="{{ route('matricula.comprovativo') }}" class="btn btn-primary">
                📄 Baixar Comprovativo
            </a>
        </div>
    @else
        <!-- Formulário de Reconfirmação -->
        <form action="{{ route('matricula.reconfirmar') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="numero_cartao" class="form-label">Número do Cartão</label>
                <input type="text" name="numero_cartao" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor da Reconfirmação</label>
                <input type="text" name="valor" class="form-control" value="50000" readonly>
            </div>

            <button type="submit" class="btn btn-success">✅ Reconfirmar Matrícula</button>
        </form>
    @endif
</div>
@endsection
