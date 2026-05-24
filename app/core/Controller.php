<?php
class Controller {
    public function model($model) {
        $modelPath = __DIR__ . '/../Models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model();
        }
        return false;
    }

    public function view($view, $data = []) {
        // Extract data so variables are available in the view
        extract($data);
        
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View does not exist: " . $view);
        }
    }
}
