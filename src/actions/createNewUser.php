<?php

require_once __DIR__ . '/../helper.php';

$name = $_POST["name"] ?? null;
$email = $_POST["email"] ?? null;
$password = $_POST["password"] ?? null;

// Validation

$_SESSION['validation'] = [];

saveOldValue('name', $name);
saveOldValue('email', $email);

if(empty($name)) {
    $_SESSION['validation']['name'] = 'Имя не должно быть пустым';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['validation']['email'] = 'Указана неверная почта';
}
if(empty($email)) {
    $_SESSION['validation']['email'] = 'E-mail не должен быть пустым';
}
if(empty($password)) {
    $_SESSION['validation']['password'] = 'Пароль не должен быть пустым';
}

if (!empty($_SESSION['validation'])) {
    redirect('../../register.php');
}

$pdo = getPDO();

$query = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
$params = [
    ':name' => $name,
    ':email' => $email,
    ':password' => password_hash($password, PASSWORD_DEFAULT)
];
$stmt = $pdo->prepare($query);
try {
    $result = $stmt->execute($params);
} catch (\Exception $e) {
    die($e->getMessage());
}

redirect('../../auth');
