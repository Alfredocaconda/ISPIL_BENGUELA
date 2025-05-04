<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Matrícula</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 40px;
            font-size: 14px;
        }
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
        .conteudo {
            margin-top: 30px;
        }
        .info {
            margin-bottom: 15px;
        }
        .rodape {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
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

    <div class="conteudo">
        <h2>Ficha de Matrícula</h2>

        <div class="info"><strong>Nome do Estudante:</strong> {{ $inscricao->user->name }}</div>
        <div class="info"><strong>Email:</strong> {{ $matricula->email }}</div>
        <div class="info"><strong>Gênero:</strong> {{ $matricula->genero }}</div>
        <div class="info"><strong>Telefone:</strong> {{ $matricula->telefone }}</div>
        <div class="info"><strong>Curso:</strong> {{ $matricula->curso->name }}</div>
        <div class="info"><strong>Turno:</strong> {{ $matricula->turno }}</div>
        <div class="info"><strong>Nº do Bilhete:</strong> {{ $matricula->n_bilhete }}</div>
        <div class="info"><strong>Código de Matrícula:</strong> {{ $matricula->codigo_matricula }}</div>
        <div class="info"><strong>Data de Matrícula:</strong> {{ \Carbon\Carbon::parse($matricula->data_matricula)->format('d/m/Y') }}
        <div class="info"><strong>Estado:</strong> {{ $matricula->estado }}
        </div>

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
