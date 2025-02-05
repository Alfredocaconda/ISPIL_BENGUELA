@extends('layouts.app2')

@section('cursos')

<!-- Courses Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-5">Cursos de Graduação</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/informatica.png" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="{{route('inscricao.index')}}" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Engenharia Informática</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/biologia.webp" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Ensino de Biologia</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/direito.png" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Direito</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/educacao fisica.png" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="{{route('inscricao.index')}}" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Educação Física</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/gestao-de-recursos-humanos.webp" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Gestão de Recursos Humanos</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/pedagogia.webp" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Ensino de Pedagogia</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/psicologia.webp" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Ensino de Psicologia</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/relacoes internacionais.jpg" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Relações Internacionais</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/sociologia.webp" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Ensino de Sociologia</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/informatica.png" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Engenharia Informática</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/informatica.png" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Engenharia Informática</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/Cursos/informatica.png" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Saiba Mais</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Candidatar-se</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">35.000KZ</h3>
                            <h5 class="mb-4">Engenharia Informática</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>Vaga 30</small>
                        </div>
                    </div>
                </div>
               
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


{{---------------------------        rodape            --------------------------------------------------------}}
@section('rodape')
<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
   <div class="container py-5">
       <div class="row g-5">
           <div class="col-lg-3 col-md-6">
               <h4 class="text-white mb-3">Quick Link</h4>
               <a class="btn btn-link" href="">About Us</a>
               <a class="btn btn-link" href="">Contact Us</a>
               <a class="btn btn-link" href="">Privacy Policy</a>
               <a class="btn btn-link" href="">Terms & Condition</a>
               <a class="btn btn-link" href="">FAQs & Help</a>
           </div>
           <div class="col-lg-3 col-md-6">
               <h4 class="text-white mb-3">Contact</h4>
               <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
               <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
               <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
               <div class="d-flex pt-2">
                   <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                   <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                   <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                   <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
               </div>
           </div>
           <div class="col-lg-3 col-md-6">
               <h4 class="text-white mb-3">Gallery</h4>
               <div class="row g-2 pt-2">
                   <div class="col-4">
                       <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                   </div>
                   <div class="col-4">
                       <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                   </div>
                   <div class="col-4">
                       <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                   </div>
                   <div class="col-4">
                       <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                   </div>
                   <div class="col-4">
                       <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                   </div>
                   <div class="col-4">
                       <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                   </div>
               </div>
           </div>
           <div class="col-lg-3 col-md-6">
               <h4 class="text-white mb-3">Newsletter</h4>
               <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
               <div class="position-relative mx-auto" style="max-width: 400px;">
                   <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                   <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
               </div>
           </div>
       </div>
   </div>
   <div class="container">
       <div class="copyright">
           <div class="row">
               <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                   &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                   <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                   Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
               </div>
               <div class="col-md-6 text-center text-md-end">
                   <div class="footer-menu">
                       <a href="">Home</a>
                       <a href="">Cookies</a>
                       <a href="">Help</a>
                       <a href="">FQAs</a>
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>  
@endsection
