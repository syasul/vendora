<?php

// Add project root to include path so relative includes in Views resolve correctly
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__));

require_once __DIR__ . '/../module/module.php';
if (file_exists(__DIR__ . '/../config/config.php')) {
    require_once __DIR__ . '/../config/config.php';
}

require_once __DIR__ . '/core/App.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Model.php';

spl_autoload_register(function ($className) {
    $controllerPath = __DIR__ . '/Controllers/' . $className . '.php';
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
    }
});
