<!DOCTYPE html>
<html lang="pt-br">

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
    <h2>Usuarios</h2>
    @forelse ($usuarios as $usuario)
        <p>{{$usuario->nome}}</p>
    @empty
        <p>Nenhum usuário encontrado.</p>
    @endforelse
</body>

</html>
