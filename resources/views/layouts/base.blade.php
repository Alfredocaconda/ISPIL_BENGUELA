<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Css/estilo.css') }}">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .curso-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <div class="esquerdo">
            <a href="{{ url('/home') }}"><img src="{{ asset('imagem/logotipo.jpeg') }}" alt="">
            </a>
        </div>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ url('/') }}" class="nav-item nav-link active">Home</a>
                <a href="{{ url('cursos') }}" class="nav-item nav-link">Cursos</a>
                <a href="courses.html" class="nav-item nav-link">Vida Academica</a>
                @auth
                    @if(Auth::user()->role === 'estudante')
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Matricular-se</a>
                            <div class="dropdown-menu fade-down m-0">
                                <a href="{{ url('matricula') }}" class="dropdown-item">Matrícula</a>
                                <a href="{{ url('reconfirmacao') }}" class="dropdown-item">Reconfirmação de Matrícula</a>
                            </div>
                        </div>
                    @endif
                @endauth
                  <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                           
                        <a href="{{ route('login') }}" class="btn py-4 px-lg-5 d-none d-lg-block">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                            Cadastrar-se<i class="fa fa-arrow-right ms-3"></i>
                        </a>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    @yield('matricula')
    <!-- Carousel Start -->
    @yield('inscricao')
    <!-- Carousel End -->
    @yield('reconfirmacao')

    <!-- Service Start -->
    @yield('cursos')
    <!-- Service End -->
    @yield('curso')

    <!-- About Start -->
  @yield('content')
    <!-- About End -->

    <!-- Courses Start -->
   @yield('login')
    <!-- Courses End -->

    <!-- Testimonial Start -->
    @yield('cadastro')
    <!-- Testimonial End -->
        

    <!-- Footer Start -->
    @include('layouts.footer') {{-- Aqui o rodapé será incluído --}}
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>