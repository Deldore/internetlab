<?php

require_once __DIR__ . '\src\helper.php';

$q = $_GET['q'] ?? null;
$params = explode('/', $q) ?? null;
$type = $params[0] ?? null;
$id = $params[1] ?? null;
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

switch ($type) {
    case 'users':
        switch ($id) {
            case null:
                switch ($method) {
                    case 'GET':
                        getAllUsers();
                        break;
                    case 'POST':
                        createNewUser();
                        break;
                }
               break;
            default:
                switch ($method) {
                    case 'GET':
                        getUser($id);
                        break;
                    case 'PATCH':
                        $data = json_decode(file_get_contents('php://input'), true);
                        updateUser($id, $data);
                        break;
                }
        }
        break;
    case 'register':
        redirect('register.php');
        break;
    case 'auth':
        redirect('login.php');
}

?>