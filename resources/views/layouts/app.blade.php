<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>@yield('title')</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
        <link rel="stylesheet" href="{{asset('css/backend-plugin.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/backend.css')}}?v=1.0.0">
        <link rel="stylesheet" href="{{asset('css/master.css')}}">
        <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('vendor/remixicon/fonts/remixicon.css')}}"> 
        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">
  </head>
  <body class="  ">
    <!-- loader Start -->
   
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

      <!-- Menu da aplicação -->
      <div class="iq-sidebar  sidebar-default ">
          <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
              <a href="{{ url('Dashboard') }}" class="header-logo">
                  <img src="{{asset('imagem/logotipo.jpeg')}}" class="img-fluid rounded-normal light-logo" alt="logo"><h5 class="logo-title light-logo ml-3">ISPIL-BENGUELA</h5>
              </a>
              <div class="iq-menu-bt-sidebar ml-0">
                  <i class="las la-bars wrapper-menu"></i>
              </div>
          </div>
          <div class="data-scrollbar" data-scroll="1">
              <nav class="iq-sidebar-menu">
                  <ul id="iq-sidebar-toggle" class="iq-menu">
                    <li class="active">
                        <a href="{{ url('Dashboard') }}" class="svg-icon">
                            <svg  class="svg-icon" id="p-dash1" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span class="ml-4">Dashboards</span>
                        </a>
                    </li>
                   @if(Auth::user()->tipo == "Admin")
                      <li class=" ">
                          <a href="" class="svg-icon">
                            <i class="fa fa-user"></i>
                              <span class="ml-4">Utilizador</span>
                          </a>
                      </li>
                      <li class=" ">
                        <a href="{{route('funcio.index')}}" class="svg-icon">
                            <i class="fa fa-users"></i>
                              <span class="ml-4">Funcionario</span>
                          </a>
                      </li>
                      <li class=" ">
                        <a href="{{route('Curso.index')}}" class="svg-icon">
                            <i class="fa fa-list-alt"></i>
                              <span class="ml-4">Cursos</span>
                          </a>
                      </li>
                      @endif
                      <!-- INFORMACAO DA SECRETARIA QUE TERAO ACESSO-->
                      <li class=" ">
                        <a href="" class="svg-icon">
                            <i class="fa fa-users"></i>
                              <span class="ml-4">Estudantes</span>
                          </a>
                      </li>
                      <li class=" ">
                        <a href="" class="svg-icon">
                            <i class="fa fa-users"></i>
                              <span class="ml-4">Candidatos</span>
                          </a>
                      </li>
                      <li class=" ">
                        <a href="" class="svg-icon">
                            <i class="fa fa-list-alt"></i>
                              <span class="ml-4">Matrículas</span>
                          </a>
                      </li>
                      <li class=" ">
                        <a href="" class="svg-icon">
                            <i class="fa fa-list-alt"></i>
                              <span class="ml-4">Confir. Matrículas</span>
                          </a>
                      </li>
                  </ul>
              </nav>

              <div class="p-3"></div>
          </div>
          </div>      <div class="iq-top-navbar">
          <div class="iq-navbar-custom">
              <nav class="navbar navbar-expand-lg navbar-light p-0">
                  <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                      <i class="ri-menu-line wrapper-menu"></i>
                      <a href="{{ url('Dashboard') }}" class="header-logo">
                          <img src="{{asset('images/logo.png')}}" class="img-fluid rounded-normal" alt="logo">
                          <h5 class="logo-title ml-3">ISPIL-BENGUELA</h5>

                      </a>
                  </div>
                  <div class="iq-search-bar device-search">

                  </div>
                  <div class="d-flex align-items-center">
                      <button class="navbar-toggler" type="button" data-toggle="collapse"
                          data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                          aria-label="Toggle navigation">
                          <i class="ri-menu-3-line"></i>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <ul class="navbar-nav ml-auto navbar-list align-items-center">
                                @if(Auth::user()->tipo == "admin")
                                    <li class="nav-item nav-icon search-content">
                                        <a href="#" class="search-toggle rounded" id="dropdownSearch" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-search-line"></i>
                                        </a>
                                        @else
                                        <div class="iq-search-bar iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownSearch">
                                            <form action="#" class="searchbox p-2">
                                                <div class="form-group mb-0 position-relative">
                                                    <input type="text" class="text search-input font-size-12"
                                                        placeholder="type here to search...">
                                                    <a href="#" class="search-link"><i class="las la-search"></i></a>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                @endif
                              <li class="nav-item nav-icon dropdown caption-content">
                                  <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton4"
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <img src="{{asset('images/user/1.png')}}" class="img-fluid rounded" alt="user">
                                  </a>
                                  <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <div class="card shadow-none m-0">
                                          <div class="card-body p-0 text-center">
                                              <div class="media-body profile-detail text-center">
                                                  <img src="{{asset('images/page-img/profile-bg.jpg')}}" alt="profile-bg"
                                                      class="rounded-top img-fluid mb-4">
                                                  <img src="{{asset('images/user/1.png')}}" alt="profile-img"
                                                      class="rounded profile-img img-fluid avatar-70">
                                              </div>
                                              <div class="p-3">
                                                <h5 class="mb-1">{{Auth::user()->name}}</h5>
                                                @if(Auth::user()->tipo == "Admin")
                                                  <p class="mb-0">{{Auth::user()->tipo}}</p>
                                                @else
                                                <p class="mb-0">{{Auth::user()->funcionario->cargo}}</p>
                                                @endif
                                                  <div class="d-flex align-items-center justify-content-center mt-3">
                                                      <a href="{{route('perfil')}}" class="btn border mr-2">Perfil</a>
                                                      <a class="btn border" href="{{ route('logout') }}"
                                                      onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                                       {{ __('Sair') }}
                                                   </a>
                                                   <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                       @csrf
                                                   </form>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </div>
              </nav>
          </div>
      </div>
      <div class="modal fade" id="new-order" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-body">
                      <div class="popup text-left">
                          <h4 class="mb-3">New Order</h4>
                          <div class="content create-workform bg-body">
                              <div class="pb-3">
                                  <label class="mb-2">Email</label>
                                  <input type="text" class="form-control" placeholder="Enter Name or Email">
                              </div>
                              <div class="col-lg-12 mt-4">
                                  <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                      <div class="btn btn-primary mr-4" data-dismiss="modal">Cancel</div>
                                      <div class="btn btn-outline-primary" data-dismiss="modal">Create</div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="content-page">
        @yield('secretaria')
        @yield('perfil')
        @yield('cursos')
    </div>
    

    </div>
    <!-- Wrapper End-->
    <footer class="iq-footer">
            <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a href="backend/privacy-policy.html">Privacy Policy</a></li>
                                <li class="list-inline-item"><a href="backend/terms-of-service.html">Terms of Use</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-right">
                            <span class="mr-1"><script>document.write(new Date().getFullYear())</script>©</span> <a href="#" class="">ISPIL-BENGUELA</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
  <!-- Footer Start -->
  @include('layouts.script') {{-- Aqui o rodapé será incluído --}}
  <!-- Footer End -->
  </body>
</html>
