<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDf</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        h2 {
            text-align: center;
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
    <h2>Usuario</h2>
    <p><b>Nome</b> {{ $usuario->nome }}</p>
    <p><b>Email</b> {{ $usuario->email }}</p>
    <p><b>Data de Criação</b> {{ $usuario->created_at->format('d/m/Y') }}</p>
</body>

</html>
