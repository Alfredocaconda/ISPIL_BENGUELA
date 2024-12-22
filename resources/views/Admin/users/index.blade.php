<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuário</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>NOME</th>
                <th>EMAIL</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @forelse ( $user as $usuario )
            <tr>
                <td>{{$usuario->name}}</td>
                <td>{{$usuario->email}}</td>
                <td>--></td>
            </tr>
            @empty
            <tr>
                <td colspan="100">Nenhum usuario no Banco</td>
            </tr>

            @endforelse
        </tbody>
    </table>
    {{$user->links()}}
</body>
</html>
