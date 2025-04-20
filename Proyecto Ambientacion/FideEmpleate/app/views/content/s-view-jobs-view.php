<?php
require_once ROOT_PATH . 'app/views/inc/session_start.php';
require_once ROOT_PATH . 'app/models/mainModel.php';
require_once ROOT_PATH . 'app/models/jobsModel.php';

use app\models\mainModel;
use app\models\jobsModel;

$model = new mainModel();
$conn = $model->conectar();

$empleoModel = new empleosModel($conn);
$filtro = $_GET['q'] ?? '';
$id_estudiante = $_SESSION['id'] ?? null;

// Obtener empleos activos y excluir los que el estudiante ya ha postulado
$empleos = $empleoModel->obtenerEmpleosDisponiblesNoPostulados($id_estudiante, $filtro);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleos Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
</head>
<body>

<div class="vertical-nav">
    <img src="<?php echo APP_URL; ?>app/views/img/userImg.png" alt="Logo" />
    <div class="usuario"><?php echo $_SESSION['nombre']; ?></div>
    <div class="correo"><?php echo $_SESSION['correo']; ?></div>
    <hr class="horizontal-divider" />
    <a href="<?php echo APP_URL; ?>s-home/">Inicio</a>
	<a href="<?php echo APP_URL; ?>s-view-cv/">Mis Curriculums</a>
    <a href="<?php echo APP_URL; ?>s-view-jobs/" class="link-activo">Empleos Disponibles</a>
    <a href="<?php echo APP_URL; ?>s-my-applications/">Mis Postulaciones</a>
	<a href="<?php echo APP_URL; ?>s-chat/">Chat</a>
    <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
</div>

<div class="main-content">
    <h2>Empleos Disponibles</h2>

    <form method="GET" action="">
        <div class="input-group mb-3">
            <input type="text" name="q" class="form-control" placeholder="Buscar por puesto o área" value="<?php echo htmlspecialchars($filtro); ?>">
            <button class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <div class="job-list">
        <div class="card">
            <div class="card-header">Resultados</div>
            <div class="card-body">
                <?php if (count($empleos) > 0): ?>
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Puesto</th>
                                <th>Área</th>
                                <th>Modalidad</th>
                                <th>Ubicación</th>
                                <th>Salario</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($empleos as $e): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($e['nombre_puesto']); ?></td>
                                    <td><?php echo htmlspecialchars($e['area']); ?></td>
                                    <td><?php echo htmlspecialchars($e['modalidad']); ?></td>
                                    <td><?php echo htmlspecialchars($e['ubicacion']); ?></td>
                                    <td>₡<?php echo number_format($e['salario'], 0, ',', '.'); ?></td>
                                    <td>
                                        <a href="<?php echo APP_URL; ?>s-apply-to-job/?id=<?php echo $e['id_empleo']; ?>" class="btn btn-success btn-sm">Aplicar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">No se encontraron empleos disponibles.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

