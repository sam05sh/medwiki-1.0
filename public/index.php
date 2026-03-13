<?php
session_start();
require_once '../app/config/database.php';
require_once '../app/core/Controller.php';
require_once '../functions.php'; // Your helper functions

// Very basic routing logic
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = array_values(array_filter(explode('/', trim($requestUri, '/'))));

// Default to HomeController
$controllerName = 'HomeController';
$methodName = 'index';
$params = [];

if (empty($segments) || (isset($segments[0]) && $segments[0] == 'it' && count($segments) == 1)) {
    // Home
    require_once '../app/controllers/HomeController.php';
    $controller = new HomeController();
    $controller->index();
} elseif ($segments[0] == 'admin') {
    // Admin routing
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $method = $segments[1] ?? 'dashboard';
    $controller->$method();
} else {
    // Disease page (e.g., /it/category-slug/disease-slug)
    $diseaseSlug = end($segments);
    require_once '../app/controllers/DiseaseController.php';
    $controller = new DiseaseController();
    $controller->show($diseaseSlug);
}
?>