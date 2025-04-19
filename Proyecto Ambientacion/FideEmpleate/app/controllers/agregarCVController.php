<?php

namespace app\controllers;

use app\models\mainModel;

class agregarCVController extends mainModel {

    public function agregarCVController() {
        $idUsuario = $_SESSION['id'];

        // 1. Información Personal
        $info = [
            ["campo_nombre" => "id_usuario",       "campo_marcador" => ":Usr",    "campo_valor" => $idUsuario],
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

        $this->guardarDatos("informacion_personal", $info);
        $idInfo = $this->conectar()->lastInsertId();

        // 2. Crear CV
        $cv = [
            ["campo_nombre" => "id_usuario", "campo_marcador" => ":Usr", "campo_valor" => $idUsuario],
            ["campo_nombre" => "id_informacion_personal", "campo_marcador" => ":Info", "campo_valor" => $idInfo],
            ["campo_nombre" => "activo", "campo_marcador" => ":Activo", "campo_valor" => 1]
        ];
        $this->guardarDatos("cv", $cv);
        $idCV = $this->conectar()->lastInsertId();

        // 3. Experiencia Laboral
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
                    ["campo_nombre" => "id_cv", "campo_marcador" => ":CV", "campo_valor" => $idCV],
                    ["campo_nombre" => "id_experiencia", "campo_marcador" => ":EXP", "campo_valor" => $idExp]
                ]);
            }
        }

        // 4. Formación Académica
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
                    ["campo_nombre" => "id_cv", "campo_marcador" => ":CV", "campo_valor" => $idCV],
                    ["campo_nombre" => "id_formacion", "campo_marcador" => ":FORM", "campo_valor" => $idForm]
                ]);
            }
        }

        // 5. Certificaciones
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
                    ["campo_nombre" => "id_cv", "campo_marcador" => ":CV", "campo_valor" => $idCV],
                    ["campo_nombre" => "id_certificacion", "campo_marcador" => ":CERT", "campo_valor" => $idCert]
                ]);
            }
        }

        return "Currículum guardado exitosamente.";
    }
}