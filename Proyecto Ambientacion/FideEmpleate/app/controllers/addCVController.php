<?php

namespace app\controllers;
use app\models\mainModel;
class addCVController extends mainModel {

  public function guardar_cv_controlador() {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $sobreMi = $_POST['sobre_mi'];
    $areaEstudio = $_POST['area_estudio'];

    $consulta = "INSERT INTO curriculum (nombre, apellidos, fecha_nacimiento, cedula, telefono, email, direccion, sobre_mi, area_estudio) 
                 VALUES ('$nombre', '$apellidos', '$fechaNacimiento', '$cedula', '$telefono', '$email', '$direccion', '$sobreMi', '$areaEstudio')";

    $guardar = mainModel::ejecutarConsulta($consulta);

    if ($guardar->rowCount() >= 1) {
      echo "Curriculum guardado con éxito.";
    } else {
      echo "Error al guardar el curriculum.";
    }
  }
}

$cv = new addCVController();
$cv->guardar_cv_controlador();