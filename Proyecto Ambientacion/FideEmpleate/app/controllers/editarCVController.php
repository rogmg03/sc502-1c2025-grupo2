<?php
namespace app\controllers;

use app\models\mainModel;

class editarCVController extends mainModel {

    public function obtenerDatosCV($id_cv) {
        $db = $this->conectar();

        $sql = "SELECT ip.*, cv.id_cv, ip.id_personal FROM cv 
                INNER JOIN informacion_personal ip ON cv.id_informacion_personal = ip.id_personal
                WHERE cv.id_cv = :id_cv";
        $stmt = $this->ejecutarConsultaParametros($sql, [':id_cv' => $id_cv]);
        $info_personal = $stmt->fetch(\PDO::FETCH_ASSOC);

        $sql = "SELECT el.* FROM experiencia_laboral el
                INNER JOIN cv_experiencia ce ON ce.id_experiencia = el.id_experiencia
                WHERE ce.id_cv = :id_cv";
        $experiencia = $this->ejecutarConsultaParametros($sql, [':id_cv' => $id_cv])->fetchAll(\PDO::FETCH_ASSOC);

        $sql = "SELECT fa.* FROM formacion_academica fa
                INNER JOIN cv_formacion cf ON cf.id_formacion = fa.id_formacion
                WHERE cf.id_cv = :id_cv";
        $formacion = $this->ejecutarConsultaParametros($sql, [':id_cv' => $id_cv])->fetchAll(\PDO::FETCH_ASSOC);

        $sql = "SELECT c.* FROM certificaciones c
                INNER JOIN cv_certificaciones cc ON cc.id_certificacion = c.id_certificacion
                WHERE cc.id_cv = :id_cv";
        $certificaciones = $this->ejecutarConsultaParametros($sql, [':id_cv' => $id_cv])->fetchAll(\PDO::FETCH_ASSOC);

        return [
            'info_personal' => $info_personal,
            'experiencia' => $experiencia,
            'formacion' => $formacion,
            'certificaciones' => $certificaciones
        ];
    }

    public function actualizarCVController($id_cv) {
        $idUsuario = $_SESSION['id'];

        $datos = $this->obtenerDatosCV($id_cv);
        $idInfo = $datos['info_personal']['id_personal'];

        // Actualizar Información Personal
        $info = [
            ["campo_nombre" => "nombre",           "campo_marcador" => ":Nom",    "campo_valor" => $_POST['nombre'] ?? ''],
            ["campo_nombre" => "apellidos",        "campo_marcador" => ":Ape",    "campo_valor" => $_POST['apellidos'] ?? ''],
            ["campo_nombre" => "fecha_nacimiento", "campo_marcador" => ":FN",     "campo_valor" => $_POST['fecha_nacimiento'] ?? null],
            ["campo_nombre" => "cedula",           "campo_marcador" => ":Ced",    "campo_valor" => $_POST['cedula'] ?? ''],
            ["campo_nombre" => "telefono",         "campo_marcador" => ":Tel",    "campo_valor" => $_POST['telefono'] ?? ''],
            ["campo_nombre" => "email",            "campo_marcador" => ":Email",  "campo_valor" => $_POST['email'] ?? ''],
            ["campo_nombre" => "direccion",        "campo_marcador" => ":Dir",    "campo_valor" => $_POST['direccion'] ?? ''],
            ["campo_nombre" => "sobre_mi",         "campo_marcador" => ":Sobre",  "campo_valor" => $_POST['descripcion'] ?? ''],
            ["campo_nombre" => "estudiante_de",    "campo_marcador" => ":Carrera","campo_valor" => $_POST['estudiante_de'] ?? '']
        ];
        $this->actualizarDatos("informacion_personal", $info, "id_personal = :id", [":id" => $idInfo]);

        // Borrar registros relacionados
        $this->ejecutarConsultaParametros("DELETE FROM cv_experiencia WHERE id_cv = :id", [":id" => $id_cv]);
        $this->ejecutarConsultaParametros("DELETE FROM experiencia_laboral WHERE id_usuario = :id", [":id" => $idUsuario]);

        $this->ejecutarConsultaParametros("DELETE FROM cv_formacion WHERE id_cv = :id", [":id" => $id_cv]);
        $this->ejecutarConsultaParametros("DELETE FROM formacion_academica WHERE id_usuario = :id", [":id" => $idUsuario]);

        $this->ejecutarConsultaParametros("DELETE FROM cv_certificaciones WHERE id_cv = :id", [":id" => $id_cv]);
        $this->ejecutarConsultaParametros("DELETE FROM certificaciones WHERE id_usuario = :id", [":id" => $idUsuario]);

        // Insertar de nuevo experiencia laboral
        if (isset($_POST['cargo'])) {
            foreach ($_POST['cargo'] as $i => $cargo) {
                $exp = [
                    ["campo_nombre" => "id_usuario",        "campo_marcador" => ":Usr",    "campo_valor" => $idUsuario],
                    ["campo_nombre" => "cargo",             "campo_marcador" => ":Cargo",  "campo_valor" => $cargo],
                    ["campo_nombre" => "tipo_empleo",       "campo_marcador" => ":Tipo",   "campo_valor" => $_POST['tipo_empleo'][$i] ?? ''],
                    ["campo_nombre" => "empresa",           "campo_marcador" => ":Emp",    "campo_valor" => $_POST['empresa'][$i] ?? ''],
                    ["campo_nombre" => "fecha_inicio",      "campo_marcador" => ":Ini",    "campo_valor" => $_POST['fecha_inicio'][$i] ?? null],
                    ["campo_nombre" => "fecha_finalizacion","campo_marcador" => ":Fin",    "campo_valor" => $_POST['fecha_fin'][$i] ?? null],
                    ["campo_nombre" => "ubicacion",         "campo_marcador" => ":Ubic",   "campo_valor" => $_POST['ubicacion'][$i] ?? ''],
                    ["campo_nombre" => "modalidad",         "campo_marcador" => ":Mod",    "campo_valor" => $_POST['modalidad'][$i] ?? ''],
                    ["campo_nombre" => "descripcion",       "campo_marcador" => ":Desc",   "campo_valor" => $_POST['descripciondelempleo'][$i] ?? '']
                ];
                $this->guardarDatos("experiencia_laboral", $exp);
                $idExp = $this->conectar()->lastInsertId();

                $this->guardarDatos("cv_experiencia", [
                    ["campo_nombre" => "id_cv", "campo_marcador" => ":CV", "campo_valor" => $id_cv],
                    ["campo_nombre" => "id_experiencia", "campo_marcador" => ":EXP", "campo_valor" => $idExp]
                ]);
            }
        }

        // Formación académica
        if (isset($_POST['institucion'])) {
            foreach ($_POST['institucion'] as $i => $inst) {
                $form = [
                    ["campo_nombre" => "id_usuario",         "campo_marcador" => ":Usr",    "campo_valor" => $idUsuario],
                    ["campo_nombre" => "institucion",        "campo_marcador" => ":Inst",   "campo_valor" => $inst],
                    ["campo_nombre" => "titulo_obtenido",    "campo_marcador" => ":Tit",    "campo_valor" => $_POST['titulo'][$i] ?? ''],
                    ["campo_nombre" => "fecha_inicio",       "campo_marcador" => ":Ini",    "campo_valor" => $_POST['fecha_inicio'][$i] ?? null],
                    ["campo_nombre" => "fecha_finalizacion", "campo_marcador" => ":Fin",    "campo_valor" => $_POST['fecha_fin'][$i] ?? null]
                ];
                $this->guardarDatos("formacion_academica", $form);
                $idForm = $this->conectar()->lastInsertId();

                $this->guardarDatos("cv_formacion", [
                    ["campo_nombre" => "id_cv", "campo_marcador" => ":CV", "campo_valor" => $id_cv],
                    ["campo_nombre" => "id_formacion", "campo_marcador" => ":FORM", "campo_valor" => $idForm]
                ]);
            }
        }

        // Certificaciones
        if (isset($_POST['nombre_certificado'])) {
            foreach ($_POST['nombre_certificado'] as $i => $nombreCert) {
                $cert = [
                    ["campo_nombre" => "id_usuario",       "campo_marcador" => ":Usr",   "campo_valor" => $idUsuario],
                    ["campo_nombre" => "nombre",           "campo_marcador" => ":Nom",   "campo_valor" => $nombreCert],
                    ["campo_nombre" => "empresa_emisora",  "campo_marcador" => ":Emp",   "campo_valor" => $_POST['empresa_emisora'][$i] ?? ''],
                    ["campo_nombre" => "fecha_expedicion", "campo_marcador" => ":Exp",   "campo_valor" => $_POST['fecha_expedicion'][$i] ?? null],
                    ["campo_nombre" => "fecha_caducidad",  "campo_marcador" => ":Cad",   "campo_valor" => $_POST['fecha_caducidad'][$i] ?? null],
                    ["campo_nombre" => "id_credencial",    "campo_marcador" => ":ID",    "campo_valor" => $_POST['idcredenciales'][$i] ?? null],
                    ["campo_nombre" => "url_credencial",   "campo_marcador" => ":URL",   "campo_valor" => $_POST['urlcredenciales'][$i] ?? '']
                ];
                $this->guardarDatos("certificaciones", $cert);
                $idCert = $this->conectar()->lastInsertId();

                $this->guardarDatos("cv_certificaciones", [
                    ["campo_nombre" => "id_cv", "campo_marcador" => ":CV", "campo_valor" => $id_cv],
                    ["campo_nombre" => "id_certificacion", "campo_marcador" => ":CERT", "campo_valor" => $idCert]
                ]);
            }
        }

        return "Currículum actualizado exitosamente.";
    }
}