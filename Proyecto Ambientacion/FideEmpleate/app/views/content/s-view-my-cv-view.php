



<?php
use app\controllers\perfilEstudianteController;



require_once __DIR__ . '/../../../config/app.php';

$controller = new perfilEstudianteController();
$idEstudiante = $_SESSION['id'] ?? null;

$cv = $controller->obtenerPerfilCompleto($idEstudiante);

if (!$cv) {
    echo "<div class='alert alert-warning m-4'>No tienes un currículum activo registrado.</div>";
    exit;
}

$info = $cv['info_personal'];
$experiencia = $cv['experiencia'];
$formacion = $cv['formacion'];
$certificaciones = $cv['certificaciones'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Currículum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
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
	<a href="<?php echo APP_URL; ?>s-view-cv/" class="link-activo">Mis Curriculums</a>
    <a href="<?php echo APP_URL; ?>s-view-jobs/">Empleos Disponibles</a>
    <a href="<?php echo APP_URL; ?>s-my-applications/">Mis Postulaciones</a>
	<a href="<?php echo APP_URL; ?>s-chat/">Chat</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

<div class="main-content">
    <div class="container">
        <h2 class="mb-4">Mi Currículum</h2>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Información Personal</div>
            <div class="card-body">
                <p><strong>Nombre:</strong> <?= htmlspecialchars($info['nombre'] . ' ' . $info['apellidos']) ?></p>
                <p><strong>Cédula:</strong> <?= htmlspecialchars($info['cedula']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($info['email']) ?></p>
                <p><strong>Teléfono:</strong> <?= htmlspecialchars($info['telefono']) ?></p>
                <p><strong>Dirección:</strong> <?= htmlspecialchars($info['direccion']) ?></p>
                <p><strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($info['fecha_nacimiento']) ?></p>
                <p><strong>Estudiante de:</strong> <?= htmlspecialchars($info['estudiante_de']) ?></p>
                <p><strong>Sobre mí:</strong> <?= nl2br(htmlspecialchars($info['sobre_mi'])) ?></p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">Experiencia Laboral</div>
            <div class="card-body">
                <?php if (count($experiencia) > 0): ?>
                    <?php foreach ($experiencia as $exp): ?>
                        <div class="mb-3 border-bottom pb-2">
                            <p><strong><?= $exp['cargo'] ?></strong> en <?= $exp['empresa'] ?></p>
                            <p><?= $exp['fecha_inicio'] ?> - <?= $exp['fecha_finalizacion'] ?: 'Actualidad' ?></p>
                            <p><strong>Ubicación:</strong> <?= $exp['ubicacion'] ?> | <strong>Modalidad:</strong> <?= $exp['modalidad'] ?></p>
                            <p><?= nl2br(htmlspecialchars($exp['descripcion'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No se ha agregado experiencia laboral.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">Formación Académica</div>
            <div class="card-body">
                <?php if (count($formacion) > 0): ?>
                    <?php foreach ($formacion as $f): ?>
                        <div class="mb-3 border-bottom pb-2">
                            <p><strong><?= $f['titulo_obtenido'] ?></strong> en <?= $f['institucion'] ?></p>
                            <p><?= $f['fecha_inicio'] ?> - <?= $f['fecha_finalizacion'] ?: 'En curso' ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No se ha agregado formación académica.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-info text-white">Certificaciones</div>
            <div class="card-body">
                <?php if (count($certificaciones) > 0): ?>
                    <?php foreach ($certificaciones as $c): ?>
                        <div class="mb-3 border-bottom pb-2">
                            <p><strong><?= $c['nombre'] ?></strong> emitido por <?= $c['empresa_emisora'] ?></p>
                            <p><?= $c['fecha_expedicion'] ?> - <?= $c['fecha_caducidad'] ?: 'Sin caducidad' ?></p>
                            <?php if (!empty($c['url_credencial'])): ?>
                                <p><a href="<?= $c['url_credencial'] ?>" target="_blank">Ver credencial</a></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No se han agregado certificaciones.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
