<?php

require_once __DIR__ . '/../helper.php';

$_SESSION['message'] = null;

$email = $_POST["email"] ?? null;
$password = $_POST["password"] ?? null;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['validation']['email'] = 'Указана неверная почта';
}
if(empty($email)) {
    $_SESSION['validation']['email'] = 'E-mail не должен быть пустым';
}

if (!empty($_SESSION['validation'])) {
    redirect('../../login.php');
}


$pdo = getPDO();

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(\PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['message'] = "Пользователь не найден";
}

if (!is_null($_SESSION['message'])) {
    redirect('../../login.php');
}
saveOldValue('email', $email);

if (!password_verify($password, $user['password'])) {
    $_SESSION['message'] = "Неверный пароль!";
    redirect('../../login.php');
}

$_SESSION['user']['id'] = $user['id'];

redirect('../../index.php');