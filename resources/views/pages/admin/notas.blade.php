@extends('layouts.app')

@section('cursos')

<form action="{{ route('notas.store') }}" method="POST">
    @csrf

    <label for="candidato">Candidato:</label>
    <select name="inscricao_id" id="candidato" required>
        <option value="">Selecione um candidato</option>
        @foreach($inscricoes as $inscricao)
            <option value="{{ $inscricao->id }}" data-curso="{{ $inscricao->curso->name ?? '' }}">
                {{ $inscricao->name }}
            </option>
        @endforeach
    </select>

    <label for="curso">Curso:</label>
    <input type="text" id="curso" name="curso_name" readonly>

    <label for="nota">Nota:</label>
    <input type="number" name="nota" step="0.1" min="0" max="10" required>

    <button type="submit">Enviar</button>
</form>

<script>
    $(document).ready(function() {
        $('#candidato').change(function() {
            let cursoname = $('#candidato option:selected').data('curso'); // Obtém o curso do candidato
            $('#curso').val(cursoname); // Insere no campo de curso
        });
    });
</script>


@endsection
   