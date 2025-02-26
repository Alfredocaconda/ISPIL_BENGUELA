@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Inscrição realizada com sucesso!</h2>
    <p>Nome: {{ $candidato->user->name }}</p>
    <p>Email: {{ $candidato->email }}</p>    
    <form action="{{ route('inscricao.comprovativo') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $candidato->id }}">

        <label>Como deseja receber o comprovativo?</label><br>
        <input type="radio" name="metodo" value="email" required> Por E-mail<br>
        <input type="radio" name="metodo" value="pdf" required> Baixar PDF<br>

        <button type="submit" class="btn btn-primary mt-2">Confirmar</button>
    </form>
</div>
@endsection
