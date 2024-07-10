<?php
require_once __DIR__ . '\src\helper.php';
?>
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
    <?php if (empty($_SESSION['user'])) :?>
    <header>
        <a href="login.php">Авторизация</a>
        <a href="register.php">Регистрация</a>
    </header>
    <?php else: ?>
        <a href="src/actions/logout.php">Выйти из аккаунта</a>
    <?php endif?>
</body>
</html>
