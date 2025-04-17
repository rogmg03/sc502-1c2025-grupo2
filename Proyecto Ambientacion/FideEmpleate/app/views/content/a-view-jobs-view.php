<?php
use app\models\mainModel;

require_once ROOT_PATH . 'config/server.php';
require_once ROOT_PATH . 'app/models/jobsModel.php';
require_once ROOT_PATH . 'app/models/mainModel.php';
require_once ROOT_PATH . 'app/views/inc/session_start.php';

$model = new mainModel();
$conn = $model->conectar();

$empleoModel = new empleosModel($conn);
$idReclutador = $_SESSION['id'] ?? 1;


if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $empleoModel->eliminarEmpleo($_GET['eliminar'], $idReclutador);
    header("Location: a-view-jobs-view.php");
    exit();
}

$empleosPDO = $empleoModel->obtenerEmpleosPorReclutador($idReclutador);
$empleos = $empleosPDO->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Empleos agregados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
</head>

<body>

    <div class="vertical-nav">
        <img src="../app/views/img/userImg.png" alt="Logo" />
        <div class="usuario"><?php echo $_SESSION['nombre']; ?></div>
        <div class="correo"><?php echo $_SESSION['correo']; ?></div>
        <hr class="horizontal-divider" />
        <a href="<?php echo APP_URL; ?>a-home/" class="link-activo">Inicio</a>
        <a href="<?php echo APP_URL; ?>a-view-jobs/">Lista de empleos</a>
        <a href="<?php echo APP_URL; ?>a-student-list/">Alumnos Disponibles</a>
        <a href="<?php echo APP_URL; ?>a-chat/">Chat Alumnos</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h2>Empleos Agregados</h2>
        <a href="<?php echo APP_URL; ?>a-add-job/" class="btn btn-dark btn-sm py-1 mb-3">Agregar Empleo</a>
        <div class="job-list">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Lista de Empleos Publicados
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Área</th>
                                <th>Modalidad</th>
                                <th>Ubicación</th>
                                <th>Salario</th>
                                <th>Publicación</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($empleos) > 0): ?>
                                <?php foreach ($empleos as $empleo): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($empleo['nombre_puesto']); ?></td>
                                        <td><?php echo htmlspecialchars($empleo['area']); ?></td>
                                        <td><?php echo htmlspecialchars($empleo['modalidad']); ?></td>
                                        <td><?php echo htmlspecialchars($empleo['ubicacion']); ?></td>
                                        <td>₡<?php echo number_format($empleo['salario'], 0, ',', '.'); ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($empleo['fecha_publicacion'])); ?></td>
                                        <td>
                                            <?php if ($empleo['estado'] == 'Activo'): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>

                                            <button class="btn btn-primary btn-sm ver-empleo-btn" data-bs-toggle="modal"
                                                data-bs-target="#modalDetalleEmpleo"
                                                data-nombre="<?php echo htmlspecialchars($empleo['nombre_puesto']); ?>"
                                                data-descripcion="<?php echo htmlspecialchars($empleo['descripcion']); ?>"
                                                data-estado="<?php echo htmlspecialchars($empleo['estado']); ?>"
                                                data-modalidad="<?php echo htmlspecialchars($empleo['modalidad']); ?>"
                                                data-ubicacion="<?php echo htmlspecialchars($empleo['ubicacion']); ?>"
                                                data-salario="<?php echo number_format($empleo['salario'], 0, ',', '.'); ?>">
                                                Ver
                                            </button>

                                            <a href="<?php echo APP_URL . 'a-edit-job/?id=' . $empleo['id_empleo']; ?>"
                                                class="btn btn-secondary btn-sm">Editar</a>
                                            <a href="<?php echo APP_URL . 'a-delete-job/?id=' . $empleo['id_empleo']; ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Deseas eliminar este empleo? Esta acción no se puede deshacer.')">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No hay empleos registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalle de Empleo -->
    <div class="modal fade" id="modalDetalleEmpleo" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tituloModal">Detalle del Empleo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> <span id="modalNombre"></span></p>
                    <p><strong>Descripción:</strong></p>
                    <p id="modalDescripcion"></p>
                    <p><strong>Estado:</strong> <span id="modalEstado"></span></p>
                    <p><strong>Modalidad:</strong> <span id="modalModalidad"></span></p>
                    <p><strong>Ubicación:</strong> <span id="modalUbicacion"></span></p>
                    <p><strong>Salario:</strong> <span id="modalSalario"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modalEmpleo = document.getElementById('modalDetalleEmpleo');
        modalEmpleo.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const nombre = button.getAttribute('data-nombre');
            const descripcion = button.getAttribute('data-descripcion');
            const estado = button.getAttribute('data-estado');

            document.getElementById('modalNombre').textContent = nombre;
            document.getElementById('modalDescripcion').textContent = descripcion;
            document.getElementById('modalEstado').textContent = estado;
            document.getElementById('modalModalidad').textContent = button.getAttribute('data-modalidad');
            document.getElementById('modalUbicacion').textContent = button.getAttribute('data-ubicacion');
            document.getElementById('modalSalario').textContent = "₡" + button.getAttribute('data-salario');

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>