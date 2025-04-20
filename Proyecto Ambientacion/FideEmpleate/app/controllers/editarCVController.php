<?php
namespace app\controllers;

use app\models\mainModel;
use PDO;

class editarCVController extends mainModel {

    public function obtenerDatosCV($id_cv) {
        $sql = "SELECT ip.*, cv.id_cv, ip.id_personal FROM cv 
                INNER JOIN informacion_personal ip ON cv.id_informacion_personal = ip.id_personal
                WHERE cv.id_cv = :id_cv";
        $stmt = $this->ejecutarConsultaParametros($sql, [':id_cv' => $id_cv]);
        $info_personal = $stmt->fetch(PDO::FETCH_ASSOC);

        $experiencia = $this->ejecutarConsultaParametros("
            SELECT el.* FROM experiencia_laboral el
            INNER JOIN cv_experiencia ce ON ce.id_experiencia = el.id_experiencia
            WHERE ce.id_cv = :id_cv", [':id_cv' => $id_cv])->fetchAll(PDO::FETCH_ASSOC);

        $formacion = $this->ejecutarConsultaParametros("
            SELECT fa.* FROM formacion_academica fa
            INNER JOIN cv_formacion cf ON cf.id_formacion = fa.id_formacion
            WHERE cf.id_cv = :id_cv", [':id_cv' => $id_cv])->fetchAll(PDO::FETCH_ASSOC);

        $certificaciones = $this->ejecutarConsultaParametros("
            SELECT c.* FROM certificaciones c
            INNER JOIN cv_certificaciones cc ON cc.id_certificacion = c.id_certificacion
            WHERE cc.id_cv = :id_cv", [':id_cv' => $id_cv])->fetchAll(PDO::FETCH_ASSOC);

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

        $conexion = $this->conectar();
        $conexion->beginTransaction(); // Importante: transacción para atomicidad

        try {
            // Actualizar info personal
            $info = [
                ["campo_nombre" => "nombre", "campo_marcador" => ":Nom", "campo_valor" => $_POST['nombre'] ?? ''],
                ["campo_nombre" => "apellidos", "campo_marcador" => ":Ape", "campo_valor" => $_POST['apellidos'] ?? ''],
                ["campo_nombre" => "fecha_nacimiento", "campo_marcador" => ":FN", "campo_valor" => $_POST['fecha_nacimiento'] ?? null],
                ["campo_nombre" => "cedula", "campo_marcador" => ":Ced", "campo_valor" => $_POST['cedula'] ?? ''],
                ["campo_nombre" => "telefono", "campo_marcador" => ":Tel", "campo_valor" => $_POST['telefono'] ?? ''],
                ["campo_nombre" => "email", "campo_marcador" => ":Email", "campo_valor" => $_POST['email'] ?? ''],
                ["campo_nombre" => "direccion", "campo_marcador" => ":Dir", "campo_valor" => $_POST['direccion'] ?? ''],
                ["campo_nombre" => "sobre_mi", "campo_marcador" => ":Sobre", "campo_valor" => $_POST['descripcion'] ?? ''],
                ["campo_nombre" => "estudiante_de", "campo_marcador" => ":Carrera", "campo_valor" => $_POST['estudiante_de'] ?? '']
            ];

            // Usamos directamente el objeto PDO para actualizar
            $query = "UPDATE informacion_personal SET 
                        nombre = :Nom, apellidos = :Ape, fecha_nacimiento = :FN, cedula = :Ced,
                        telefono = :Tel, email = :Email, direccion = :Dir, sobre_mi = :Sobre,
                        estudiante_de = :Carrera 
                      WHERE id_personal = :id";
            $stmt = $conexion->prepare($query);
            foreach ($info as $clave) {
                $stmt->bindValue($clave["campo_marcador"], $clave["campo_valor"]);
            }
            $stmt->bindValue(":id", $idInfo);
            $stmt->execute();

            // Eliminar relaciones y datos antiguos
            $conexion->prepare("DELETE FROM cv_experiencia WHERE id_cv = :id")->execute([":id" => $id_cv]);
            $conexion->prepare("DELETE FROM cv_formacion WHERE id_cv = :id")->execute([":id" => $id_cv]);
            $conexion->prepare("DELETE FROM cv_certificaciones WHERE id_cv = :id")->execute([":id" => $id_cv]);
            $conexion->prepare("DELETE FROM experiencia_laboral WHERE id_usuario = :id")->execute([":id" => $idUsuario]);
            $conexion->prepare("DELETE FROM formacion_academica WHERE id_usuario = :id")->execute([":id" => $idUsuario]);
            $conexion->prepare("DELETE FROM certificaciones WHERE id_usuario = :id")->execute([":id" => $idUsuario]);

            // Insertar experiencia
            if (isset($_POST['cargo'])) {
                foreach ($_POST['cargo'] as $i => $cargo) {
                    $stmt = $conexion->prepare("INSERT INTO experiencia_laboral (
                        id_usuario, cargo, tipo_empleo, empresa, fecha_inicio, fecha_finalizacion,
                        ubicacion, modalidad, descripcion
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $idUsuario,
                        $cargo,
                        $_POST['tipo_empleo'][$i] ?? '',
                        $_POST['empresa'][$i] ?? '',
                        $_POST['fecha_inicio'][$i] ?? null,
                        $_POST['fecha_fin'][$i] ?? null,
                        $_POST['ubicacion'][$i] ?? '',
                        $_POST['modalidad'][$i] ?? '',
                        $_POST['descripciondelempleo'][$i] ?? ''
                    ]);
                    $idExp = $conexion->lastInsertId();

                    $conexion->prepare("INSERT INTO cv_experiencia (id_cv, id_experiencia) VALUES (?, ?)")
                             ->execute([$id_cv, $idExp]);
                }
            }

            // Insertar formacion
            if (isset($_POST['institucion'])) {
                foreach ($_POST['institucion'] as $i => $inst) {
                    $stmt = $conexion->prepare("INSERT INTO formacion_academica (
                        id_usuario, institucion, titulo_obtenido, fecha_inicio, fecha_finalizacion
                    ) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $idUsuario,
                        $inst,
                        $_POST['titulo'][$i] ?? '',
                        $_POST['fecha_inicio'][$i] ?? null,
                        $_POST['fecha_fin'][$i] ?? null
                    ]);
                    $idForm = $conexion->lastInsertId();

                    $conexion->prepare("INSERT INTO cv_formacion (id_cv, id_formacion) VALUES (?, ?)")
                             ->execute([$id_cv, $idForm]);
                }
            }

            // Insertar certificaciones
            if (isset($_POST['nombre_certificado'])) {
                foreach ($_POST['nombre_certificado'] as $i => $nombreCert) {
                    $stmt = $conexion->prepare("INSERT INTO certificaciones (
                        id_usuario, nombre, empresa_emisora, fecha_expedicion, fecha_caducidad,
                        id_credencial, url_credencial
                    ) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $idUsuario,
                        $nombreCert,
                        $_POST['empresa_emisora'][$i] ?? '',
                        $_POST['fecha_expedicion'][$i] ?? null,
                        $_POST['fecha_caducidad'][$i] ?? null,
                        $_POST['idcredenciales'][$i] ?? null,
                        $_POST['urlcredenciales'][$i] ?? ''
                    ]);
                    $idCert = $conexion->lastInsertId();

                    $conexion->prepare("INSERT INTO cv_certificaciones (id_cv, id_certificacion) VALUES (?, ?)")
                             ->execute([$id_cv, $idCert]);
                }
            }

            $conexion->commit();
            $_SESSION['cv_mensaje'] = "Currículum actualizado exitosamente.";
$_SESSION['cv_redirect'] = true;
return true;

        } catch (\Exception $e) {
            $conexion->rollBack();
            return "Error al actualizar el currículum: " . $e->getMessage();
        }
    }
}
