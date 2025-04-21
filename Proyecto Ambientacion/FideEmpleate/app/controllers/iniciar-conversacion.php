<?php
namespace app\controllers;

use app\models\mainModel;

class iniciarConversacion extends mainModel {
    public function procesarConversacion($id_estudiante) {
        $id_agente = $_SESSION['id'];

        // Siempre ordenar los IDs igual para que la combinación sea única
        $u1 = min($id_agente, $id_estudiante);
        $u2 = max($id_agente, $id_estudiante);

        $sql = "SELECT id_conversacion FROM conversaciones WHERE usuario1_id = :u1 AND usuario2_id = :u2";
        $stmt = $this->ejecutarConsultaParametros($sql, [':u1' => $u1, ':u2' => $u2]);

        $conversacion = $stmt->fetch();
        if (!$conversacion) {
            $this->ejecutarConsultaParametros(
                "INSERT INTO conversaciones (usuario1_id, usuario2_id) VALUES (:u1, :u2)",
                [':u1' => $u1, ':u2' => $u2]
            );
            $id = $this->conectar()->lastInsertId();
        } else {
            $id = $conversacion['id_conversacion'];
        }

        header("Location: " . APP_URL . "a-chat/?id=" . $id);
        exit();
    }
}

if (isset($_GET['id'])) {
    $ctrl = new iniciarConversacion();
    $ctrl->procesarConversacion($_GET['id']);
}
