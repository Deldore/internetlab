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
<form action="src/actions/userLogin.php" method="post">
    <div>
        <?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''?>
    </div>
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
    <button type="submit">Авторизация</button>
</form>
<?php $_SESSION['validation'] = [] ?>
</body>
</html>