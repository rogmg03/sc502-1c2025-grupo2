<?php
require_once __DIR__ . '../../inc/session_start.php';

require_once __DIR__ . '../../../controllers/postulacionesController.php';
require_once __DIR__ . '/../../../config/server.php';

use app\controllers\postulacionesController;

$controlador = new postulacionesController();
$id_estudiante = $_SESSION['id'] ?? null;

// Obtener postulaciones activas del estudiante
$postulaciones = $controlador->obtenerPostulacionesPorEstudiante($id_estudiante);

// Cancelar postulación si se envió por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_postulacion'])) {
    $id_postulacion = $controlador->limpiarCadena($_POST['id_postulacion']);
    $cancelada = $controlador->cancelarPostulacion($id_postulacion, $id_estudiante);
    $mensaje = $cancelada ? "Postulación cancelada exitosamente." : "No se pudo cancelar la postulación.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Postulaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>
    <div class="vertical-nav">
        <img src="../app/views/img/userImg.png" style="height: 150px; width: 150px" alt="Logo">
        <div class="usuario d-flex align-items-center justify-content-center" style="gap: 8px;">
            <span><?php echo $_SESSION['nombre']; ?></span>
            <a href="<?php echo APP_URL; ?>s-edit-info/" title="Editar perfil">
                <i class="bi bi-pencil-square" style="color: white; font-size: 1.2rem;"></i>
            </a>
        </div>
        <div class="correo"><?php echo $_SESSION['correo']; ?></div>
        <hr class="horizontal-divider">
        <a href="<?php echo APP_URL; ?>s-home/">Inicio</a>
        <a href="<?php echo APP_URL; ?>s-view-cv/">Mis Curriculums</a>
        <a href="<?php echo APP_URL; ?>s-view-jobs/">Empleos Disponibles</a>
        <a href="<?php echo APP_URL; ?>s-my-applications/" class="link-activo">Mis Postulaciones</a>
        <a href="<?php echo APP_URL; ?>s-chat/">Chat</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h2>Mis Postulaciones</h2>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Puesto</th>
                    <th>Modalidad</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($postulaciones) > 0): ?>
                    <?php foreach ($postulaciones as $p): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p['nombre_puesto']); ?></td>
                            <td><?php echo htmlspecialchars($p['modalidad']); ?></td>
                            <td><?php echo htmlspecialchars($p['ubicacion']); ?></td>
                            <td>
                                <span class="badge <?php echo $p['estado'] === 'Postulado' ? 'bg-primary' : 'bg-warning'; ?>">
                                    <?php echo $p['estado']; ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalPostulacion"
                                    data-id="<?php echo $p['id_postulacion']; ?>"
                                    data-nombre="<?php echo htmlspecialchars($p['nombre_puesto']); ?>"
                                    data-area="<?php echo htmlspecialchars($p['area']); ?>"
                                    data-salario="<?php echo htmlspecialchars($p['salario']); ?>"
                                    data-fecha="<?php echo htmlspecialchars($p['fecha_postulacion']); ?>"
                                    data-estado="<?php echo $p['estado']; ?>">
                                    Administrar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No has aplicado a ningún empleo.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalPostulacion" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tituloModal">Detalle de la Postulación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Puesto:</strong> <span id="detallePuesto"></span></p>
                    <p><strong>Salario:</strong> <span id="detalleSalario"></span></p>
                    <p><strong>Fecha de postulación:</strong> <span id="detalleFecha"></span></p>
                    <p><strong>Estado:</strong> <span id="detalleEstado"></span></p>
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" id="idPostulacionInput" name="id_postulacion">
                        <button type="submit" class="btn btn-danger">Cancelar Postulación</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalPostulacion');
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('detallePuesto').textContent = button.getAttribute('data-nombre');
            document.getElementById('detalleSalario').textContent = '₡' + button.getAttribute('data-salario');
            document.getElementById('detalleFecha').textContent = button.getAttribute('data-fecha');
            document.getElementById('detalleEstado').textContent = button.getAttribute('data-estado');
            document.getElementById('idPostulacionInput').value = button.getAttribute('data-id');
        });

        <?php if (isset($mensaje)): ?>
            Swal.fire({
                icon: '<?php echo strpos($mensaje, "exitosamente") !== false ? "success" : "error"; ?>',
                title: '<?php echo $mensaje; ?>',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = '<?php echo APP_URL; ?>s-my-applications/';
            });
        <?php endif; ?>
    </script>
</body>

</html>