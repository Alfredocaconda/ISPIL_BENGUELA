@extends('layouts.app')
@section('title', 'ISPIL-BENGUELA')
@section('secretaria')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title" style="display: flex; justify-content: space-between; width: 100%">
                    <h4 class="card-title">Cadastrar Matrícula</h4>
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
                            <th>Estudante</th>
                            <th>Classe</th>
                            <th>Turma</th>
                            <th>Ano lectivo</th>
                            <th>Data de Matrícula</th>
                            <th>Professor</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inscricao as $dados)
                            <tr>
                                <td>{{ $dados->user->name }}</td>
                                <td>{{ $dados->genero }}</td>
                                <td>{{ $dados->n_bilhete }}</td>
                                <td>{{ $dados->telefone }}</td>
                                <td>{{ $dados->curso->name }}</td>
                                <td>{{ $dados->estado }}</td>
                                <td>{{$dados->user->nome}}</td>
                                <td>
                                    <a href="#Cadastrar" data-toggle="modal" class="text-primary" onclick="editar({{$dados}})" ><i class="fa fa-edit"></i></a>
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
                        <h5 class="modal-title">Cadastrar Matrícula</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="inscricao_id" value="{{ $inscricao->id }}">

                    <div class="mb-3">
                        <label>Nome Completo:</label>
                        <input type="text" class="form-control" value="{{ $inscricao->user->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Nº BI:</label>
                        <input type="text" class="form-control" value="{{ $inscricao->n_bilhete }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Curso:</label>
                        <input type="text" class="form-control" value="{{ $inscricao->curso->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="turno">Turno:</label>
                        <select name="turno" id="turno" class="form-control" required>
                            <option value="">Selecionar turno</option>
                            <option value="Manhã">Manhã</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Noite">Noite</option>
                        </select>
                    </div>

                    <!-- Pode incluir outros campos aqui se quiser -->
                    
                    <button type="submit" class="btn btn-success">Finalizar Matrícula</button>
                </form>
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
    function editar(valor) {
        document.getElementById('id').value = valor.id;
        document.getElementById('ano_lectivo').value = valor.ano_lectivo;
        document.getElementById('turma_Id').value = valor.turma_Id;
        document.getElementById('classe_id').value = valor.classe_id;
        document.getElementById('estudante_Id').value = valor.estudante_Id;
        document.getElementById('professor_id').value = valor.professor_id;
        document.getElementById('descricao').value = valor.descricao;
    }
    function limpar() {
        document.getElementById('id').value = "";
        document.getElementById('tipo_documento').value = "";
        document.getElementById('descricao').value = "";
    }
</script>
@endsection
