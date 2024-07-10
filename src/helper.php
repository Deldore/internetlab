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