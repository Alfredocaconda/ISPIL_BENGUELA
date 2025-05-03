@extends('layouts.base')
@section('login')
<div class="wrapper">
    <section class="login-content">
       <div class="container h-100">
          <div class="row align-items-center justify-content-center h-100">
             <div class="col-12">
                <div class="row align-items-center">
                   <div class="col-lg-6">
                      <h2 class="mb-2">LOGIN</h2>
                      <p></p>
                      <form action="{{route('user.auth')}}" method="POST">
                         @csrf
                         <div class="row">
                            <div class="col-lg-12">
                               <div class="form-group">
                                  <label class="mb-0">E-mail</label>
                                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               </div>
                            </div>
                            <div class="col-lg-12">
                               <div class="form-group">
                                  <label class="mb-0">Senha</label>
                                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                  @error('password')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                               </div>
                            </div>
                            <div class="col-lg-12">
                               <div class="form-group">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                               </div>
                            </div>
                         </div>
                         <button type="submit" class="btn btn-primary btn-lg mb-2" >Entrar</button>
                         <p>Ainda não possui conta ?<a href="{{ route('register') }}"> Registar</a></p>
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

