@extends('layouts.base')

@section('content')

 <!-- Carousel Start -->
 @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
 <div class="container-fluid p-0 mb-5">
    <div class="owl-carousel header-carousel position-relative">
       
        <div class="owl-carousel-item position-relative" style="height: 500px">
            <img class="img-fluid"  src="{{ asset('imagem/banner/banner.jpeg') }}" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-8">
                            <h1 class="display-3 text-white animated slideInDown">ISPIL-POLO BENGUELA</h1>
                            <p class="fs-5 text-white mb-4 pb-2">CHEGOU A HORA DE FAZER PARTE DA FAMÍLIA ISPIL-POLO BENGUELA. INSCRIÇÕES E MATRICULAS ABERTAS PARA
                                EXAMES DE ACESSO E CURSO PREPARATÓRIO.</p>
                                <p class="fs-5 text-white mb-4 pb-2">24 DE JULHO DE 2025</p>
                            <a href="{{url('/inscricao')}}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">INSCRIÇÃO</a>
                            <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">MATRICULA</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->


<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                        <h5 class="mb-3">Impacto na Investigação</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-home text-primary mb-4"></i>
                        <h5 class="mb-3">Infraestrutura Moderna</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                        <h5 class="mb-3">Biblioteca</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->


<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100" src="img/about.jpg" alt="" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                <h1 class="mb-4">Mensagem</h1>
                <p class="mb-4">Não estaremos, certamente, equivocados ao 
                    afirmar que a sociedade angolana espera muito desta Universidade, sobretudo da sua responsabilidade social que inclui o impulso no
                     desenvolvimento humano, sustentável e inclusivo, por via de uma formação multidisciplinar
                      e integral que estimula atitudes éticas, humanas e cristãs que impregnem
                       o ser e o agir das novas gerações comprometidas com o bem, o belo, 
                       o certo e o justo que não fragmenta nem vilipendia, mas une, engrandece e dignifica qualquer um (…).</p>
                <div class="row gy-2 gx-4 mb-4">
                   <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Antonio Njinja</p>
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>phd em pedagogia</p>
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Presidente do ISPIL-POLO BENGUELA</p>
                    </div>
                </div>
                <a class="btn btn-primary py-3 px-5 mt-2" href="">Ler mais</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

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
                        <!--<img class="img-fluid curso-img" position-absolute src="{{ asset('storage/DocCurso/' . $curso->foto) }}" alt="{{ $curso->name }}">-->
                        <div class="w-100 d-flex justify-content-center  bottom-0 start-0 mb-4">
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


    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h1 class="mb-5">Estudantes Finalistas</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="img/testimonial-1.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="img/testimonial-2.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="img/testimonial-3.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="img/testimonial-4.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p>
                    <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

@endsection
