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
        <h2>Ficha de Inscrição</h2>

        <div class="info"><strong>Nome do Estudante:</strong> {{ $candidato->user->name }}</div>
        <div class="info"><strong>Email:</strong> {{ $candidato->email }}</div>
        <div class="info"><strong>Gênero:</strong> {{ $candidato->genero }}</div>
        <div class="info"><strong>Telefone:</strong> {{ $candidato->telefone }}</div>
        <div class="info"><strong>Curso:</strong> {{ $candidato->curso->name }}</div>
        <div class="info"><strong>Turno:</strong> {{ $candidato->periodo }}</div>
        <div class="info"><strong>Nº do Bilhete:</strong> {{ $candidato->n_bilhete }}</div>
        <div class="info"><strong>Código de Inscrição:</strong> {{ $candidato->codigo_inscricao }}</div>
        <div class="info"><strong>Data de Inscrição:</strong> {{ \Carbon\Carbon::parse($candidato->data_inscricao)->format('d/m/Y') }}
        <div class="info"><strong>Estado:</strong> {{ $candidato->estado }}
        </div>

        <h4>Documentos Entregues</h4>
        <ul>
            <li>Certificado: {{ $candidato->certificado }}</li>
            <li>Bilhete: {{ $candidato->bilhete }}</li>
        </ul>
    </div>

    <div class="rodape">
    Instituto Superior Politecnico Intercontinental Luanda-Polo Benguela | Rua 123, Luanda | Tel: +244 900 000 000
    </div>
</body>
</html>
