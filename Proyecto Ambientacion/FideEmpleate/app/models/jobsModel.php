<?php
class empleosModel {

    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerEmpleosPorReclutador($idReclutador) {
        $sql = "SELECT id_empleo, nombre_puesto, area, descripcion, requisitos, modalidad, ubicacion, salario, fecha_publicacion, estado 
                FROM empleos 
                WHERE id_usuario_reclutador = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $idReclutador, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function eliminarEmpleo($idEmpleo, $idReclutador) {
        $sql = "DELETE FROM empleos WHERE id_empleo = :id_empleo AND id_usuario_reclutador = :id_reclutador";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_empleo', $idEmpleo, PDO::PARAM_INT);
        $stmt->bindValue(':id_reclutador', $idReclutador, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

