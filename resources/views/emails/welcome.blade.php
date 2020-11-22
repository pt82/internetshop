<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h4>
    Приветсвуем {{$data['name']}}! Мы рады, что Вы с нами! Ниже приведены данные Вашего аккаунта:
</h4>

<h5>Имя пользователя: </h5>
<p>{{$data['login']}}</p>
<h5>Пароль: </h5><p>{{$data['password']}}</p>
</body>
</html>
