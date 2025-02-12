@extends('layouts.base')

@section('secretaria')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title" style="display: flex; justify-content: space-between; width: 100%">
                    <h4 class="card-title">Funcionarios da Escola</h4>
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
                            <th>Cargo</th>
                            <th>Departamento</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($valor as $func)
                            <tr>
                                <td>{{$func->name}}</td>
                                <td>{{$func->cargo}}</td>
                                <td>{{$func->telefone}}</td>
                                <td>{{$func->email}}</td>
                                <td>
                                    <a href="#Cadastrar" data-toggle="modal" class="text-primary" onclick="editar({{$valor}})" ><i class="fa fa-edit"></i></a>
                                    <a href="" class="text-danger"><i class="fa fa-trash"></i></a>
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
                   <form action="" method="post">
                    @csrf
                    <input type="hidden" name="id" id="id">
                        <div class="row">
                            <x-input-normal id="name" name="name" type="text" titulo="Nome Completo" alert="" />
                            <x-input-normal id="email" name="email" type="email" titulo="E-mail" alert="" />
                            <x-input-normal id="telefone" name="telefone" type="text" titulo="Telefone"  alert="Máximo de 9 caracteres." />
                            <x-select>
                                <option value="Diretor">Diretor</option>
                                <option value="Secretario">Secretario</option>
                                <option value="Secretario">Professor</option>
                            </x-select>    
                            <x-input-normal id="data_contratacao" name="data_contratacao" type="date" titulo="Data de Contrato" alert="" />
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <x-botao-form />
            </form>
            </div>
        </div>
    </div>
</div>

<script>
    const nomeInput = document.getElementById('telefone');
    const nomeHelp = document.getElementById('nomeHelp');
    const maxLength = 9;

    nomeInput.addEventListener('input', () => {
        const currentLength = nomeInput.value.length;
        nomeHelp.textContent = `Máximo de ${maxLength} caracteres. (${currentLength}/${maxLength})`;
    });
    function editar(valor) {
        document.getElementById('id').value = valor.id;
        document.getElementById('nome').value = valor.nome;
        document.getElementById('cargo').value = valor.cargo;
        document.getElementById('email').value = valor.email;
        document.getElementById('telefone').value = valor.telefone;
        document.getElementById('departamento').value = valor.departamento;
        document.getElementById('data_contratacao').value = valor.data_contratacao;
    }
    function limpar() {
        document.getElementById('id').value = "";
        document.getElementById('name').value = "";
        document.getElementById('cargo').value = "";
        document.getElementById('telefone').value = "";
        document.getElementById('email').value = "";
        document.getElementById('departamento').value = "";
        document.getElementById('data_contratacao').value = "";
    }
</script>
@endsection
