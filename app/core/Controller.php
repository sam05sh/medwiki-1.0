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
            // Extract array keys into variables (e.g., $data['malattie'] becomes $malattie)
            extract($data); 
            require_once __DIR__ . '/../views/' . $view . '.php';
        } else {
            die("View does not exist.");
        }
    }
}
?>