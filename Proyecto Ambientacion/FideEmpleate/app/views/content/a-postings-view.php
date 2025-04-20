<?php
use app\controllers\postulacionesController;
$model = new postulacionesController();
$reclutador = $_SESSION['id'];

$postulaciones = $model->obtenerPostulacionesAsignadas($reclutador);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Postulaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="vertical-nav">
    <img src="../app/views/img/userImg.png" alt="Logo" />
    <div class="usuario d-flex align-items-center justify-content-center" style="gap: 8px;">
        <span><?php echo $_SESSION['nombre']; ?></span>
        <a href="<?php echo APP_URL; ?>a-edit-info/" title="Editar perfil">
            <i class="bi bi-pencil-square" style="color: white; font-size: 1.2rem;"></i>
        </a>
    </div>
    <div class="correo"><?php echo $_SESSION['correo']; ?></div>
    <hr class="horizontal-divider" />
    <a href="<?php echo APP_URL; ?>a-home/">Inicio</a>
    <a href="<?php echo APP_URL; ?>a-view-jobs/">Lista de empleos</a>
    <a href="<?php echo APP_URL; ?>a-student-list/">Alumnos Disponibles</a>
    <a href="<?php echo APP_URL; ?>a-postings/" class="link-activo">Postulaciones</a>
    <a href="<?php echo APP_URL; ?>a-chat/">Chat Alumnos</a>
    <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
</div>

<div class="main-content">
    <h2>Postulaciones Recibidas</h2>
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Puesto</th>
                <th>Fecha</th>
                <th>Progreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($postulaciones as $p): ?>
                <?php
                    $porcentaje = match($p['estado']) {
                        "Postulado" => 33,
                        "En Proceso" => 66,
                        "Seleccionado", "Rechazado" => 100
                    };
                    $color = match($p['estado']) {
                        "Postulado" => "info",
                        "En Proceso" => "warning",
                        "Seleccionado" => "success",
                        "Rechazado" => "danger"
                    };
                ?>
                <tr>
                    <td><?= htmlspecialchars($p['nombre_completo']) ?></td>
                    <td><?= htmlspecialchars($p['nombre_puesto']) ?></td>
                    <td><?= date('d/m/Y', strtotime($p['fecha_postulacion'])) ?></td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-<?= $color ?>"
                                 role="progressbar" style="width: <?= $porcentaje ?>%">
                                 <?= $p['estado'] ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="<?= APP_URL ?>s-profile/<?= $p['id_estudiante'] ?>/" class="btn btn-primary btn-sm">Ver</a>
                        <button class="btn btn-success btn-sm" onclick="abrirModal(<?= $p['id_postulacion'] ?>, 'Seleccionado')">Seleccionar</button>
                        <button class="btn btn-danger btn-sm" onclick="abrirModal(<?= $p['id_postulacion'] ?>, 'Rechazado')">Rechazar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Observaciones -->
<div class="modal fade" id="modalObservacion" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="<?= APP_URL ?>a-postings/actualizar">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Observación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_postulacion" id="modal_id_postulacion">
                <input type="hidden" name="nuevo_estado" id="modal_estado">
                <div class="mb-3">
                    <label for="observacion" class="form-label">Observación</label>
                    <textarea class="form-control" name="observacion" id="modal_observacion" rows="3" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function abrirModal(id, estado) {
    document.getElementById('modal_id_postulacion').value = id;
    document.getElementById('modal_estado').value = estado;
    document.getElementById('modal_observacion').value = '';
    new bootstrap.Modal(document.getElementById('modalObservacion')).show();
}

<?php if (isset($_SESSION['postulacion_actualizada'])): ?>
Swal.fire({
    title: 'Actualizado',
    text: '<?= $_SESSION['postulacion_actualizada'] ?>',
    icon: 'success',
    confirmButtonText: 'OK'
});
<?php unset($_SESSION['postulacion_actualizada']); endif; ?>
</script>

</body>
</html>
