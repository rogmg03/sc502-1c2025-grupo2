<?php
use app\controllers\eliminar_empleoController;

require_once ROOT_PATH . 'app/controllers/eliminar_empleoController.php';

$idEmpleo = $_GET['id'] ?? null;
$eliminar = new eliminar_empleoController();
$mensaje = $eliminar->eliminarEmpleoControlador($idEmpleo);

// Redirige con mensaje opcional (se puede usar session flash si deseás mostrarlo)
header("Location: " . APP_URL . "a-view-jobs/");
exit();
