<?php
session_start();

require_once __DIR__ . '/../models/mainModel.php';
require_once __DIR__ . '/chatController.php';
require_once __DIR__ . '/../../config/app.php';
require_once dirname(__DIR__) . '/views/inc/session_start.php';


use app\controllers\chatController;



if (!isset($_SESSION['id']) || empty($_POST['contenido']) || empty($_POST['receptor'])) {
    $_SESSION['chat_error'] = "Datos inválidos.";
    header("Location: " . APP_URL . "a-chat/");
    exit;
}

$idEmisor = $_SESSION['id'];
$idReceptor = (int) $_POST['receptor'];
$contenido = trim($_POST['contenido']);

$chat = new chatController();
$idConversacion = $chat->obtenerOCrearConversacion($idEmisor, $idReceptor);


if (!$idConversacion) {
    $_SESSION['chat_error'] = "No se pudo crear la conversación.";
    header("Location: " . APP_URL . "a-chat/");
    exit;
}

$mensajeGuardado = $chat->guardarMensaje($idConversacion, $idEmisor, $contenido);

if ($mensajeGuardado) {
    $_SESSION['mensaje_enviado'] = "Mensaje enviado con éxito.";
    header("Location: " . APP_URL . "a-chat/?id=$idReceptor");
    exit;
} else {
    $_SESSION['chat_error'] = "Error al guardar el mensaje.";
    header("Location: " . APP_URL . "a-chat/");
    exit;
}
