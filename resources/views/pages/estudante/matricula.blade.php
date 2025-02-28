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
    <form action="{{route('matricula.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $matricula->id ?? '' }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="email" value="{{ Auth::user()->email }}" >
        <div class="row g-3">
            <div class="col-md-4">
                <label for="name">Nome Completo</label>
                <div class="form-input">
                    <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" readonly/>
                </div>
            </div>
            <div class="col-md-4">
                <label for="email">E-mail </label>
                <div class="form-input">
                    <input type="text" name="email" id="email" class="form-control"
                     value="{{ Auth::user()->email }}" readonly/>
                </div>
            </div>
            <div class="col-md-4">
                <label for="genero">Genero <span style="color: red;">*</span></label>
                <div class="form-input">
                    <select name="genero" id="genero" class="form-control">
                        <option value="">Selecionar o Genero</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <label for="data_nasc">Data de Nascimento <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="date" name="data_nasc" id="data_nasc" class="form-control" required/>
                </div>
            </div>
            <div class="col-md-4">
                <label for="n_bilhete">Nº do Bilhete <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="text" 
                            class="form-control" 
                            name="n_bilhete" 
                            id="n_bilhete" 
                            maxlength="14" 
                            oninput="formatBI(this)" 
                            placeholder="123456789AB123" required>
                    <!-- Mostra quantos caracteres ainda faltam -->
                    <small id="char_count" class="form-text text-muted">Faltam 14 caracteres</small>
                </div>
            </div>
            <div class="col-md-4">
                <label for="afiliacao">Nome do Pai e Mãe <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="text" name="afiliacao" id="afiliacao"
                     class="form-control" oninput="validarInput(this)" style=" padding: 5px;" required />
                </div>
            </div>
            <div class="col-md-4">
                <label for="telefone">Nº do Telefone <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="text" value="{{ old('telefone', $matricula->telefone ?? '') }}"
                           class="form-control" 
                           name="telefone" 
                           id="telefone" 
                           maxlength="9" 
                           oninput="formatTelefone(this)" 
                           placeholder="9XX-XXX-XXX" required>
                    <!-- Mostra quantos caracteres ainda faltam -->
                    <small id="char_count_telefone" class="form-text text-muted">Faltam 9 caracteres</small>
                </div>
            </div>
            <div class="col-md-4">
                <label for="provincia">Província <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="text" id="provincia"
                    class="form-control"  oninput="validarInput(this)" style=" padding: 5px;"
                    name="provincia" value="{{ old('provincia', $matricula->provincia ?? '') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="municipio">Município <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="text" id="municipio" name="municipio" value="{{ old('municipio', $matricula->municipio ?? '') }}"
                    class="form-control" oninput="validarInput(this)" style=" padding: 5px;" required>
                    </div>
            </div>
            <div class="col-md-4">
                <label for="naturalidade">Naturalidade <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="text" name="naturalidade" id="naturalidade"
                     class="form-control" oninput="validarInput(this)" style=" padding: 5px;" required/>
                </div>
            </div>
            <div class="col-md-4">
                <label for="nome_escola">Nome da Escola do Ensino Médio <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="text" name="nome_escola" id="nome_escola"
                     class="form-control" oninput="validarInput(this)" style=" padding: 5px;" required />
                </div>
            </div>
            <div class="col-md-4">
                <label for="curso_medio">Curso do Médio <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="text" name="curso_medio" id="curso_medio"
                     class="form-control" oninput="validarInput(this)" style=" padding: 5px;" required/>
                </div>
            </div>
            <div class="col-md-4">
                <label for="data_inicio">Ano de Inicio <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="date" name="data_inicio" id="data_inicio" class="form-control" required />
                </div>
            </div>
            <div class="col-md-4">
                <label for="data_termino">Ano de Termino <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="date" name="data_termino" id="data_termino" class="form-control" required/>
                </div>
            </div>
            
            <div class="col-md-4">
                <label for="curso_Id">Curso Selecionado</label>
                <div class="form-input">
                    <select name="curso_id" class="form-control" required>
                        @if ($cursoSelecionado) <!-- Verifica se um curso foi selecionado -->
                            <option value="{{ $cursoSelecionado->id }}" selected>
                                {{ $cursoSelecionado->name }}
                            </option>
                        @else
                            <option value="">Nenhum curso selecionado</option> <!-- Caso não haja curso selecionado -->
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <label for="turno">Seleciona o Período</label>
                <div class="form-input">
                    <select name="turno" class="form-control" required>
                        <option value="manha">Manhã</option>
                        <option value="tarde">Tarde</option>
                        <option value="noite">Noite</option>
                    </select>
                </div>
            </div>
        <h3>Documentos</h3>
            <div class="col-md-4">
                <label for="foto">Foto de Tipo Passe ( jpg, png, jpeg ) <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="file" class="form-control" id="foto" accept="image/*" name="foto" {{ isset($matricula) ? '' : 'required' }}>
                    @if(isset($matricula) && $matricula->foto)
                        <a href="{{ asset('uploads/' . $matricula->foto) }}" target="_blank">Visualizar Documento</a>
                    @else
                        <p>O documento ainda não foi carregado.</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <label for="certificado">Certificado de Conclusão ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="file"accept=".txt,.pdf,.docx" id="certificado" class="form-control" name="certificado" {{ isset($matricula) && $matricula->certificado ? '' : 'required' }}>
                    @if(isset($matricula) && $matricula->certificado)
                        <a href="{{ asset('uploads/' . $matricula->certificado) }}" target="_blank">Visualizar Documento</a>
                    @else
                        <p>O documento ainda não foi carregado.</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <label for="bilhete">Bilhete ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="file" id="bilhete" accept=".txt,.pdf,.docx" class="form-control" name="bilhete" {{ isset($matricula) ? '' : 'required' }}>
                    @if(isset($matricula) && $matricula->bilhete)
                        <a href="{{ asset('uploads/' . $matricula->bilhete) }}" target="_blank">Visualizar Documento</a>
                    @else
                        <p>O documento ainda não foi carregado.</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <label for="atestado">Atestado Médico ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="file" class="form-control" id="atestado" accept=".txt,.pdf,.docx" name="atestado" {{ isset($matricula) ? '' : 'required' }}>
                    @if(isset($matricula) && $matricula->atestado)
                        <a href="{{ asset('uploads/' . $matricula->atestado) }}" target="_blank">Visualizar Documento</a>
                    @else
                        <p>O documento ainda não foi carregado.</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <label for="recenciamento">Recenciamento Militar ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                <div class="form-input">
                    <input type="file" name="recenciamento" id="recenciamento" class="form-control"  accept=".txt,.pdf,.docx"  {{ isset($matricula) }}>
                    @if(isset($matricula) && $matricula->recenciamento)
                        <a href="{{ asset('uploads/' . $matricula->recenciamento) }}" target="_blank">Visualizar Documento</a>
                    @else
                        <p>O documento ainda não foi carregado.</p>
                    @endif
                </div>
            </div>
            <h3>Pagamento via Multicaixa Express</h3>
            <div class="col-md-4">
                <label for="numero_cartao" class="form-label">Número do Cartão Multicaixa Express</label>
                <input type="text" class="form-control" id="numero_cartao" name="numero_cartao" required>
                <input type="checkbox" name="termos_aceite" required> Eu aceito os termos de matrícula<br><br>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary" >
                {{ isset($matricula) ? 'Reconfirmar Matrícula' : 'Finalizar Matrícula' }}
            </button>
        </div>
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
