@extends('layouts.base')
{{-----------------------------------------------------------------------------}}
@section('cadastro')
   <div class="wrapper">
      <section class="login-content">
         <div class="container h-100">
         <div class="row align-items-center justify-content-center h-100">
            <div class="col-12">
               <div class="row align-items-center">
                  <div class="col-lg-6">
                     <h2 class="mb-2">Cadastrar-se</h2>
                     <form method="POST" action="{{ route('user.register') }}">
                        @csrf
                        <div class="row">
                           <div class="col-lg-6">
                              <div class="form-group">
                                 <label class="mb-0">Nome Completo</label>
                                 <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                 @error('name')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="form-group">
                                 <label for="email">E-mail</label>
                                 <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                 @error('email')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="form-group">
                                 <label class="mb-0">Senha</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="form-group">
                                 <label class="mb-0">Confirmar Senha</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="custom-control custom-checkbox mb-3">
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
                        <p class="mt-3">
                           já tenho uma conta <a href="{{ url('login') }}" class="text-primary">Entrar</a>
                        </p>
                     </form>
                  </div>
                  <div class="col-lg-6 mb-lg-0 mb-4 mt-lg-0 mt-4">
                     <img src="imagem/banner/banner.jpeg" class="img-fluid w-80" alt="">
                  </div>
               </div>
            </div>
         </div>
          </div>
      </section>
   </div>
@endsection
{{-----------------------------------------------------------------------------------}}
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