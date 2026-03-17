<?php
// 1. Start the session for admin authentication
session_start();

// 2. Load necessary core files and configurations
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/core/Controller.php';

// Ensure functions.php exists for slugify() and other helpers
if (file_exists(__DIR__ . '/functions.php')) {
    require_once __DIR__ . '/functions.php';
}

/**
 * 3. Routing Logic Avanzato
 */
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// RIMUOVE l'eventuale "htdocs" e "index.php" se il server li inietta nell'URI
$requestUri = preg_replace('#^/htdocs/#', '/', $requestUri);
$requestUri = str_replace('/index.php', '', $requestUri);

// Suddivide l'URL in segmenti puliti
$segments = array_values(array_filter(explode('/', trim($requestUri, '/'))));

// Default destination: HomeController
if (empty($segments) || (isset($segments[0]) && $segments[0] == 'it' && count($segments) == 1)) {
    require_once __DIR__ . '/app/controllers/HomeController.php';
    $controller = new HomeController();
    $controller->index();

} elseif ($segments[0] == 'admin') {
    // Admin routes (e.g., /admin/dashboard or /admin/edit/5)
    require_once __DIR__ . '/app/controllers/AdminController.php';
    $controller = new AdminController();
    
    // Determine the method (default to 'dashboard')
    $method = $segments[1] ?? 'dashboard';
    
    // Check if the method exists in the controller
    if (method_exists($controller, $method)) {
        // Pass the ID if it exists (e.g., /admin/edit/123)
        $id = $segments[2] ?? null;
        $controller->$method($id);
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "Admin page not found.";
    }

} else {
    /**
     * Disease pages (e.g., /it/category-slug/disease-slug)
     */
    $diseaseSlug = end($segments);
    require_once __DIR__ . '/app/controllers/DiseaseController.php';
    $controller = new DiseaseController();
    $controller->show($diseaseSlug);
}