<?php
namespace app\controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use app\controllers\perfilEstudianteController;

require_once __DIR__ . '/../../vendor/autoload.php';

class exportarPDFController {

    public function exportarCV($id_estudiante) {
        $perfilCtrl = new perfilEstudianteController();
        $datos = $perfilCtrl->obtenerPerfilCompleto($id_estudiante);

        if (!$datos) {
            echo "CV no encontrado.";
            return;
        }

        ob_start();
        include './app/views/content/plantilla-pdf-cv.php';
        $html = ob_get_clean();

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("CV_Estudiante.pdf", ["Attachment" => false]);
    }
}
