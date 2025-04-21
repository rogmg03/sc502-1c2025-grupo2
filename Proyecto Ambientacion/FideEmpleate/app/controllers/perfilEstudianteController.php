<?php
namespace app\controllers;

use app\models\mainModel;
use PDO;

class perfilEstudianteController extends mainModel {

    public function obtenerPerfilCompleto($id_estudiante) {
        $sql = "SELECT c.id_cv, ip.* FROM cv c
                INNER JOIN informacion_personal ip ON c.id_informacion_personal = ip.id_personal
                WHERE c.id_usuario = :id AND c.activo = 1 LIMIT 1";
        $stmt = $this->ejecutarConsultaParametros($sql, [":id" => $id_estudiante]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$info) return null;

        $id_cv = $info['id_cv'];

        $experiencia = $this->ejecutarConsultaParametros("
            SELECT el.* FROM experiencia_laboral el
            INNER JOIN cv_experiencia ce ON el.id_experiencia = ce.id_experiencia
            WHERE ce.id_cv = :id", [":id" => $id_cv])->fetchAll(PDO::FETCH_ASSOC);

        $formacion = $this->ejecutarConsultaParametros("
            SELECT fa.* FROM formacion_academica fa
            INNER JOIN cv_formacion cf ON fa.id_formacion = cf.id_formacion
            WHERE cf.id_cv = :id", [":id" => $id_cv])->fetchAll(PDO::FETCH_ASSOC);

        $certificaciones = $this->ejecutarConsultaParametros("
            SELECT c.* FROM certificaciones c
            INNER JOIN cv_certificaciones cc ON c.id_certificacion = cc.id_certificacion
            WHERE cc.id_cv = :id", [":id" => $id_cv])->fetchAll(PDO::FETCH_ASSOC);

        return [
            'info_personal' => $info,
            'experiencia' => $experiencia,
            'formacion' => $formacion,
            'certificaciones' => $certificaciones
        ];
    }
}
