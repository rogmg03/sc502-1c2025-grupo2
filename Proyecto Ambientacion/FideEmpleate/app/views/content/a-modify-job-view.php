<?php
use app\controllers\editar_empleoController;

require_once ROOT_PATH . 'app/controllers/editar_empleoController.php';

$controller = new editar_empleoController();
$mensaje = $controller->editarEmpleoControlador();

// Redirigir
header("Location: " . APP_URL . "a-view-jobs/");
exit();
