@extends('layouts.app')
@section('title', 'Matrícula')
@section('content')
@if(session('Error'))
                    <div class="alert alert-danger">
                        <p>{{session('Error')}}</p>
                    </div>
                @endif
                @if(session('Sucesso'))
                    <div class="alert alert-success">
                        <p>{{session('Sucesso')}}</p>
                    </div>
                @endif
<div class="container">
    <h2>Estudantes Matriculados</h2>
    <table class="table table-striped">
        <thead>
        
            <tr>
                <th>Nome</th>
                <th>Gênero</th>
                <th>Telefone</th>
                <th>Curso</th>
                <th>Turno</th>
                <th>Data de Matrícula</th>
                <th>Documentos</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($matriculas as $matricula)
                <tr>
                    <td>{{ $inscricao->user->name }}</td>
                    <td>{{ $matricula->genero }}</td>
                    <td>{{ $matricula->telefone }}</td>
                    <td>{{ $matricula->curso->name }}</td>
                    <td>{{ $matricula->turno }}</td>
                    <td>{{ $matricula->data_matricula }}</td>
                    @if($matricula->estado !== 'reconfirmado' || $matricula->ano_academico !== now()->year)
                    <td>
                    <a href="{{ route('matricula.reconfirmar', $matricula->id) }}" class="btn btn-warning btn-sm">
                        Reconfirmar Matrícula
                    </a>
                    </td>
                    @else
                    <td>
                        <span class="badge bg-success">Reconfirmada ({{ $matricula->ano_academico }})</span>
                    </td>
                    @endif
                    <td>
                    <a href="{{ route('matricula.historico', $matricula->user_id) }}" class="btn btn-sm btn-info">
                        Ver Histórico
                    </a>
                    </td>
                    <td>
                    <a href="{{ route('matricula.pdf', $matricula->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                        Imprimir Matrícula
                    </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    @if(!$matriculaExistente || $reconfirmar)
        <h2>{{ $reconfirmar ? 'Reconfirmação de Matrícula' : 'Formulário de Matrícula' }}</h2>
        <form action="{{ route('matricula.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <input type="hidden" name="user_id" value="{{ $inscricao->user->id }}">
            <input type="hidden" name="curso_id" value="{{ $inscricao->curso->id }}">
            @if($reconfirmar)
                <input type="hidden" name="reconfirmacao" value="1">
            @endif
            <div class="row">
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="telefone">Nome Completo <span style="color: red;">*</span></label>
                    <div class="form-input">
                    <input id="name" name="name" type="text" class="form-control"
                     titulo="Nome Completo" alert="" value="{{ $inscricao->user->name }}" readonly />
                    </div>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-6">
                <label for="telefone">E-mail <span style="color: red;">*</span></label>
                    <div class="form-input">
                    <input id="email" name="email"class="form-control" type="email" titulo="E-mail" alert="" value="{{ $inscricao->email }}"/>
                    </div>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-6">
                <label for="telefone">Genero <span style="color: red;">*</span></label>
                    <div class="form-input">
                    <input id="genero" name="genero"class="form-control" type="genero" titulo="Genero" alert="" value="{{ $inscricao->genero }}" readonly/>
                    </div>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-6">
                <label for="telefone">Curso <span style="color: red;">*</span></label>
                    <div class="form-input">
                    <input id="curso" name="curso" class="form-control" type="curso" titulo="Curso" alert="" value="{{ $inscricao->curso->name }}" readonly/>
                    </div>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="telefone">Nº do Telefone <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" 
                                class="form-control" 
                                name="telefone" 
                                id="telefone" value="{{ $inscricao->telefone }}"
                                maxlength="9" 
                                oninput="formatTelefone(this)" 
                                placeholder="9XX-XXX-XXX"  >
                        
                        <!-- Mostra quantos caracteres ainda faltam -->
                        <small id="char_count_telefone" class="form-text text-muted">Faltam 9 caracteres</small>
                    </div>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="n_bi">Número do BI</label>
                    <div class="form-input">
                        <input type="text" 
                                class="form-control" 
                                name="n_bilhete" 
                                id="n_bi" 
                                maxlength="14" 
                                oninput="formatBI(this)" 
                                placeholder="123456789AB123" value="{{ $inscricao->n_bilhete }}" readonly/>
                        
                        <!-- Mostra quantos caracteres ainda faltam -->
                        <small id="char_count" class="form-text text-muted">Faltam 14 caracteres</small>
                    </div>
                </div>                        
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="turno">Selecione o Periodo</label>
                    <div class="form-input">
                        <select name="turno" id="turno" required class="form-control">
                        <option value="Manhã">Manhã</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noite">Noite</option>
                        </select>
                    </div>
                </div>   
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="turno">Selecione Ano Acadêmico</label>
                    <div class="form-input">
                        <select name="ano_academico" id="ano_academico" required class="form-control">
                        <option value="1º Ano">1º Ano</option>
                        <option value="2º Ano">2º Ano</option>
                        <option value="3º Ano">3º Ano</option>
                        <option value="4º Ano">4º Ano</option>
                        <option value="5º Ano">5º Ano</option>
                        </select>
                    </div>
                </div>  
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="telefone">Cópia do Bilhete <span style="color: red;">*</span></label>
                    <div class="form-input">
                    <input id="bilhete" class="form-control" accept=".pdf,.docx"
                     name="bilhete" type="file" titulo="Cópia do Bilhete" alert="" />
                    </div>
                </div>
                @if (!$reconfirmar)
                <div class="form-group col-12 col-md-6 col-lg-6">
                    <label for="telefone">Certificado Original <span style="color: red;">*</span></label>
                    <div class="form-input">
                    <input id="certificado" class="form-control" accept=".pdf,.docx"
                    name="certificado" type="file" titulo="Certificado Original" alert=""
                    value="{{ $inscricao->certificado }}" readonly />
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-{{ $reconfirmar ? 'warning' : 'primary' }}">
            {{ $reconfirmar ? 'Reconfirmar Matrícula' : 'Finalizar Matrícula' }}
        </button>
            </div>
        </form>
    @endif
@endsection
<script>
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
