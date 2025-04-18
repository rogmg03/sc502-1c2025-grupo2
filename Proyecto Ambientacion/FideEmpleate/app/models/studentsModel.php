<?php
namespace app\models;

use PDO;

class studentsModel extends mainModel {

    public function obtenerEstudiantesDisponibles() {
        $sql = "
            SELECT 
                u.id_usuario,
                u.nombre_completo,
                ip.estudiante_de,
                ip.direccion,
                ip.telefono,
                ip.email
            FROM usuarios u
            INNER JOIN informacion_personal ip ON u.id_usuario = ip.id_usuario
            WHERE u.rol = 'Estudiante'
        ";

        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
