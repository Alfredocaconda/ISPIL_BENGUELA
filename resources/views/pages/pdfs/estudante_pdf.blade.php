<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Histórico Acadêmico</title>
    <style>
         body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 40px;
            font-size: 14px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; font-size: 12px; text-align: center; }
        .header { text-align: center; margin-bottom: 30px; }
        .cabecalho {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
        .titulo {
            font-size: 18px;
            font-weight: bold;
        }
        .subtitulo {
            font-size: 14px;
        }
        .rodape {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="cabecalho">
        <img src="{{ public_path('imagem/logotipo.jpeg') }}" class="logo" alt="Logotipo">
        <div class="titulo">Instituto Superior Politecnico Intercontinental Luanda-Polo Benguela</div>
        <div class="subtitulo">CRIADO PELO DECRETO PRESIDENCIAL Nº 173/17</div>
        <div class="subtitulo">Direcção Académica - Departamento de Registo e Matrícula</div>
    </div>
    <div class="header">
        <h4>Histórico Acadêmico</h4>
    </div>

    <p><strong>Nome do Estudante:</strong> {{ $inscricao->user->name }}</p>
    <p><strong>Nº de Bilhete:</strong>
     {{ $matriculas->first()->n_bilhete ?? '-' }} </p>

    <table>
        <thead>
            <tr>
                <th>Código de Matrícula</th>
                <th>Ano Acadêmico</th>
                <th>Curso</th>
                <th>Turno</th>
                <th>Data da Matrícula</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matriculas as $matricula)
                <tr>
                    <td>{{ $matricula->codigo_matricula }}</td>
                    <td>{{ $matricula->ano_academico }}</td>
                    <td>{{ $matricula->curso->name }}</td>
                    <td>{{ $matricula->turno }}</td>
                    <td>{{ \Carbon\Carbon::parse($matricula->data_matricula)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($matricula->estado) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <h4>Documentos Entregues</h4>
        <ul>
            <li>Certificado: {{ $matricula->certificado }}</li>
            <li>Bilhete: {{ $matricula->bilhete }}</li>
        </ul>
    </div>

    <div class="rodape">
    Instituto Superior Politecnico Intercontinental Luanda-Polo Benguela | Rua 123, Luanda | Tel: +244 900 000 000
    </div>
</body>
</html>
