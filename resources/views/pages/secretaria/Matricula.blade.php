@extends('layouts.base')

@section('secretaria')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title" style="display: flex; justify-content: space-between; width: 100%">
                    <h4 class="card-title">Documentos da Escola </h4>
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
                        @foreach ($Matricula as $dados)
                            <tr>
                                <td>{{$dados->estudante_Id}}</td>
                                <td>{{$dados->classe_id}}</td>
                                <td>{{$dados->turma_Id}}</td>
                                <td>{{$dados->ano_lectivo}}</td>
                                <td>{{$dados->data_matricula}}</td>
                                <td>{{$dados->funcionario->nome}}</td>
                                <td>
                                    <a href="#Cadastrar" data-toggle="modal" class="text-primary" onclick="editar({{$dados}})" ><i class="fa fa-edit"></i></a>
                                    <a href="{{route('Matri.apagar',$dados->id)}}" class="text-danger"><i class="fa fa-trash"></i></a>
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
                        <h5 class="modal-title">Cadastrar Documentos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                   <form action="{{route('Matri.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="funcionario_id" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label for="estudante_Id">Estudante</label>
                            <div class="form-input">
                                <select class="form-control" name="estudante_Id" id="estudante_Id">
                                    @foreach (App\Models\estudante::orderBy('nome','ASC')->get() as $estudante_id)
                                        <option value="{{$estudante_id->id}}">{{$estudante_id->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="classe_id">Classe</label>
                            <div class="form-input">
                                <select class="form-control" name="classe_id" id="classe_id">
                                    @foreach (App\Models\Classe::orderBy('nome','ASC')->get() as $classe_id)
                                        <option value="{{$classe_id->id}}">{{$classe_id->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="turma_Id">Turma</label>
                            <div class="form-input">
                                <select class="form-control" name="turma_Id" id="turma_Id">
                                    @foreach (App\Models\Turma::orderBy('nome','ASC')->get() as $turma_Id)
                                        <option value="{{$turma_Id->id}}">{{$turma_Id->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-input">
                                <label for="ano_lectivo">Ano Letivo</label>
                            </div>
                            <input type="date" min="{{date('Y-m-d')}}" class="form-control" name="ano_lectivo" id="ano_lectivo">
                        </div>
                        <div class="form-group">
                            <label for="professor_id">Professor</label>
                            <div class="form-input">
                                <select class="form-control" name="professor_id" id="professor_id">
                                    @foreach (App\Models\Funcionario::orderBy('nome','ASC')->get() as $professor_id)
                                        <option value="{{$professor_id->id}}">{{$professor_id->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
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
