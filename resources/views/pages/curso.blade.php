@extends('layouts.base')
@section('content')
<!-- Courses Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-5">Cursos de Graduação</h1>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($cursos as $curso)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="course-item bg-light">
                    <div class="position-relative overflow-hidden">
                       <!-- <img class="img-fluid curso-img" position-absolute bottom-0 start-0 mb-4 src="{{ asset('storage/DocCurso/' . $curso->foto) }}" alt="{{ $curso->name }}">-->
                        <div class="w-100 d-flex justify-content-center ">
                            <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                            <a href="{{ auth()->check() ? route('inscricao.index', ['curso_id' => $curso->id]) : route('login') }}" 
                                class="flex-shrink-0 btn btn-sm btn-primary px-3" 
                                style="border-radius: 0 30px 30px 0;">
                                 Candidatar-se
                             </a>
                             
                        </div>
                    </div>
                    <div class="text-center p-4 pb-0">
                        <h3 class="mb-0">{{ number_format($curso->preco, 2, ',', '.') }}KZ</h3>
                        <h5 class="mb-4">{{ $curso->name }}</h5>
                    </div>
                    <div class="d-flex border-top">
                        <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga {{ $curso->vagas }}</small>
                    </div>
                </div>
            </div>
            @endforeach
            
           
        </div>
    </div>
</div>
<!-- Courses End -->
@endsection