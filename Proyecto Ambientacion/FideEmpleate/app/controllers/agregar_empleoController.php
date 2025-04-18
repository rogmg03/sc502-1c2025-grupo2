<?php

namespace app\controllers;
use app\models\mainModel;

class agregar_empleoController extends mainModel {

    public function agregar_empleoController() {
        // Obtener y limpiar los datos
        $idReclutador = $_SESSION['id'];
        $usuario_reclutador = $idReclutador;
        $nombre            = $this->limpiarCadena($_POST["nombrePuesto"] ?? '');
        $area              = $this->limpiarCadena($_POST["areaPuesto"] ?? '');
        $descripcion       = $this->limpiarCadena($_POST["descripcionPuesto"] ?? '');
        $requisitos        = $this->limpiarCadena($_POST["requisitosPuesto"] ?? '');
        $modalidad         = $this->limpiarCadena($_POST["modalidadPuesto"] ?? '');
        $ubicacion         = $this->limpiarCadena($_POST["ubicacionPuesto"] ?? '');
        $salario           = $this->limpiarCadena($_POST["salarioPuesto"] ?? '');
        $fecha_publicacion = $this->limpiarCadena($_POST["fechaPublicacion"] ?? '');
        $estado            = $this->limpiarCadena($_POST["estadoPuesto"] ?? '');

        // Validación de campos requeridos
        if (empty($nombre) || empty($area) || empty($modalidad) || empty($fecha_publicacion) || empty($estado)) {
            return "Por favor completa todos los campos obligatorios.";
        }

        // Salario opcional
        $salario = $salario !== '' ? $salario : null;

        // Armar arreglo de datos
        $datos = [
            ["campo_nombre" => "id_usuario_reclutador", "campo_marcador" => ":IdReclutador", "campo_valor" => $idReclutador],
            ["campo_nombre" => "nombre_puesto",             "campo_marcador" => ":Nombre",      "campo_valor" => $nombre],
            ["campo_nombre" => "area",               "campo_marcador" => ":Area",        "campo_valor" => $area],
            ["campo_nombre" => "descripcion",        "campo_marcador" => ":Descripcion", "campo_valor" => $descripcion],
            ["campo_nombre" => "requisitos",         "campo_marcador" => ":Requisitos",  "campo_valor" => $requisitos],
            ["campo_nombre" => "modalidad",          "campo_marcador" => ":Modalidad",   "campo_valor" => $modalidad],
            ["campo_nombre" => "ubicacion",          "campo_marcador" => ":Ubicacion",   "campo_valor" => $ubicacion],
            ["campo_nombre" => "salario",            "campo_marcador" => ":Salario",     "campo_valor" => $salario],
            ["campo_nombre" => "fecha_publicacion",  "campo_marcador" => ":Fecha",       "campo_valor" => $fecha_publicacion],
            ["campo_nombre" => "estado",             "campo_marcador" => ":Estado",      "campo_valor" => $estado]
        ];

        // Guardar en base de datos
        $guardar = $this->guardarDatos("empleos", $datos);

        if ($guardar->rowCount() == 1) {
            return "✅ Empleo guardado con éxito.";
        } else {
            return "⚠️ Error al guardar el empleo. Inténtalo más tarde.";
        }
    }
}
