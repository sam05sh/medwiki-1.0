<?php
class Controller {
    // Helper to load a model
    public function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }

    // Helper to load a view and pass data to it
    public function view($view, $data = []) {
        if (file_exists(__DIR__ . '/../views/' . $view . '.php')) {
            extract($data); 
            require __DIR__ . '/../views/' . $view . '.php'; // Fixed: changed require_once to require
        } else {
            die("View does not exist: " . $view);
        }
    }
}
?>