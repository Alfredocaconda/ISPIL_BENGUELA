@extends('layouts.app')
@section('secretaria')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-info-light">
                                    <img src="{{asset('images/product/1.png')}}" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Total de Funcionário</p>
                                    <h4>{{App\Models\Funcionario::count()}}</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-info iq-progress progress-1" data-percent="85">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-danger-light">
                                    <img src="{{asset('images/product/2.png')}}" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Total de Candidatos</p>
                                    <h4>{{App\Models\Candidato::count()}}</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-danger iq-progress progress-1" data-percent="70">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-danger-light">
                                    <img src="{{asset('images/product/2.png')}}" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Total de Estudantes Matrículados</p>
                                    <h4>{{App\Models\Matricula::count()}}</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-danger iq-progress progress-1" data-percent="70">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-success-light">
                                    <img src="{{asset('images/product/3.png')}}" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Total de Cursos</p>
                                    <h4>{{App\Models\Curso::count()}}</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-success iq-progress progress-1" data-percent="75">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>
@endsection
