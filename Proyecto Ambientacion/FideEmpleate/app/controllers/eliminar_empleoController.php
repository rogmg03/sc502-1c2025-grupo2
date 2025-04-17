<?php
namespace app\controllers;

use app\models\mainModel;

class eliminar_empleoController extends mainModel {

    public function eliminarEmpleoControlador($idEmpleo) {
        $idReclutador = $_SESSION['id'] ?? null;

        if (!$idEmpleo || !$idReclutador) {
            return "Solicitud no válida.";
        }

        $sql = "DELETE FROM empleos WHERE id_empleo = :id AND id_usuario_reclutador = :reclutador";
        $parametros = [
            ":id" => $idEmpleo,
            ":reclutador" => $idReclutador
        ];

        $result = $this->ejecutarConsultaParametros($sql, $parametros);

        if ($result->rowCount() > 0) {
            return "El empleo fue eliminado correctamente.";
        } else {
            return "No se pudo eliminar el empleo o no te pertenece.";
        }
    }
}
