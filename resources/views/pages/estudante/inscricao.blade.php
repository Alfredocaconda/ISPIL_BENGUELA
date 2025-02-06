@extends('layouts.app2')

@section('inscricao')
   <div class="container mt-4">
   <h2 class="mb-2">Candidato</h2>
        <form action="{{route('inscricao.cadastro')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="name" value="{{ Auth::user()->name }}" >
            <input type="hidden" name="email" value="{{ Auth::user()->email }}" >
            <div class="row g-3">
                <!-- Criando 10 inputs em uma grade responsiva -->
                <div class="col-md-4">
                    <label for="name">Nome Completo <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" readonly/>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="genero">Genero <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <select name="genero" id="genero" class="form-control">
                            <option value="">Selecionar o Genero</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="provincia">Província <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="provincia" id="provincia"
                         class="form-control"  oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="municipio">Município <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="municipio" id="municipio"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="naturalidade">Naturalidade <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="naturalidade" id="naturalidade"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="data_nasc">Data de Nascimento <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="date" name="data_nasc" id="data_nasc" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="n_bilhete">Nº do Bilhete <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="n_bilhete" id="n_bilhete" class="form-control" />
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label for="afiliacao">Nome do Pai e Mãe <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="afiliacao" id="afiliacao"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="telefone">Nº do Telefone <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="number" name="telefone" id="telefone"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="nome_escola">Nome da Escola <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="nome_escola" id="nome_escola"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="curso_medio">Curso do Médio <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="curso_medio" id="curso_medio"
                         class="form-control" oninput="validarInput(this)" style=" padding: 5px;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="date_inicio">Data de Inicio <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="date" name="date_inicio" id="date_inicio" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="date_termino">Data de Termino <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="date" name="date_termino" id="date_termino" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="email">E-mail <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="text" name="email" id="email" class="form-control"
                         value="{{ Auth::user()->email }}" readonly/>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="curso">Cursos <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <select name="curso" id="curso" class="form-control">
                            <option value="">Selecionar o Curso</option>
                            <option value="informatica">Eng. Informática</option>
                            <option value="biologia">Ensino de Biologia</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="foto">Foto de Tipo Passe ( jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept="image/*" name="foto" id="foto" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="certificado">Certificado ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="certificado" id="certificado" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="bilhete">Bilhete ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="bilhete" id="bilhete" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="atestado">Atestado Médico ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="atestado" id="atestado" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="recenciamento">Recenciamento Militar ( pdf, jpg, png, jpeg ) <span style="color: red;">*</span></label>
                    <div class="form-input">
                        <input type="file" accept=".txt,.pdf,.docx" name="recenciamento" id="recenciamento" 
                        class="form-control" />
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Enviar Inscrição</button>
            </div>
        </form>
    </div>
    <script>
        function validarInput(campo) {
            if (campo.value.length < 5) {
                campo.style.borderColor = "red";
            } else if (campo.value.length > 6) {
                campo.style.borderColor = "green";
            } else {
                campo.style.borderColor = "gray"; // Volta ao padrão se estiver entre 5 e 6 caracteres
            }
        }
        </script>
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