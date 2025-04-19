<?php

namespace app\controllers;
use app\models\mainModel;

class actualizarUsuarioController extends mainModel {

    public function actualizarUsuarioControlador() {
        // Obtener y limpiar datos del formulario
        $idUsuario  = $_SESSION['id']; // ID del usuario en sesión
        $nombre     = $this->limpiarCadena($_POST['nombre'] ?? '');
        $correo     = $this->limpiarCadena($_POST['email'] ?? '');
        $contrasena = $this->limpiarCadena($_POST['contrasena'] ?? '');

        // Validación de campos obligatorios
        if (empty($nombre) || empty($correo)) {
            return "Todos los campos son obligatorios.";
        }

        // Validar correo
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return "Correo electrónico no válido.";
        }

        // Validar que el correo no se repita (excluyendo al usuario actual)
        $check = $this->ejecutarConsulta("SELECT id_usuario FROM usuarios WHERE correo_electronico = '$correo' AND id_usuario != '$idUsuario'");
        if ($check->rowCount() > 0) {
            return "Ese correo ya está registrado por otro usuario.";
        }

        // Si la contraseña fue proporcionada, validamos y la hasheamos
        if (!empty($contrasena)) {
            if (strlen($contrasena) < 6) {
                return "La contraseña debe tener al menos 6 caracteres.";
            }
            $contrasena = password_hash($contrasena, PASSWORD_DEFAULT); // Hashear la nueva contraseña
        }

        // Armar los datos que se van a actualizar
        $datos = [
            ["campo_nombre" => "nombre_completo",    "campo_marcador" => ":Nombre",     "campo_valor" => $nombre],
            ["campo_nombre" => "correo_electronico", "campo_marcador" => ":Correo",     "campo_valor" => $correo]
        ];

        // Si se proporcionó una nueva contraseña, la añadimos a la actualización
        if (!empty($contrasena)) {
            $datos[] = ["campo_nombre" => "contrasena", "campo_marcador" => ":Clave", "campo_valor" => $contrasena];
        }

        // Preparar la consulta de actualización
        $where = "id_usuario = :IdUsuario";
        $parametros = [":IdUsuario" => $idUsuario];

        // Ejecutar la actualización
        $guardar = $this->actualizarDatos("usuarios", $datos, $where, $parametros);

        if ($guardar->rowCount() == 1) {
            return "✅ Datos actualizados con éxito.";
        } else {
            return "❌ No se pudo actualizar los datos. Intenta nuevamente.";
        }
    }
}
