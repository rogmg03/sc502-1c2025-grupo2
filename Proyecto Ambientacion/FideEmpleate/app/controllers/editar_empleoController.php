<?php
namespace app\controllers;
use app\models\mainModel;

class editar_empleoController extends mainModel {

    public function editarEmpleoControlador() {
        $idReclutador = $_SESSION['id'] ?? null;
        $idEmpleo     = $_POST['id_empleo'] ?? null;

        if (!$idEmpleo || !$idReclutador) {
            return "Datos incompletos para editar.";
        }

        // Limpiar datos
        $datos = [
            "nombre"     => $this->limpiarCadena($_POST['nombre'] ?? ''),
            "area"       => $this->limpiarCadena($_POST['area'] ?? ''),
            "descripcion"=> $this->limpiarCadena($_POST['descripcion'] ?? ''),
            "requisitos" => $this->limpiarCadena($_POST['requisitos'] ?? ''),
            "modalidad"  => $this->limpiarCadena($_POST['modalidad'] ?? ''),
            "ubicacion"  => $this->limpiarCadena($_POST['ubicacion'] ?? ''),
            "salario"    => $this->limpiarCadena($_POST['salario'] ?? ''),
            "estado"     => $this->limpiarCadena($_POST['estado'] ?? ''),
        ];

        // Armar array para UPDATE
        $campos = [
            ["campo_nombre" => "nombre_puesto", "campo_marcador" => ":Nombre", "campo_valor" => $datos["nombre"]],
            ["campo_nombre" => "area",          "campo_marcador" => ":Area",   "campo_valor" => $datos["area"]],
            ["campo_nombre" => "descripcion",   "campo_marcador" => ":Descripcion", "campo_valor" => $datos["descripcion"]],
            ["campo_nombre" => "requisitos",    "campo_marcador" => ":Requisitos",  "campo_valor" => $datos["requisitos"]],
            ["campo_nombre" => "modalidad",     "campo_marcador" => ":Modalidad",   "campo_valor" => $datos["modalidad"]],
            ["campo_nombre" => "ubicacion",     "campo_marcador" => ":Ubicacion",   "campo_valor" => $datos["ubicacion"]],
            ["campo_nombre" => "salario",       "campo_marcador" => ":Salario",     "campo_valor" => $datos["salario"]],
            ["campo_nombre" => "estado",        "campo_marcador" => ":Estado",      "campo_valor" => $datos["estado"]],
        ];

        $condicion = [
            "condicion_campo" => "id_empleo",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $idEmpleo
        ];

        $resultado = $this->actualizarDatos("empleos", $campos, $condicion);

        if ($resultado->rowCount() > 0) {
            return "Cambios guardados correctamente.";
        } else {
            return "No se realizaron cambios o falló la actualización.";
        }
    }
}

