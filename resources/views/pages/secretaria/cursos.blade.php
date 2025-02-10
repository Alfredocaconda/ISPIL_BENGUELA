@extends('layouts.app')

@section('cursos')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title" style="display: flex; justify-content: space-between; width: 100%">
                    <h4 class="card-title">Disciplinas</h4>
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
                        <h5 class="modal-title">Cadastrar Disciplína</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                   <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                         <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label for="nome_disciplina">Nome da Disciplína</label>
                            <div class="form-input">
                                <input type="text" name="nome_disciplina" id="nome_disciplina" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="professor">Professor</label>
                            <div class="form-input">
                                <select class="form-control" name="professor" id="professor">
                                  
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
        document.getElementById('nome_disciplina').value = valor.nome_disciplina;
        document.getElementById('funcionario_id').value = valor.funcionario_id;
    }
    function limpar() {
        document.getElementById('id').value = "";
        document.getElementById('nome_disciplina').value = "";
        document.getElementById('funcionario_id').value = "";
    }
</script>
@endsection