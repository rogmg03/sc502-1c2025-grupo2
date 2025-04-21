<?php
require_once __DIR__ . '/../../../config/app.php';
require_once __DIR__ . '/../../../app/models/mainModel.php';
require_once __DIR__ . '/../../../app/controllers/perfilEstudianteController.php';

require_once __DIR__ . '/../../dompdf/autoload.inc.php';

use app\controllers\perfilEstudianteController;

$controller = new perfilEstudianteController();

$idEstudiante = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$perfil = $controller->obtenerPerfilCompleto($idEstudiante);

if (!$perfil) {
    echo "<div class='alert alert-danger m-5'>ID inválido o el estudiante no tiene un CV activo.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil del Estudiante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<div class="main-content p-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Perfil de <?php echo htmlspecialchars($perfil['info_personal']['nombre']); ?></h2>
        <a href="<?php echo APP_URL; ?>app/views/content/plantilla-pdf-cv.php?id=<?php echo $idEstudiante; ?>" class="btn btn-outline-dark" target="_blank">
            <i class="bi bi-download me-1"></i> Exportar a PDF
        </a>
    </div>
    <hr>

    <h5 class="text-primary">Información Personal</h5>
    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Nombre:</strong> <?php echo $perfil['info_personal']['nombre']; ?></li>
        <li class="list-group-item"><strong>Carrera:</strong> <?php echo $perfil['info_personal']['estudiante_de']; ?></li>
        <li class="list-group-item"><strong>Ubicación:</strong> <?php echo $perfil['info_personal']['direccion']; ?></li>
        <li class="list-group-item"><strong>Correo:</strong> <?php echo $perfil['info_personal']['email']; ?></li>
    </ul>

    <h5 class="text-primary">Experiencia Laboral</h5>
    <?php if (count($perfil['experiencia']) > 0): ?>
        <ul class="list-group mb-4">
            <?php foreach ($perfil['experiencia'] as $exp): ?>
                <li class="list-group-item">
                    <strong><?php echo $exp['cargo']; ?></strong> en <?php echo $exp['empresa']; ?> <br>
                    <?php echo $exp['fecha_inicio']; ?> - <?php echo $exp['fecha_finalizacion']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">No hay experiencia registrada.</p>
    <?php endif; ?>

    <h5 class="text-primary">Formación Académica</h5>
    <?php if (count($perfil['formacion']) > 0): ?>
        <ul class="list-group mb-4">
            <?php foreach ($perfil['formacion'] as $form): ?>
                <li class="list-group-item">
                    <strong><?php echo $form['institucion']; ?></strong> en <?php echo $form['titulo_obtenido']; ?> <br>
                    <?php echo $form['fecha_inicio']; ?> - <?php echo $form['fecha_finalizacion']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">No hay formación académica registrada.</p>
    <?php endif; ?>

    <h5 class="text-primary">Certificaciones</h5>
    <?php if (count($perfil['certificaciones']) > 0): ?>
        <ul class="list-group mb-4">
            <?php foreach ($perfil['certificaciones'] as $cert): ?>
                <li class="list-group-item">
                    <strong><?php echo $cert['nombre']; ?></strong> - <?php echo $cert['empresa_emisora']; ?> <br>
                    <?php echo $cert['fecha_expedicion']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">No hay certificaciones registradas.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
