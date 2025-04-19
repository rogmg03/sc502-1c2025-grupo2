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
$vista = $viewsController->obtenerVistasControlador(rtrim($url[0], "/"));

if (in_array($vista, ["login", "register", "404"])) {
    require_once "./app/views/content/{$vista}-view.php";
} else {
    if (empty($_SESSION['id']) || empty($_SESSION['correo'])) {
        $insLogin->cerrarSesionControlador(); // o redirige
        exit();
    }
    require_once "./app/views/content/{$vista}-view.php";
}


require_once "./app/views/inc/script.php"; 


