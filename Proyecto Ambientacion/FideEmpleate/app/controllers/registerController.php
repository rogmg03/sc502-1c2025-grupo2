<?php

namespace app\controllers;
use app\models\mainModel;

class registerController extends mainModel {

    public function registrarUsuarioControlador($rol) {
        // Obtener y limpiar datos del formulario
        $nombre     = $this->limpiarCadena($_POST['nombre'] ?? '');
        $correo     = $this->limpiarCadena($_POST['email'] ?? '');
        $contrasena = $this->limpiarCadena($_POST['contrasena'] ?? '');
        $confirmar  = $this->limpiarCadena($_POST['confirmar'] ?? '');

        // Validación: campos obligatorios
        if (empty($nombre) || empty($correo) || empty($contrasena) || empty($confirmar)) {
            return "Todos los campos son obligatorios.";
        }

        // Validación: longitud mínima de contraseña
        if (strlen($contrasena) < 6) {
            return "La contraseña debe tener al menos 6 caracteres.";
        }

        // Validación: coincidencia de contraseñas
        if ($contrasena !== $confirmar) {
            return "Las contraseñas no coinciden.";
        }

        // Validación: correo único
        $check = $this->ejecutarConsulta("SELECT id_usuario FROM usuarios WHERE correo_electronico = '$correo'");
        if ($check->rowCount() > 0) {
            return "Ya existe una cuenta registrada con ese correo.";
        }

        // Hashear la contraseña
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Preparar datos para insertar
        $datos = [
            ["campo_nombre" => "nombre_completo",    "campo_marcador" => ":Nombre",     "campo_valor" => $nombre],
            ["campo_nombre" => "correo_electronico", "campo_marcador" => ":Correo",     "campo_valor" => $correo],
            ["campo_nombre" => "contrasena",         "campo_marcador" => ":Clave",      "campo_valor" => $hash],
            ["campo_nombre" => "rol",                "campo_marcador" => ":Rol",        "campo_valor" => $rol],
            ["campo_nombre" => "verificado",         "campo_marcador" => ":Verificado", "campo_valor" => 1]
        ];

        // Insertar en la base de datos
        $guardar = $this->guardarDatos("usuarios", $datos);

        if ($guardar->rowCount() == 1) {
            return "Registro exitoso. Ya puedes <a href='login/'>iniciar sesión aquí</a>.";
        } else {
            return "Ocurrió un error al registrar el usuario. Intenta más tarde.";
        }
    }
}