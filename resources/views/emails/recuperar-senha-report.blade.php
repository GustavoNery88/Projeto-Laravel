<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email - HTML</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <p>Olá, <b>{{$nome}}.</b></p>
    <p>Sua senha foi redefinda com sucesso!</p>
    <p>Segue a nova senha de redefinição:</p>
    <p><b>{{$senhaGerada}}</b></p>  
    <p>Para ativar seu acesso, acesse o link abaixo:</p>
    <p><a href="{{ route('usuarios.ativarUsuarioForm') }}">Link de Confirmação de Acesso</a></p>
</body>

</html>
