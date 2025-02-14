@extends('layouts.base')

@section('inscricao')
    <div class="container mt-4">
         <h2 class="mb-2">Candidato</h2>
        <form action="{{route('inscricao.cadastro')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="name" value="{{ Auth::user()->name }}" >
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
                         class="form-control"  oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="municipio">Município <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="municipio" id="municipio"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="naturalidade">Naturalidade <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="naturalidade" id="naturalidade"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="data_nasc">Data de Nascimento <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="date" name="data_nasc" id="data_nasc" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="n_bilhete">Nº do Bilhete <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="n_bilhete" id="n_bilhete" class="form-control" />
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label for="afiliacao">Nome do Pai e Mãe <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="afiliacao" id="afiliacao"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="telefone">Nº do Telefone <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="number" name="telefone" id="telefone"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="nome_escola">Nome da Escola <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="nome_escola" id="nome_escola"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="curso_medio">Curso do Médio <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="curso_medio" id="curso_medio"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="date_inicio">Data de Inicio <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="date" name="date_inicio" id="date_inicio" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="date_termino">Data de Termino <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="date" name="date_termino" id="date_termino" class="form-control" />
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
                    <label for="curso_Id">Curso Selecionado</label>
                    <div class="form-input">
                        @if(isset($cursos))
                            <input type="hidden" name="curso_Id" value="{{ $cursos->id }}">
                            <input type="text" class="form-control" value="{{ $cursos->name }}" readonly>
                        @else
                            <p class="text-danger">Nenhum curso selecionado.</p>
                        @endif
                    </div>
                </div>
                

                <div class="col-md-4">
                    <label for="foto">Foto de Tipo Passe ( jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept="image/*" name="foto" id="foto" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="certificado">Certificado ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="certificado" id="certificado" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="bilhete">Bilhete ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="bilhete" id="bilhete" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="recenciamento">Recenciamento Militar ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="recenciamento" id="recenciamento" 
                        class="form-control" />
                    </div>
                </div>
                <h3>Pagamento via Multicaixa Express</h3>
                <div class="col-md-4">
                    <label for="numero_cartao" class="form-label">Número do Cartão Multicaixa Express</label>
                    <input type="text" class="form-control" id="numero_cartao" name="numero_cartao" required>
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

        @if(session('comprovativo'))
            <a id="download-comprovativo" href="{{ session('comprovativo') }}" download hidden></a>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("download-comprovativo").click();
                });
            </script>
        @endif


    </script>
@endsection
