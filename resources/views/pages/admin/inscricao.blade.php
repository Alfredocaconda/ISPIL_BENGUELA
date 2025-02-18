@extends('layouts.app')
@section('title', 'ISPIL-BENGUELA')
@section('secretaria')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title" style="display: flex; justify-content: space-between; width: 100%">
                        <h4 class="card-title">Candidato</h4>
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
                            
                                <th>Nome Completo</th>
                                <th>Genero</th>
                                <th>Província/Município</th>
                                <th>Nº BI</th>
                                <th>Nome do Pai e Mãe</th>
                                <th>Nº Tel</th>
                                <th>Curso</th>
                                <th>Data de Inscrição</th>
                                <th>Estado</th>
                                <th>Foto</th>
                                <th>Certificado</th>
                                <th>Bilhete</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($valor as $dados)
                                <tr>
                                    
                                    <td>{{$dados->name}}</td>
                                    <td>{{$dados->genero}}</td>
                                    <td>{{$dados->provincia ."/".$dados->municipio}}</td>
                                    <td>{{$dados->n_bilhete}}</td>
                                    <td>{{$dados->afiliacao}}</td>
                                    <td>{{$dados->telefone}}</td>
                                    <td>{{$dados->curso->name}}</td>
                                    <td>{{$dados->data_inscricao}}</td>
                                    <td>
                                        @if($dados->status == 'pendente')
                                            <span class="badge bg-warning">Pendente</span>
                                        @elseif($dados->status == 'admitido')
                                            <span class="badge bg-success">Admitido</span>
                                        @else
                                            <span class="badge bg-danger">Não Admitido</span>
                                        @endif
                                    </td>
                                    <td><img src="" alt="Aqui vai imagem"></td>
                                    <td><a href="" class="text-danger" title="Clica para descarregar o fichero">  <i style="font-size:50px" class="fa fa-file-pdf"></i> </a></td>
                                    <td><a href="" class="text-danger" title="Clica para descarregar o fichero">  <i style="font-size:50px" class="fa fa-file-pdf"></i> </a></td>
                                    <td>
                                        <form action="{{ route('alterarStatus', $dados->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary">
                                                Alterar Status
                                            </button>
                                        </form>
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
                            <h5 class="modal-title">Cadastrar Estudante</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="id" id="id">
                            {{-- <input type="hidden" name="funcionario_id" value="{{ Auth::user()->id }}"> --}}
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="name">Nome Completo</label>
                                <div class="form-input">
                                    <input type="text" name="name" id="name" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="genero">Genero</label>
                                <div class="form-input">
                                    <select name="genero" id="genero" class="form-control">
                                        <option value="">Selecionar o Genero</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="provincia">Província</label>
                                    <div class="form-input">
                                        <input type="text" name="provincia" id="provincia" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="n_bilhete">Nº do Bilhete</label>
                                    <div class="form-input">
                                        <input type="text" name="n_bilhete" id="n_bilhete" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="naturalidade">Naturalidade</label>
                                    <div class="form-input">
                                        <input type="text" name="naturalidade" id="naturalidade" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="afiliacao">Nome do Pai e da Mãe</label>
                                    <div class="form-input">
                                        <input type="text" name="afiliacao" id="afiliacao" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="telefone">Nº do Tlfn do Encarregado</label>
                                    <div class="form-input">
                                        <input type="number" name="telefone" id="telefone" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="foto">Foto</label>
                                    <div class="form-input">
                                        <input type="file" accept="image/*" name="foto" id="foto" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="certificado">Certificado</label>
                                    <div class="form-input">
                                        <input type="file" accept=".txt,.pdf,.docx" name="certificado" id="certificado" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-6">
                                    <label for="bilhete">Bilhete</label>
                                    <div class="form-input">
                                        <input type="file" accept=".txt,.pdf,.docx" name="bilhete" id="bilhete" class="form-control" />
                                    </div>
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

        function comprar(valor) {
            document.getElementById('id').value = valor;
        }
        function editar(valor) {
            document.getElementById('id').value = valor.id;
            document.getElementById('name').value = valor.name;
            document.getElementById('genero').value = valor.genero;
            document.getElementById('n_bilhete').value = valor.n_bilhete;
            document.getElementById('telefone').value = valor.telefone;
            document.getElementById('certificado').value = valor.certificado;
            document.getElementById('bilhete').value = valor.bilhete;
            document.getElementById('afiliacao').value = valor.afiliacao;
            document.getElementById('provincia').value = valor.provincia;
            document.getElementById('foto').value = valor.foto;
            document.getElementById('naturalidade').value = valor.naturalidade;
        }
        function limpar() {
            document.getElementById('id').value = "";
            document.getElementById('name').value = "";
            document.getElementById('genero').value = "";
            document.getElementById('n_bilhete').value = "";
            document.getElementById('telefone').value = ""
            document.getElementById('certificado').value = "";
            document.getElementById('bilhete').value = "";
            document.getElementById('provincia').value = "";
            document.getElementById('foto').value = "";
            document.getElementById('afiliacao').value = "";
            document.getElementById('naturalidade').value = "";
        }
            
    </script>
@endsection
