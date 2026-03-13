<?php
class Controller {
    // Helper to load a model
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    // Helper to load a view and pass data to it
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            // Extract array keys into variables (e.g., $data['malattie'] becomes $malattie)
            extract($data); 
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View does not exist.");
        }
    }
}
?>