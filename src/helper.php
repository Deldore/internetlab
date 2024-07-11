<?php

session_start();

require_once __DIR__ . '/config.php';
function redirect($path){
    header( "Location: $path");
    die();
}
function hasValidationError($field){
    echo (!empty($_SESSION['validation'][$field])) ? $_SESSION['validation'][$field] : '';
}

function saveOldValue(string $key, mixed $value) {
    $_SESSION['old'][$key] = $value;
}

function getOldValue(string $key) {
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

function clearOldValues() : void {
    $_SESSION['old'] = [];
}

function getPDO() : PDO
{
    try {
        return new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8;dbname=' . DB_NAME, DB_USER, DB_PASS);
    } catch (\PDOException $e) {
        die ($e->getMessage());
    }
}

function getAllUsers() : void
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM `users`");
    $stmt->execute();
    $users = $stmt->fetchAll();
    echo json_encode($users);
}

function getUser(int $id) : void
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();
    if ($user) echo json_encode($user);
    else {
        http_response_code(404);
        $message = [
            'status' => false,
            'message' => "User not found"
        ];
        echo json_encode($message);
    }
}

function createNewUser()
{
    $name = $_POST["name"] ?? null;
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;
    $message = [];
    if (empty($name)) {
        $message['name'] = 'Поле "Имя" не должно быть пустым';
    }
    if (empty($email)) {
        $message['email'] = 'Поле "Email" не должно быть пустым';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['email'] = 'Неправильный формат Email';
    }
    if (empty($password)) {
        $message['password'] = 'Поле "Пароль" не должно быть пустым';
    }
    if (!empty($message)) {
        http_response_code(400);
        $res = [
            'status' => false,
            'message' => $message
        ];
        echo json_encode($res);
        die();
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
        http_response_code(201);
        $res = [
            'status' => true,
            'userId' => $pdo->lastInsertId()
        ];
        echo json_encode($res);
    } catch (\Exception $e) {
        http_response_code(500);
        $res = [
            'status' => false,
            'message' => $e->getMessage()
        ];
        echo json_encode($res);
    }
}

function updateUser($id, $data) : void
{
    $name = $data["name"] ?? null;
    $email = $data["email"] ?? null;
    $password = $data["password"] ?? null;
    $message = [];
    if (empty($name)) {
        $message['name'] = 'Поле "Имя" не должно быть пустым';
    }
    if (empty($email)) {
        $message['email'] = 'Поле "Email" не должно быть пустым';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message['email'] = 'Неправильный формат Email';
    }
    if (empty($password)) {
        $message['password'] = 'Поле "Пароль" не должно быть пустым';
    }
    if (!empty($message)) {
        http_response_code(400);
        $res = [
            'status' => false,
            'message' => $message
        ];
        echo json_encode($res);
        die();
    }

    $pdo = getPDO();

    $query = 'UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id';
    $params = [
        ':name' => $name,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT),
        ':id' => $id
    ];
    $stmt = $pdo->prepare($query);
    try {
        $result = $stmt->execute($params);
        http_response_code(201);
        $res = [
            'status' => true,
            'userId' => $pdo->lastInsertId()
        ];
        echo json_encode($res);
    } catch (\Exception $e) {
        http_response_code(500);
        $res = [
            'status' => false,
            'message' => $e->getMessage()
        ];
        echo json_encode($res);
    }
}