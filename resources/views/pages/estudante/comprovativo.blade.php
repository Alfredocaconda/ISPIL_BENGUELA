<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovativo de Matrícula</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .container { width: 100%; text-align: center; }
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
        <p class="titulo">ISPIL-POLO BENGUELA</p>
        <p class="titulo">CRIADO PELO DECRETO PRESIDENCIAL Nº 173/17</p>
        <p class="titulo">COMPROVATIVO DE MATRÍCULA</p>
    </div>

    <!-- Dados do Inscrito -->
    <div class="dados">
        <p class="titulo">Código de Matrícula: {{$candidato->codigo_matricula}}</p>

        <table>
            <tr>
                <th>Nome Completo:</th>
                <td>{{ $candidato->user->name }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $candidato->email }}</td>
            </tr>
            <tr>
                <th>Gênero:</th>
                <td>{{ $candidato->genero }}</td>
            </tr>
            <tr>
                <th>Data de Nascimento:</th>
                <td>{{ date('d/m/Y', strtotime($candidato->data_nasc)) }}</td>
            </tr>
           <!-- <tr>
                <th>Naturalidade:</th>
                <td>{{ $candidato->naturalidade }}</td>
            </tr>
            <tr>
                <th>Província:</th>
                <td>{{ $candidato->provincia }}</td>
            </tr>
            <tr>
                <th>Município:</th>
                <td>{{ $candidato->municipio }}</td>
            </tr>-->
            <tr>
                <th>Telefone:</th>
                <td>{{ $candidato->telefone }}</td>
            </tr>
            <tr>
                <th>Curso Inscrito:</th>
               <td>{{ $candidato->curso->name }}</td> 
            </tr>
            <tr>
                <th>Data de Matrícula:</th>
                <td>{{ date('d/m/Y H:i', strtotime($candidato->data_matricula)) }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>{{ $candidato->estado}}</td>
            </tr>
        </table>
    </div>
    <!-- Assinatura -->
    <div class="assinatura">
        <p>_________________________</p>
        <p>Assinatura do Responsável</p>
    </div>
    <p>Data: {{now()}}</p>
</body>
</html>
