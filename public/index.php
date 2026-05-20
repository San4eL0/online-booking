<?php
session_start();

require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/Controllers/ClientController.php';
require_once __DIR__ . '/../src/Controllers/ServiceController.php';
require_once __DIR__ . '/../src/Controllers/SpecialistController.php';

$entity = $_GET['entity'] ?? 'client';
$action = $_GET['action'] ?? 'list';

$controllerMap = [
    'client' => ClientController::class,
    'service' => ServiceController::class,
    'specialist' => SpecialistController::class
];

if (!isset($controllerMap[$entity])) {
    redirect('index.php?entity=client&action=list', 'Неизвестная сущность', 'error');
}

$controllerClass = $controllerMap[$entity];
$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    redirect('index.php?entity=' . $entity . '&action=list', 'Неизвестное действие', 'error');
}

$controller->$action();
