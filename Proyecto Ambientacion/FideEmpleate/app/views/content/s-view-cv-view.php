<?php
use app\controllers\cvController;
$cvController = new cvController();
$cvController->manejarAcciones(); // Procesar acciones si vienen desde POST

$id_usuario = $_SESSION['id'] ?? null;
$curriculums = [];

if ($id_usuario) {
    $curriculums = $cvController->obtenerCurriculumsUsuario($id_usuario);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Curriculums Agregados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../app/views/css/styles.css">
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
   </head>
<body>
<div class="vertical-nav">
    <img src="<?php echo APP_URL; ?>app/views/img/userImg.png" alt="Logo" />
    <div class="usuario"><?php echo $_SESSION['nombre']; ?></div>
    <div class="correo"><?php echo $_SESSION['correo']; ?></div>
    <hr class="horizontal-divider" />
    <a href="<?php echo APP_URL; ?>s-home/">Inicio</a>
	<a href="<?php echo APP_URL; ?>s-view-cv/" class="link-activo">Mis Curriculums</a>
    <a href="<?php echo APP_URL; ?>s-view-jobs/">Empleos Disponibles</a>
    <a href="<?php echo APP_URL; ?>s-my-applications/">Mis Postulaciones</a>
	<a href="<?php echo APP_URL; ?>s-chat/">Chat</a>
    <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
</div>
    <div class="main-content">
        <h2>Curriculums Agregados</h2>
        <a href="<?php echo APP_URL; ?>s-add-cv/" class="btn btn-dark btn-sm py-1" id="agregarCurriculum">Agregar
            Curriculum</a>

        <div class="job-list mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Lista de Curriculums
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($curriculums)): ?>
                                <?php foreach ($curriculums as $cv): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cv['titulo']) ?></td>
                                        <td>
                                            <?php if ($cv['estado'] === 'Activo'): ?>
                                                <span class="badge bg-success rounded-pill">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning rounded-pill">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= APP_URL ?>s-view-my-cv/<?= $cv['id_cv'] ?>"
                                                class="btn btn-primary btn-sm">Ver</a>
                                            <a href="<?= APP_URL ?>s-edit-cv/<?= $cv['id_cv'] ?>"
                                                class="btn btn-secondary btn-sm">Editar</a>

                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmarEliminacion(<?= $cv['id_cv'] ?>)">Eliminar</button>

                                            <form method="POST" action="" style="display:inline-block;">
                                                <input type="hidden" name="id_cv" value="<?= $cv['id_cv'] ?>">
                                                <input type="hidden" name="accion" value="activar">
                                                <button type="submit" class="btn btn-secondary btn-sm">Activar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No se han encontrado currículums.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

    <!-- Formulario oculto para eliminación -->
    <form id="formEliminarCV" method="POST" style="display:none;">
        <input type="hidden" name="id_cv" id="inputEliminarCV">
        <input type="hidden" name="accion" value="eliminar">
    </form>

    <script>
        function confirmarEliminacion(id_cv) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará el currículum permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('inputEliminarCV').value = id_cv;
                    document.getElementById('formEliminarCV').submit();
                }
            });
        }
    </script>

</body>

</html>