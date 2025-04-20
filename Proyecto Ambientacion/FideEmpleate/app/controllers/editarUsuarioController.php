<?php
namespace app\controllers;

use app\models\mainModel;
use PDO;

class editarUsuarioController extends mainModel {

    public function obtenerDatosUsuario($id_usuario) {
        $stmt = $this->ejecutarConsultaParametros("SELECT * FROM usuarios WHERE id_usuario = :id", [
            ":id" => $id_usuario
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarUsuario($id_usuario) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $confirmar = $_POST['confirmar'] ?? '';
    
            if (!empty($contrasena) && $contrasena !== $confirmar) {
                $_SESSION['perfil_error'] = "Las contraseñas no coinciden.";
                return;
            }
    
            $datos = [
                ["campo_nombre" => "nombre_completo", "campo_marcador" => ":Nombre", "campo_valor" => $nombre],
                ["campo_nombre" => "correo_electronico", "campo_marcador" => ":Email", "campo_valor" => $email]
            ];
    
            if (!empty($contrasena)) {
                $datos[] = [
                    "campo_nombre" => "contrasena",
                    "campo_marcador" => ":Pass",
                    "campo_valor" => password_hash($contrasena, PASSWORD_DEFAULT)
                ];
            }
    
            $this->actualizarDatos("usuarios", $datos, "id_usuario = :id", [":id" => $id_usuario]);
    
            $_SESSION['perfil_actualizado'] = "Perfil actualizado exitosamente.";
            header("Location: " . APP_URL . "s-edit-info/");
            exit();
        }
    }
    
}
