<?php
use app\models\mainModel;

require_once ROOT_PATH . 'app/views/inc/session_start.php';
require_once ROOT_PATH . 'app/models/mainModel.php';

$model = new mainModel();
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: " . APP_URL . "a-view-jobs/");
    exit();
}

$stmt = $model->ejecutarConsultaParametros("SELECT * FROM empleos WHERE id_empleo = :id AND id_usuario_reclutador = :uid", [
    ":id" => $id,
    ":uid" => $_SESSION['id']
]);

$empleo = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$empleo) {
    echo "<div class='alert alert-danger'>Empleo no encontrado.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
</head>
<body>
<div class="vertical-nav">
    <img src="<?php echo APP_URL; ?>app/views/img/userImg.png" alt="Logo" />
    <div class="usuario d-flex align-items-center justify-content-center" style="gap: 8px;">
            <span><?php echo $_SESSION['nombre']; ?></span>
            <a href="<?php echo APP_URL; ?>a-edit-info/" title="Editar perfil">
                <i class="bi bi-pencil-square" style="color: white; font-size: 1.2rem;"></i>
            </a>
        </div>
        <div class="correo"><?php echo $_SESSION['correo']; ?></div>
    <hr class="horizontal-divider" />
    <a href="<?php echo APP_URL; ?>a-home/">Inicio</a>
    <a href="<?php echo APP_URL; ?>a-view-jobs/" class="active-link">Lista de empleos</a>
    <a href="<?php echo APP_URL; ?>a-student-list/">Alumnos Disponibles</a>
    <a href="<?php echo APP_URL; ?>a-chat/">Chat Alumnos</a>
    <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
</div>

<div class="main-content">
    <div class="container">
        <h2 class="mb-4">Editar Empleo</h2>

        <form method="POST" action="<?php echo APP_URL; ?>a-modify-job/">
            <input type="hidden" name="id_empleo" value="<?php echo $empleo['id_empleo']; ?>">

            <div class="mb-3">
                <label>Nombre del Puesto</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $empleo['nombre_puesto']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Área</label>
                <input type="text" class="form-control" name="area" value="<?php echo $empleo['area']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion"><?php echo $empleo['descripcion']; ?></textarea>
            </div>

            <div class="mb-3">
                <label>Requisitos</label>
                <textarea class="form-control" name="requisitos"><?php echo $empleo['requisitos']; ?></textarea>
            </div>

            <div class="mb-3">
                <label>Modalidad</label>
                <select class="form-select" name="modalidad" required>
                    <?php foreach (['Presencial', 'Remoto', 'Híbrido'] as $op): ?>
                        <option value="<?php echo $op; ?>" <?php if ($empleo['modalidad'] == $op) echo 'selected'; ?>><?php echo $op; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Ubicación</label>
                <input type="text" class="form-control" name="ubicacion" value="<?php echo $empleo['ubicacion']; ?>">
            </div>

            <div class="mb-3">
                <label>Salario</label>
                <input type="number" class="form-control" name="salario" value="<?php echo $empleo['salario']; ?>">
            </div>

            <div class="mb-3">
                <label>Estado</label>
                <select class="form-select" name="estado" required>
                    <option value="Activo" <?php if ($empleo['estado'] == 'Activo') echo 'selected'; ?>>Activo</option>
                    <option value="Inactivo" <?php if ($empleo['estado'] == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="<?php echo APP_URL; ?>a-view-jobs/" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
</body>
