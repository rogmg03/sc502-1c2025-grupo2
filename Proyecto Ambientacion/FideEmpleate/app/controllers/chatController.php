<?php
namespace app\controllers;

use app\models\mainModel;
use PDO;

class chatController extends mainModel {

    public function obtenerConversaciones($idUsuario) {
        $sql = "
            SELECT
                c.id_conversacion,
                CASE
                    WHEN c.usuario1_id = :id THEN c.usuario2_id
                    ELSE c.usuario1_id
                END AS id_contacto,
                u.nombre_completo AS nombre_contacto,
                m.contenido AS ultimo_mensaje,
                m.fecha_envio
            FROM conversaciones c
            INNER JOIN usuarios u ON u.id_usuario = 
                CASE
                    WHEN c.usuario1_id = :id THEN c.usuario2_id
                    ELSE c.usuario1_id
                END
            LEFT JOIN (
                SELECT id_conversacion, MAX(id_mensaje) as max_id
                FROM mensajes
                GROUP BY id_conversacion
            ) ultimos ON ultimos.id_conversacion = c.id_conversacion
            LEFT JOIN mensajes m ON m.id_mensaje = ultimos.max_id
            WHERE c.usuario1_id = :id OR c.usuario2_id = :id
            ORDER BY m.fecha_envio DESC
        ";
        $stmt = $this->ejecutarConsultaParametros($sql, [':id' => $idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMensajesConversacion($idUsuario1, $idUsuario2) {
        $sql = "
            SELECT m.* FROM mensajes m
            INNER JOIN conversaciones c ON m.id_conversacion = c.id_conversacion
            WHERE 
                ((c.usuario1_id = :id1 AND c.usuario2_id = :id2) OR 
                (c.usuario1_id = :id2 AND c.usuario2_id = :id1))
            ORDER BY m.fecha_envio ASC
        ";
        $stmt = $this->ejecutarConsultaParametros($sql, [
            ':id1' => $idUsuario1,
            ':id2' => $idUsuario2
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerOCrearConversacion($id1, $id2) {
        $db = $this->conectar();
        $menor = min($id1, $id2);
        $mayor = max($id1, $id2);

        $stmt = $db->prepare("SELECT id_conversacion FROM conversaciones 
                              WHERE usuario1_id = :menor AND usuario2_id = :mayor");
        $stmt->execute([':menor' => $menor, ':mayor' => $mayor]);

        $conv = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($conv) return $conv['id_conversacion'];

        $stmt = $db->prepare("INSERT INTO conversaciones (usuario1_id, usuario2_id) VALUES (:menor, :mayor)");
        $stmt->execute([':menor' => $menor, ':mayor' => $mayor]);

        return $db->lastInsertId();
    }

    public function guardarMensaje($idConversacion, $idEmisor, $contenido) {
        $db = $this->conectar();
        $stmt = $db->prepare("INSERT INTO mensajes (id_conversacion, id_usuario_emisor, contenido) 
                              VALUES (:conv, :emisor, :contenido)");
        return $stmt->execute([
            ':conv' => $idConversacion,
            ':emisor' => $idEmisor,
            ':contenido' => $contenido
        ]);
    }
}
