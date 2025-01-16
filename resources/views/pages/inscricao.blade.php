<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ISPM-Insc</title>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        .header{
            display: flex;
            position: relative;
            justify-content: center;
            background-color: orange;
            padding: 20px;
            color:black;
        }
        img{
            width: 50px;
            height: 50px;
        }
        ul{
            display: flex;
        }
        li{
            left:10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <ul>
            <li><img src="{{ asset('imagem/1.jpg') }}" alt=""></li>
            <li>Cursos</li>
            <li>Actividades</li>
            <li>Departamento</li>
            <li>Sobre</li>
        </ul>
        <P>SEJA BEM VINDO AO INSTITUTO SUPERIOR POLITECNICO MARAVILHA-BENGUELA</P>
        <small>Candidatura</small>
    </div>

    <div class="formulario">
        <form action="" method="post">
            <input type="text" placeholder="NOME COMPLETO">
            <input type="text">
        </form>
    </div>
</body>
</html>
