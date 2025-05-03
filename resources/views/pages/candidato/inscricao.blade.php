@extends('layouts.base')

@section('inscricao')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <div class="container mt-4">
         <h2 class="mb-2">FORMULÁRIO DE INSCRIÇÃO</h2>
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
        <form action="{{route('inscricao.cadastro')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="email" value="{{ Auth::user()->email }}" >
            <div class="row g-3">
                <!-- Criando 10 inputs em uma grade responsiva -->
                <div class="col-md-4">
                    <label for="name">Nome Completo</label>
                    <div class="form-input">
                        <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" readonly/>
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
                    <label for="provincia">Província <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="provincia" id="provincia"
                         class="form-control"  oninput="validarInput(this)" style=" padding: 5px;" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="municipio">Município <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="municipio" id="municipio"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" required />
                    </div>
                </div>
               <!-- <div class="col-md-4">
                    <label for="naturalidade">Naturalidade <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="naturalidade" id="naturalidade"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" required/>
                    </div>
                </div>-->
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
               <!-- <div class="col-md-4">
                    <label for="afiliacao">Nome do Pai e Mãe <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="afiliacao" id="afiliacao"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" required />
                    </div>
                </div>-->
                <div class="col-md-4">
                    <label for="telefone">Nº do Telefone <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" 
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
               <!-- <div class="col-md-4">
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
-->
                <div class="col-md-4">
                    <label for="email">E-mail </label>
                    <div class="form-input">
                        <input type="text" name="email" id="email" class="form-control"
                         value="{{ Auth::user()->email }}" readonly/>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="curso_id">Curso Selecionado</label>
                    <div class="form-input">
                        @if(isset($cursoSelecionado))
                            <input type="hidden" name="curso_id" value="{{ $cursoSelecionado->id }}">
                            <input type="text" class="form-control" value="{{ $cursoSelecionado->name }}" readonly>
                        @else
                            <p class="text-danger">Nenhum curso selecionado.</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="periodo">Seleciona o Período</label>
                    <div class="form-input">
                        <select name="periodo" class="form-control" required>
                            <option value="Manhã">Manhã</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Noite">Noite</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="foto">Foto de Tipo Passe ( jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept="image/*" name="foto" id="foto" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="certificado">Certificado ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="certificado" id="certificado" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="bilhete">Bilhete ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="bilhete" id="bilhete" class="form-control" required/>
                    </div>
                </div>
               <!-- <div class="col-md-4">
                    <label for="recenciamento">Recenciamento Militar ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="recenciamento" id="recenciamento" 
                        class="form-control"/>
                    </div>
                </div>-->
                <div class="col-md-4">
                    <label for="comprovativo">Comprovativ de Pagamento ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="comprovativo" id="comprovativo" class="form-control" required/>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Enviar Inscrição</button>
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
      
        document.getElementById("curso_id")?.addEventListener("change", function() {
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
