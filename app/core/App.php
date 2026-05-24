<?php
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        if (empty($url)) {
            // Load default controller (HomeController)
            if (file_exists(__DIR__ . '/../Controllers/HomeController.php')) {
                $this->controller = 'HomeController';
            }
        } else {
            $controllerName = '';
            
            // Map legacy routes to Controllers
            if ($url[0] == 's') {
                $controllerName = 'SearchController';
                $_GET['p_url'] = $url[1] ?? '';
            } elseif ($url[0] == 'p') {
                $controllerName = 'ProductDetailController';
                $_GET['p_url'] = $url[1] ?? '';
            } elseif ($url[0] == 'v') {
                $controllerName = 'ProductCheckoutController';
                $_GET['p_url'] = $url[1] ?? '';
            } elseif ($url[0] == 'c') {
                $controllerName = 'CategoriesDetailController';
                $_GET['p_url'] = $url[1] ?? '';
            } elseif ($url[0] == 'c0') {
                $controllerName = 'CategoriesDetailC0Controller';
                $_GET['p_url'] = $url[1] ?? '';
            } elseif ($url[0] == 'c1') {
                $controllerName = 'CategoriesDetailC1Controller';
                $_GET['p_url'] = $url[1] ?? '';
                $_GET['s_url'] = $url[2] ?? '';
            } elseif ($url[0] == 'c2') {
                $controllerName = 'CategoriesDetailC2Controller';
                $_GET['p_url'] = $url[1] ?? '';
                $_GET['s_url'] = $url[2] ?? '';
                $_GET['t_url'] = $url[3] ?? '';
            } elseif ($url[0] == 'payment') {
                $controllerName = 'PaymentCallbackController';
                $_GET['p_url'] = $url[1] ?? '';
            } elseif ($url[0] == 'topup') {
                $controllerName = 'BalanceTopupController';
                $_GET['p_url'] = $url[1] ?? '';
            } elseif ($url[0] == 'trx') {
                $controllerName = 'TransactionDetailController';
                $_GET['p_url'] = $url[1] ?? '';
            } elseif ($url[0] == 'n') {
                $controllerName = 'NotificationDetailController';
                $_GET['p_url'] = $url[1] ?? '';
            } elseif ($url[0] == 'resetpass') {
                $controllerName = 'ResetPasswordController';
                $_GET['p_url'] = $url[1] ?? '';
            } else {
                // e.g. about-us -> AboutUsController
                $base_name = $url[0];
                $parts = explode('-', $base_name);
                $parts = array_map('ucfirst', $parts);
                $controllerName = implode('', $parts) . 'Controller';
            }

            if (file_exists(__DIR__ . '/../Controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
            } else {
                // Keep default if not found or throw 404
                // We'll fallback to HomeController for now or could implement 404
            }
        }

        require_once __DIR__ . '/../Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
