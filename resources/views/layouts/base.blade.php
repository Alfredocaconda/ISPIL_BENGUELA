<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

         <!-- Footer Start -->
    @include('layouts.link') {{-- Aqui o rodapé será incluído --}}
    <!-- Footer End -->
   
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
            <a href="{{ url('/') }}"><img src="{{ asset('imagem/logotipo.jpeg') }}" alt="">
            </a>
        </div>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ url('/') }}" class="nav-item nav-link active">Inicio</a>
                <a href="{{ url('/cursos') }}" class="nav-item nav-link">Cursos</a>
                <a href="{{ url('/cursos') }}" class="nav-item nav-link">Vida Academica</a>
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

    <!-- Footer Start -->
    @include('layouts.script') {{-- Aqui o rodapé será incluído --}}
    <!-- Footer End -->
  
</body>

</html>