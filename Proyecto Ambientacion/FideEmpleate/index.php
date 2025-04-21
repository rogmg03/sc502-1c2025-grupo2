<?php
session_start();

require_once "./config/app.php";
require_once "./autoload.php";
require_once "./app/views/inc/session_start.php";

use app\controllers\viewsController;
use app\controllers\loginController;

$viewsController = new viewsController();
$insLogin = new loginController();

// Separar vista e ID de la URL
$segmentos = isset($_GET['views']) ? explode("/", $_GET['views']) : ["home"];
$vista = $segmentos[0];
$id = $segmentos[1] ?? null;

if ($id) {
    $_GET['id'] = $id;
}

$paginasPublicas = ["home", "login", "register", "404"];

// Si la vista es pública
if (in_array($vista, $paginasPublicas)) {
    if ($vista == "exportar-pdf" && isset($url[1])) {
        $exportar = new \app\controllers\exportarPDFController();
        $exportar->exportarCV($url[1]);
        exit();
    } else {

        require_once "./app/views/content/" . $vista . "-view.php";
        exit();
    }
}

// Vista privada (requiere sesión)
if (empty($_SESSION['id']) || empty($_SESSION['correo'])) {
    header("Location: " . APP_URL . "home/");
    exit();
}

// Vista válida y protegida
$vistaRuta = $viewsController->obtenerVistasControlador($vista);
require_once $vistaRuta;

require_once "./app/views/inc/script.php";



