<?php
require_once '../../vendor/autoload.php';
require_once '../../config/app.php';
require_once '../../autoload.php';

use Dompdf\Dompdf;
use app\controllers\perfilEstudianteController;

$id = $_GET['id'] ?? $_SESSION['id'] ?? null;
$controller = new perfilEstudianteController();
$datos = $controller->obtenerPerfilCompleto($id);

if (!$datos) {
    echo "Currículum no encontrado.";
    exit;
}

// Iniciar dompdf
$dompdf = new Dompdf();
ob_start();

// Incluye HTML con estilos inline o un HTML optimizado para PDF
include 'plantilla-pdf-cv.php';

$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Descargar
$dompdf->stream("CV_" . $datos['info_personal']['nombre'] . ".pdf", ["Attachment" => false]);
