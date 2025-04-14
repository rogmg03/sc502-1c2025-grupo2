<?php
require_once "./config/app.php";
require_once "./autoload.php";

/*---------- Iniciando sesión ----------*/
require_once "./app/views/inc/session_start.php";

if(isset($_GET['views'])){
    $url=explode("/", $_GET['views']);
}else{
    $url=["login"];
}

use app\controllers\viewsController;
use app\controllers\loginController;

$insLogin = new loginController();
$viewsController= new viewsController();
$vista = $viewsController->obtenerVistasControlador($url[0]);

if($vista == "login" || $vista == "404") {
    // Si la vista es 'login', muestra el formulario de inicio de sesión
    require_once "./app/views/content/".$vista."-view.php";
} else {
    // Verificación de sesión
    if ((!isset($_SESSION['id']) || $_SESSION['id'] == "") || (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
        $insLogin->cerrarSesionControlador();
        exit();
    }

    require_once "./app/views/inc/navbar.php";

    require_once $vista;
}

require_once "./app/views/inc/script.php"; 


