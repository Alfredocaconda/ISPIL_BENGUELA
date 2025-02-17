@extends('layouts.app')
@section('title', 'ISPIL-BENGUELA')
@section('secretaria')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title" style="display: flex; justify-content: space-between; width: 100%">
                    <h4 class="card-title">Funcionarios do ISPIL</h4>
                    <a href="#Cadastrar" data-toggle="modal" style="font-size: 20pt"><i class="fa fa-plus-circle"></i></a>
                </div>
            </div>
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
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table data-tables table-striped">
                    <thead>
                        <tr class="ligth">
                            <th>Nome</th>
                            <th>Número BI</th>
                            <th>Cargo</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($valor as $func)
                            <tr>
                                <td>{{$func->name}}</td>
                                <td>{{$func->n_bi}}</td>
                                <td>{{$func->cargo}}</td>
                                <td>{{$func->telefone}}</td>
                                <td>{{$func->email}}</td>
                                <td>
                                    <a href="#Cadastrar" data-toggle="modal" class="text-primary" onclick="editar({{ json_encode($func) }})"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('funcio.apagar',$func->id)}}" class="text-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Cadastrar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Funcionários</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    
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

                    <form action="{{ route('funcio.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <x-input-normal id="name" name="name" type="text" titulo="Nome Completo" alert="" />
                            <x-input-normal id="email" name="email" type="email" titulo="E-mail" alert="" />
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="telefone">Nº do Telefone <span style="color: red;">*</span></label>
                                <div class="form-input">
                                    <input type="text" 
                                           class="form-control" 
                                           name="telefone" 
                                           id="telefone" 
                                           maxlength="9" 
                                           oninput="formatTelefone(this)" 
                                           placeholder="9XX-XXX-XXX">
                                    
                                    <!-- Mostra quantos caracteres ainda faltam -->
                                    <small id="char_count_telefone" class="form-text text-muted">Faltam 9 caracteres</small>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="n_bi">Número do BI</label>
                                <div class="form-input">
                                    <input type="text" 
                                           class="form-control" 
                                           name="n_bi" 
                                           id="n_bi" 
                                           maxlength="14" 
                                           oninput="formatBI(this)" 
                                           placeholder="123456789AB123">
                                    
                                    <!-- Mostra quantos caracteres ainda faltam -->
                                    <small id="char_count" class="form-text text-muted">Faltam 14 caracteres</small>
                                </div>
                            </div>                        
                            <x-select name="cargo">
                                <option value="Diretor">Diretor</option>
                                <option value="Secretaria">Secretario</option>
                                <option value="Professor">Professor</option>
                            </x-select>    
                            <x-input-normal id="data_contratacao" name="data_contratacao" type="date" titulo="Data de Contrato" alert="" />
                        </div>

                        <div class="modal-footer">
                            <x-botao-form />
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<script>

    function editar(valor) {
        if (!valor) {
            console.error("Erro: Dados do funcionário não encontrados.");
            return;
        }

        document.getElementById('id').value = valor.id || '';
        document.getElementById('name').value = valor.name || '';
        document.getElementById('cargo').value = valor.cargo || '';
        document.getElementById('email').value = valor.email || '';
        document.getElementById('n_bi').value = valor.n_bi || '';
        document.getElementById('telefone').value = valor.telefone || '';
        document.getElementById('data_contratacao').value = valor.data_contratacao || '';

        // Modificar a URL do formulário para apontar para update se for edição
        let form = document.getElementById('formFuncionario');
        if (valor.id) {
            form.action = `/funcio/${valor.id}`;  // Ajuste conforme sua rota de atualização
            form.method = "POST"; // Laravel aceita PUT/PATCH com _method
            form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
        } else {
            form.action = "{{ route('funcio.store') }}"; // Criar novo
        }
    }

    function limpar() {
        document.getElementById('id').value = "";
        document.getElementById('name').value = "";
        document.getElementById('cargo').value = "";
        document.getElementById('telefone').value = "";
        document.getElementById('email').value = "";
        document.getElementById('n_bi').value = "";
        document.getElementById('data_contratacao').value = "";
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
