<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovativo de Inscrição</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .container { width: 100%; text-align: center; }
        .logo { width: 100px; height: auto; }
        .titulo { font-size: 18px; font-weight: bold; margin-top: 10px; }
        .dados { margin-top: 20px; text-align: left; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .assinatura { margin-top: 40px; text-align: center; }
    </style>
</head>
<body>

    <div class="container">
        <!-- Logotipo -->
        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logotipo da Escola">
        <p class="titulo">Comprovativo de Inscrição</p>
    </div>

    <!-- Dados do Inscrito -->
    <div class="dados">
        <table>
            <tr>
                <th>Nome Completo:</th>
                <td>{{ $valor->name }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $valor->email }}</td>
            </tr>
            <tr>
                <th>Gênero:</th>
                <td>{{ $valor->genero }}</td>
            </tr>
            <tr>
                <th>Data de Nascimento:</th>
                <td>{{ date('d/m/Y', strtotime($valor->data_nasc)) }}</td>
            </tr>
            <tr>
                <th>Naturalidade:</th>
                <td>{{ $valor->naturalidade }}</td>
            </tr>
            <tr>
                <th>Província:</th>
                <td>{{ $valor->provincia }}</td>
            </tr>
            <tr>
                <th>Município:</th>
                <td>{{ $valor->municipio }}</td>
            </tr>
            <tr>
                <th>Telefone:</th>
                <td>{{ $valor->telefone }}</td>
            </tr>
            <tr>
                <th>Curso Inscrito:</th>
                <td>{{ $valor->curso->nome }}</td>
            </tr>
            <tr>
                <th>Data de Inscrição:</th>
                <td>{{ date('d/m/Y H:i', strtotime($valor->data_inscricao)) }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>{{ $valor->status ?? 'Pendente' }}</td>
            </tr>
        </table>
    </div>

    <!-- Assinatura -->
    <div class="assinatura">
        <p>_________________________</p>
        <p>Assinatura do Responsável</p>
    </div>

</body>
</html>
