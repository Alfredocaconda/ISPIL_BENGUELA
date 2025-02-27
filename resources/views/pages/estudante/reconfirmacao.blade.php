<form action="{{ route('matricula.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <input type="hidden" name="id" value="{{ $matricula->id ?? '' }}">
    
    <h3>Informações Pessoais</h3>
    
    <label>Nome Completo:</label>
    <input type="text" name="name" value="{{ old('name', $usuario->name ?? '') }}" required>
    
    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email', $usuario->email ?? '') }}" required>

    <label>Telefone:</label>
    <input type="text" name="telefone" value="{{ old('telefone', $matricula->telefone ?? '') }}" required>

    <label>Curso:</label>
    <select name="curso_id" required>
        @foreach ($cursos as $curso)
            <option value="{{ $curso->id }}" {{ (isset($matricula) && $matricula->curso_id == $curso->id) ? 'selected' : '' }}>
                {{ $curso->nome }}
            </option>
        @endforeach
    </select>

    <h3>Endereço</h3>

    <label>Província:</label>
    <input type="text" name="provincia" value="{{ old('provincia', $matricula->provincia ?? '') }}" required>

    <label>Município:</label>
    <input type="text" name="municipio" value="{{ old('municipio', $matricula->municipio ?? '') }}" required>

    <h3>Documentos</h3>
    
    <label>Certificado de Conclusão:</label>
    <input type="file" name="certificado" {{ isset($matricula) ? '' : 'required' }}>
    @if(isset($matricula) && $matricula->certificado)
        <a href="{{ asset('uploads/' . $matricula->certificado) }}" target="_blank">Visualizar Documento</a>
    @endif
    
    <label>Bilhete de Identidade:</label>
    <input type="file" name="bilhete" {{ isset($matricula) ? '' : 'required' }}>
    @if(isset($matricula) && $matricula->bilhete)
        <a href="{{ asset('uploads/' . $matricula->bilhete) }}" target="_blank">Visualizar Documento</a>
    @endif

    <label>Atestado Médico:</label>
    <input type="file" name="atestado" {{ isset($matricula) ? '' : 'required' }}>
    @if(isset($matricula) && $matricula->atestado)
        <a href="{{ asset('uploads/' . $matricula->atestado) }}" target="_blank">Visualizar Documento</a>
    @endif

    <label>Foto:</label>
    <input type="file" name="foto" {{ isset($matricula) ? '' : 'required' }}>
    @if(isset($matricula) && $matricula->foto)
        <a href="{{ asset('uploads/' . $matricula->foto) }}" target="_blank">Visualizar Documento</a>
    @endif

    <h3>Pagamento</h3>
    <label>Número do Cartão:</label>
    <input type="text" name="numero_cartao" required>

    <br><br>
    <button type="submit">
        {{ isset($matricula) ? 'Reconfirmar Matrícula' : 'Finalizar Matrícula' }}
    </button>
</form>
