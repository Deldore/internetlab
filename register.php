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
    <form action="src/actions/createNewUser.php" method="post">
        <label>
            Имя пользователя: <br/>
            <input type="text"
                   name="name"
                   placeholder="Введите имя пользователя"
                   value="<?php echo getOldValue('name')?>">
            <br>
            <?php hasValidationError('name');?>
        </label>
        <br>
        <label>
            E-Mail <br/>
            <input type="text"
                   name="email"
                   placeholder="Введите свою почту"
                   value="<?php echo getOldValue('email')?>">
            <br>
            <?php hasValidationError('email'); ?>
        </label>
        <br>
        <label>
            Придумайте пароль: <br>
            <input type="password"
                   name="password"
                   placeholder="Введите пароль">
            <br>
            <?php hasValidationError('password'); ?>
        </label>
        <br>
        <button type="submit">Регистрация</button>
    </form>
    <?php $_SESSION['validation'] = [] ?>
</body>
</html>