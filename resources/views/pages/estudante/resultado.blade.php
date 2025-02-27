@extends('layouts.base')
@section('title', 'RESULTADO DA CONSULTA')
@section('content')
<style>
    
    .admitido { color: green; font-weight: bold; }
    .nao-admitido { color: red; font-weight: bold; }
</style>
<div class="container">
    <h2>Resultado da Consulta</h2>
    <p><strong>Nome:</strong> {{ $inscricao->user->name }}</p>
    <p><strong>Número do Bilhete:</strong> {{ $inscricao->n_bilhete }}</p>
    <p><strong>Código de Inscrição:</strong> {{ $inscricao->codigo_inscricao }}</p>
    <p><strong>Nota:</strong> {{ $inscricao->nota }}</p>
    <p><strong>Estado :</strong>  <strong class="{{ $resultado == 'Admitido' ? 'admitido' : 'nao-admitido' }}">{{ $resultado }}</strong> </p>
</div>
@endsection

