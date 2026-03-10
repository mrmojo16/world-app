<?php
// PUNTO DE ENTRADA PRINCIPAL DE LA APLICACIÓN
// Todas las peticiones pasan por aquí

// Cargar el controlador principal
require_once 'app/controllers/CityController.php';

// Crear instancia del controlador
$controller = new CityController();

// Obtener la acción solicitada (por defecto 'index')
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Enrutador simple
switch($action) {
    case 'getCities':
        $controller->getCities();
        break;
    case 'searchCountry':
        $controller->searchCountry();
        break;
    case 'topCities':
        $controller->topCities();
        break;
    default:
        $controller->index();
        break;
}
?>
