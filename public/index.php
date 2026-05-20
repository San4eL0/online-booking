<?php
session_start();
require_once '../config/database.php';
require_once '../src/helpers.php';

$entity = $_GET['entity'] ?? 'client';
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Маппинг сущностей на контроллеры
$controllers = [
    'client' => 'ClientController',
    'service' => 'ServiceController',
    'specialist' => 'SpecialistController',
];

if (!isset($controllers[$entity])) {
    die('Неверная сущность');
}

$controllerClass = $controllers[$entity];
require_once "../src/Controllers/{$controllerClass}.php";

$controller = new $controllerClass($pdo);

// Вызов метода (list, create, edit, delete, view)
if (method_exists($controller, $action)) {
    if ($id) {
        $controller->$action($id);
    } else {
        $controller->$action();
    }
} else {
    die('Неверное действие');
}
