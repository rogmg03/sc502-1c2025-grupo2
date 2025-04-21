<?php
require_once '../models/mainModel.php';

use app\models\mainModel;

$model = new mainModel();

$q = $_GET['q'] ?? '';
$q = trim($q);

if (strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT id_usuario, nombre_completo, correo_electronico 
    FROM usuarios 
    WHERE (nombre_completo LIKE :busqueda OR correo_electronico LIKE :busqueda)
    AND rol = 'estudiante'
    LIMIT 10
";

$stmt = $model->ejecutarConsultaParametros($sql, [':busqueda' => "%$q%"]);
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($resultado);
