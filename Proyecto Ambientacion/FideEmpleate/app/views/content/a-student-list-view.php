<?php
require_once ROOT_PATH . 'app/views/inc/session_start.php';
require_once ROOT_PATH . 'app/models/mainModel.php';
require_once ROOT_PATH . 'app/models/studentsModel.php';

use app\models\studentsModel;

$modeloEstudiantes = new studentsModel();
$estudiantes = $modeloEstudiantes->obtenerEstudiantesDisponibles();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Alumnos Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <a href="<?php echo APP_URL; ?>a-view-jobs/">Lista de empleos</a>
        <a href="<?php echo APP_URL; ?>a-student-list/" class="link-activo">Alumnos Disponibles</a>
        <a href="<?php echo APP_URL; ?>a-postings/">Postulaciones</a>
        <a href="<?php echo APP_URL; ?>a-chat/">Chat Alumnos</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h2>Alumnos Disponibles</h2>
        <div class="student-list">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Lista de Alumnos Disponibles
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered align-middle">
                        <thead >
                            <tr>
                                <th>Nombre</th>
                                <th>Carrera</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($estudiantes)): ?>
                                <?php foreach ($estudiantes as $est): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($est['nombre_completo']); ?></td>
                                        <td><?php echo htmlspecialchars($est['estudiante_de']); ?></td>
                                        <td><?php echo htmlspecialchars($est['telefono']); ?></td>
                                        <td><?php echo htmlspecialchars($est['email']); ?></td>
                                        <td><?php echo htmlspecialchars($est['direccion']); ?></td>
                                        <td>
                                            <a href="<?php echo APP_URL; ?>s-profile/<?php echo $est['id_usuario']; ?>/"
                                                class="btn btn-primary btn-sm">Ver Perfil</a>
                                            <a href="<?php echo APP_URL; ?>a-chat/?id=<?php echo $est['id_usuario']; ?>"
                                                class="btn btn-success btn-sm">Contactar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay estudiantes registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
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

</body>

</html>