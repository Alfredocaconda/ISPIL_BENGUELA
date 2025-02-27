@extends('layouts.base')

@section('inscricao')
    <div class="container mt-4">
         <h2 class="mb-2">Matrícula</h2>
          <!-- EXIBIR ERROS DE VALIDAÇÃO AQUI -->
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <form action="{{ route('matricula.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <input type="hidden" name="id" value="{{ $matricula->id ?? '' }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="email" value="{{ Auth::user()->email }}" >
        <h3>Informações Pessoais</h3>
        <label>Nome Completo:</label>
        <input type="text" name="name" value="{{ old('name', $usuario->name ?? '') }}" >
        
        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email', $usuario->email ?? '') }}" >
        
        <label>Telefone:</label>
        <input type="text" name="telefone" value="{{ old('telefone', $matricula->telefone ?? '') }}" required>
        
        <label>Curso:</label>
        <select name="curso_id" required>
            @if ($cursoSelecionado) <!-- Verifica se um curso foi selecionado -->
                <option value="{{ $cursoSelecionado->id }}" selected>
                    {{ $cursoSelecionado->name }}
                </option>
            @else
                <option value="">Nenhum curso selecionado</option> <!-- Caso não haja curso selecionado -->
            @endif
        </select>

        
        <h3>Endereço</h3>
        
        <label>Província:</label>
        <input type="text" name="provincia" value="{{ old('provincia', $matricula->provincia ?? '') }}" required>
        
        <label>Município:</label>
        <input type="text" name="municipio" value="{{ old('municipio', $matricula->municipio ?? '') }}" required>
        
        <h3>Documentos</h3>
        
        <label>Certificado de Conclusão:</label>
        <input type="file" name="certificado" {{ isset($matricula) && $matricula->certificado ? '' : 'required' }}>
        @if(isset($matricula) && $matricula->certificado)
            <a href="{{ asset('uploads/' . $matricula->certificado) }}" target="_blank">Visualizar Documento</a>
        @else
            <p>O documento ainda não foi carregado.</p>
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
    
    
    
    </div>
 <script>
        document.addEventListener("DOMContentLoaded", function () {
            var generoSelect = document.getElementById("genero");
            var recenciamentoDiv = document.getElementById("recenciamento").closest(".col-md-4");

            function verificarGenero() {
                if (generoSelect.value === "Femenino") {
                    recenciamentoDiv.style.display = "none"; // Oculta o campo
                } else {
                    recenciamentoDiv.style.display = "block"; // Exibe o campo
                }
            }

            // Aciona a função quando o campo muda
            generoSelect.addEventListener("change", verificarGenero);

            // Executa a verificação no carregamento inicial (caso já tenha um valor definido)
            verificarGenero();
        });
      
        document.getElementById("curso_Id")?.addEventListener("change", function() {
            var nomeCurso = this.options[this.selectedIndex].getAttribute("data-nome");
            if (nomeCurso) {
                document.getElementById("nome_curso").value = nomeCurso;
                this.style.display = "none"; // Oculta o select
            }
        });

        function validarInput(campo) {
            if (campo.value.length < 5) {
                campo.style.borderColor = "red";
            } else if (campo.value.length > 6) {
                campo.style.borderColor = "green";
            } else {
                campo.style.borderColor = "gray"; // Volta ao padrão se estiver entre 5 e 6 caracteres
            }
        }

            function formatBI(input) {
                let value = input.value.toUpperCase(); // Converte letras para maiúsculas
                let formattedValue = "";
                
                for (let i = 0; i < value.length; i++) {
                    if (i < 9) { 
                        // Primeiros 9 caracteres devem ser números
                        if (/[0-9]/.test(value[i])) {
                            formattedValue += value[i];
                        }
                    } else if (i < 11) { 
                        // Os próximos 2 caracteres devem ser letras
                        if (/[A-Z]/.test(value[i])) {
                            formattedValue += value[i];
                        }
                    } else { 
                        // Os últimos 3 caracteres devem ser números
                        if (/[0-9]/.test(value[i])) {
                            formattedValue += value[i];
                        }
                    }
                }

                // Atualiza o valor do input com a formatação correta
                input.value = formattedValue;

                // Atualiza a contagem de caracteres restantes
                let maxLength = 14;
                let currentLength = input.value.length;
                let remaining = maxLength - currentLength;

                let counterElement = document.getElementById("char_count");
                counterElement.textContent = remaining > 0 ? `Faltam ${remaining} caracteres` : "Formato completo!";
            }
            function formatTelefone(input) {
                let value = input.value.toUpperCase(); // Converte letras para maiúsculas
                let formattedValue = "";
                
                for (let i = 0; i < value.length; i++) {
                    if (i < 9) { 
                        // Primeiros 9 caracteres devem ser números
                        if (/[0-9]/.test(value[i])) {
                            formattedValue += value[i];
                        }
                    } else if (i < 11) { 
                        // Os próximos 2 caracteres devem ser letras
                        if (/[A-Z]/.test(value[i])) {
                            formattedValue += value[i];
                        }
                    } else { 
                        // Os últimos 3 caracteres devem ser números
                        if (/[0-9]/.test(value[i])) {
                            formattedValue += value[i];
                        }
                    }
                }

                // Atualiza o valor do input com a formatação correta
                input.value = formattedValue;

                // Atualiza a contagem de caracteres restantes
                let maxLength = 9;
                let currentLength = input.value.length;
                let remaining = maxLength - currentLength;

                let counterElement = document.getElementById("char_count_telefone");
                counterElement.textContent = remaining > 0 ? `Faltam ${remaining} caracteres` : "Formato completo!";
            }
    </script>
@endsection
