<?php
// public/index.php
session_start();

// Habilitar reporte de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cargar Controlador predeterminado
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'ProveedorController';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            echo "Error 404: La acción '$action' no existe.";
        }
    } else {
        echo "Error 404: La clase del controlador no existe.";
    }
} else {
    echo "Error 404: El archivo del controlador no fue encontrado.";
}

// Cargar Controlador predeterminado
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'ProveedorController';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            echo "Error 404: La acción '$action' no existe.";
        }
    } else {
        echo "Error 404: La clase del controlador no existe.";
    }
} else {
    echo "Error 404: El archivo del controlador no fue encontrado.";
}