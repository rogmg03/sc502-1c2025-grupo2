<?php
use app\models\mainModel;
$model = new mainModel();

$idEstudiante = $_SESSION['id'];

$totalEmpleos = $model->ejecutarConsulta("SELECT COUNT(*) AS total FROM empleos")->fetch()['total'];

$totalPostulaciones = $model->ejecutarConsulta("SELECT COUNT(*) AS total FROM postulaciones WHERE id_usuario_estudiante = $idEstudiante")->fetch()['total'];

$sql = "
    SELECT c.id_cv, ip.*
    FROM cv c
    INNER JOIN informacion_personal ip ON c.id_informacion_personal = ip.id_personal
    WHERE c.id_usuario = $idEstudiante AND c.activo = 1
    LIMIT 1
";
$cvActivo = $model->ejecutarConsulta($sql)->fetch(PDO::FETCH_ASSOC);

// 4. Gráfico de empleos más requeridos
$sqlGrafico = "
    SELECT nombre_puesto, COUNT(*) as cantidad 
    FROM empleos 
    GROUP BY nombre_puesto
";
$datosGrafico = $model->ejecutarConsulta($sqlGrafico)->fetchAll(PDO::FETCH_ASSOC);
$labels = json_encode(array_column($datosGrafico, 'nombre_puesto'));
$valores = json_encode(array_column($datosGrafico, 'cantidad'));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio - Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <a href="<?php echo APP_URL; ?>s-home/" class="link-activo">Inicio</a>
	<a href="<?php echo APP_URL; ?>s-view-cv/">Mis Curriculums</a>
    <a href="<?php echo APP_URL; ?>s-view-jobs/">Empleos Disponibles</a>
    <a href="<?php echo APP_URL; ?>s-my-applications/">Mis Postulaciones</a>
	<a href="<?php echo APP_URL; ?>s-chat/">Chat</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h2>Inicio</h2>
        <div class="container mt-4">
            <div class="row gap-4">
                <!-- CV Activo -->
                <div class="col-md-6">
                    <div class="card-shadow border rounded p-3">
                        <h5>Curriculum Activo</h5>
                        <?php if ($cvActivo): ?>
                            <div class="row align-items-center">
                                <div class="col-md-6 text-center">
                                    <img src="../app/views/img/user.png"
                                        style="margin-top: 20px; height: 180px; border-radius: 100%; box-shadow: 2px 2px 6px rgba(0,0,0,0.2);" />
                                </div>
                                <div class="col-md-6 text-center">
                                    <h5><?php echo $_SESSION['nombre']; ?></h5>
                                    <p class="fw-semibold">Estudiante de <?php echo $cvActivo['estudiante_de']; ?></p>
                                    <p><?php echo $cvActivo['direccion']; ?></p>
                                    <a href="<?php echo APP_URL; ?>s-view-cv/" class="btn btn-primary">Ver Curriculum</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <img src="../app/views/img/warning.png" alt="Warning" style="height: 60px;">
                                <h6 class="mt-3 text-danger">¡Importante!</h6>
                                <p class="text-muted">Sección de CV activo. Agregue un curriculum para continuar.</p>
                                <p><strong>Debe registrar un CV para ser visto por los agentes reclutadores.</strong></p>
                                <a href="<?php echo APP_URL; ?>s-add-cv/" class="btn btn-warning text-dark fw-bold">Agregar
                                    CV</a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Métricas -->
                    <div class="card-shadow border rounded p-3 text-center mt-4">
                        <h5>Empleos Aplicados</h5>
                        <p class="fs-4 fw-bold"><?php echo $totalPostulaciones; ?></p>
                    </div>
                    <div class="card-shadow border rounded p-3 text-center mt-3">
                        <h5>Total de Empleos Disponibles</h5>
                        <p class="fs-4 fw-bold"><?php echo $totalEmpleos; ?></p>
                    </div>
                </div>

                <!-- Gráfico -->
                <div class="col-md-5 card-shadow border rounded p-3">
                    <h5 class="text-center mb-3">Empleos más requeridos</h5>
                    <canvas id="graficoPie"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('graficoPie').getContext('2d');
        const grafico = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo $labels; ?>,
                datasets: [{
                    label: 'Cantidad de empleos',
                    data: <?php echo $valores; ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>

</html>