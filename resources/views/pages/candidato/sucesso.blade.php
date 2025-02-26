<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição Concluída</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
     <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        
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
    <div class="container mt-5">
        <div class="card shadow-lg p-4 rounded">
            <h2 class="text-success text-center">✅ Inscrição realizada com sucesso!</h2>
            <hr>
            <p><strong>Nome:</strong> {{ $candidato->user->name }}</p>
            <p><strong>Email:</strong> {{ $candidato->email }}</p>
           
            <form action="{{ route('inscricao.comprovativo') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $candidato->id }}">

                <div class="mb-3">
                    <label class="form-label">Como deseja receber o comprovativo?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metodo" value="email" required>
                        <label class="form-check-label">Por E-mail</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metodo" value="pdf" required>
                        <label class="form-check-label">Baixar PDF</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Confirmar</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
