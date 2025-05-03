@extends('layouts.app')
@section('title', 'ISPIL-BENGUELA')
@section('cursos')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title" style="display: flex; justify-content: space-between; width: 100%">
                    <h4 class="card-title">Curso de Graduação do ISPIL</h4>
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
                            <th>Quantidade de Vagas</th>
                            <th>Preço</th>
                            <th>Imagem</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($valor as $Curso)
                            <tr>
                                <td>{{$Curso->name}}</td>
                                <td>{{$Curso->vagas}}</td>
                                <td>{{$Curso->preco}}</td>
                               <!-- <td>
                                    <img src="{{ asset('storage/DocCurso/' . $Curso->foto) }}" alt="Foto do Curso" width="100" height="100">
                                </td>--> 
                                <td>
                                    <a href="#Cadastrar" data-toggle="modal" class="text-primary" onclick="editar({{ json_encode($Curso)}})"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('Curso.apagar',$Curso->id)}}" class="text-danger"><i class="fa fa-trash"></i></a>
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
                <h5 class="modal-title">Cadastrar Cursos</h5>
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

                    <form action="{{ route('Curso.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <x-input-normal id="name" name="name" type="text" titulo="Nome" alert="" />
                            <x-input-normal id="vagas" name="vagas" type="number" titulo="Quantidade de Vaga" alert="" />
                            <x-input-normal id="preco" name="preco" type="number" titulo="Preço" alert="" />

                           <!-- <div class="col-md-4">
                                <label for="foto">Imagem( jpg, png, jpeg ) <span style="color: red;">*</span></label>
                                <div class="form-input">
                                    <input type="file" accept="image/*" name="foto" id="foto" class="form-control" />
                                </div>
                            </div>
-->
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
    const nomeHelp = document.getElementById('nomeHelp');
    const maxLength = 9;

    nomeInput.addEventListener('input', () => {
        const currentLength = nomeInput.value.length;
        nomeHelp.textContent = `Máximo de ${maxLength} caracteres. (${currentLength}/${maxLength})`;
    });

    function editar(valor) {
    if (!valor) {
        console.error("Erro: Dados do Curso não encontrados.");
        return;
    }

    document.getElementById('id').value = valor.id || '';
    document.getElementById('name').value = valor.name || '';

    // Modificar a URL do formulário para apontar para update se for edição
    let form = document.getElementById('formFuncionario');
    if (valor.id) {
        form.action = `/Curso/${valor.id}`;  // Ajuste conforme sua rota de atualização
        form.method = "POST"; // Laravel aceita PUT/PATCH com _method
        form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
    } else {
        form.action = "{{ route('Curso.store') }}"; // Criar novo
    }
}

    function limpar() {
        document.getElementById('id').value = "";
        document.getElementById('name').value = "";
    }
</script>
@endsection
