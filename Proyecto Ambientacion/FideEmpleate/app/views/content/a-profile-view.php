<?php
use app\controllers\editarCVController;

require_once __DIR__ . '/../../controllers/editarCVController.php';

$idEstudiante = $_GET['id'] ?? null;

if (!$idEstudiante || !is_numeric($idEstudiante)) {
    echo "<div class='alert alert-danger'>ID inválido</div>";
    exit;
}

$cv = new editarCVController();
$datos = $cv->obtenerDatosCV($idEstudiante);

if (!$datos || !$datos['info_personal']) {
    echo "<div class='alert alert-warning'>Este estudiante no tiene un currículum activo registrado.</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
    <style>
        .seccion {
            margin-bottom: 2rem;
        }

        .seccion h5 {
            border-bottom: 2px solid #001bb3;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }

        .card-personal, .card-seccion {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 1rem;
            background-color: #f8f9fa;
        }

        .campo {
            margin-bottom: 0.3rem;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
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

<!-- CONTENIDO -->
<div class="main-content">
    <h2>Perfil del Estudiante</h2>

    <?php if ($datos): ?>
        <!-- Información Personal -->
        <div class="seccion">
            <h5>Información Personal</h5>
            <div class="card-personal">
                <p class="campo"><strong>Nombre:</strong> <?= $datos['info_personal']['nombre'] ?? '' ?> <?= $datos['info_personal']['apellidos'] ?? '' ?></p>
                <p class="campo"><strong>Cédula:</strong> <?= $datos['info_personal']['cedula'] ?? '' ?></p>
                <p class="campo"><strong>Correo:</strong> <?= $datos['info_personal']['email'] ?? '' ?></p>
                <p class="campo"><strong>Teléfono:</strong> <?= $datos['info_personal']['telefono'] ?? '' ?></p>
                <p class="campo"><strong>Dirección:</strong> <?= $datos['info_personal']['direccion'] ?? '' ?></p>
                <p class="campo"><strong>Estudiante de:</strong> <?= $datos['info_personal']['estudiante_de'] ?? '' ?></p>
                <p class="campo"><strong>Sobre mí:</strong> <?= $datos['info_personal']['sobre_mi'] ?? '' ?></p>
            </div>
        </div>

        <!-- Experiencia Laboral -->
        <div class="seccion">
            <h5>Experiencia Laboral</h5>
            <?php if (!empty($datos['experiencia'])): ?>
                <?php foreach ($datos['experiencia'] as $exp): ?>
                    <div class="card-seccion mb-3">
                        <p><strong>Cargo:</strong> <?= $exp['cargo'] ?></p>
                        <p><strong>Empresa:</strong> <?= $exp['empresa'] ?></p>
                        <p><strong>Ubicación:</strong> <?= $exp['ubicacion'] ?></p>
                        <p><strong>Modalidad:</strong> <?= $exp['modalidad'] ?></p>
                        <p><strong>Tipo de empleo:</strong> <?= $exp['tipo_empleo'] ?></p>
                        <p><strong>Desde:</strong> <?= $exp['fecha_inicio'] ?> <strong>Hasta:</strong> <?= $exp['fecha_finalizacion'] ?></p>
                        <p><strong>Descripción:</strong> <?= $exp['descripcion'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No se registró experiencia laboral.</p>
            <?php endif; ?>
        </div>

        <!-- Formación Académica -->
        <div class="seccion">
            <h5>Formación Académica</h5>
            <?php if (!empty($datos['formacion'])): ?>
                <?php foreach ($datos['formacion'] as $form): ?>
                    <div class="card-seccion mb-3">
                        <p><strong>Institución:</strong> <?= $form['institucion'] ?></p>
                        <p><strong>Título Obtenido:</strong> <?= $form['titulo_obtenido'] ?></p>
                        <p><strong>Desde:</strong> <?= $form['fecha_inicio'] ?> <strong>Hasta:</strong> <?= $form['fecha_finalizacion'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No se registró formación académica.</p>
            <?php endif; ?>
        </div>

        <!-- Certificaciones -->
        <div class="seccion">
            <h5>Certificaciones</h5>
            <?php if (!empty($datos['certificaciones'])): ?>
                <?php foreach ($datos['certificaciones'] as $cert): ?>
                    <div class="card-seccion mb-3">
                        <p><strong>Nombre:</strong> <?= $cert['nombre'] ?></p>
                        <p><strong>Empresa emisora:</strong> <?= $cert['empresa_emisora'] ?></p>
                        <p><strong>Fecha de expedición:</strong> <?= $cert['fecha_expedicion'] ?> <strong>Caducidad:</strong> <?= $cert['fecha_caducidad'] ?></p>
                        <p><strong>ID de credencial:</strong> <?= $cert['id_credencial'] ?></p>
                        <p><strong>URL:</strong> <a href="<?= $cert['url_credencial'] ?>" target="_blank"><?= $cert['url_credencial'] ?></a></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No se registraron certificaciones.</p>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <div class="alert alert-danger">No se encontró el estudiante.</div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
