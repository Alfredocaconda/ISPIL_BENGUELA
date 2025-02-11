@extends('layouts.app')

@section('perfil')
<div class="media-body">
    <h2 class="mb-2">Meu Perfil</h2>
    <h4 class="mb-2">Nome Completo : {{Auth::user()->name}}</h4>
    <h4 class="mb-2">E-mail : {{Auth::user()->email}}</h4>
    <h4 class="mb-2">Tipo : {{Auth::user()->tipo}}</h4>
</div>
@endsection
