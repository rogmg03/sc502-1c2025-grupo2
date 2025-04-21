<?php
class empleosModel {

    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    //Vista de empleos por id de reclutador
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

    //Vista de empleos activos desde el panel de usuario.
    public function obtenerEmpleosActivos($filtro = '') {
        $sql = "SELECT * FROM empleos WHERE estado = 'Activo'";
    
        if (!empty($filtro)) {
            $sql .= " AND (nombre_puesto LIKE :filtro OR area LIKE :filtro)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':filtro', "%$filtro%");
        } else {
            $stmt = $this->db->prepare($sql);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerEmpleosDisponiblesNoPostulados($id_estudiante, $filtro = '') {
        $sql = "
            SELECT e.*
            FROM empleos e
            WHERE e.estado = 'Activo'
              AND e.id_empleo NOT IN (
                  SELECT p.id_empleo
                  FROM postulaciones p
                  WHERE p.id_usuario_estudiante = :estudiante
              )
        ";
    
        // Aplicar filtro si se especifica
        if (!empty($filtro)) {
            $sql .= " AND (e.nombre_puesto LIKE :filtro OR e.area LIKE :filtro)";
        }
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':estudiante', $id_estudiante, PDO::PARAM_INT);
    
        if (!empty($filtro)) {
            $like = '%' . $filtro . '%';
            $stmt->bindValue(':filtro', $like, PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}

