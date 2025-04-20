<?php
use app\models\mainModel;
$model = new mainModel();

$idReclutador = $_SESSION['id'];

// Llamadas a funciones SQL
$totalEmpleos = $model->ejecutarConsulta("SELECT fn_total_empleos_publicados($idReclutador) AS total")->fetch()['total'];
$totalEstudiantes = $model->ejecutarConsulta("SELECT fn_total_estudiantes() AS total")->fetch()['total'];
$totalPostulaciones = $model->ejecutarConsulta("SELECT fn_total_postulaciones_reclutador($idReclutador) AS total")->fetch()['total'];

$model->ejecutarConsulta("CALL sp_estudiante_con_mas_experiencia()");
$result = $model->ejecutarConsulta("CALL sp_estudiante_con_mas_experiencia()");
$idEstudianteTop = $result->fetch()['id_top_estudiante'] ?? null;


// Datos por defecto
$nombreTop = "No disponible";
$estudianteDe = "Carrera no especificada";
$direccionTop = "Ubicación no registrada";

if ($idEstudianteTop) {
    $datosTop = $model->ejecutarConsulta("
    SELECT u.nombre_completo, ip.estudiante_de, ip.direccion 
    FROM usuarios u
    INNER JOIN cv c ON u.id_usuario = c.id_usuario AND c.activo = 1
    INNER JOIN informacion_personal ip ON ip.id_personal = c.id_informacion_personal
    WHERE u.id_usuario = $idEstudianteTop
    LIMIT 1
")->fetch();


    $nombreTop = $datosTop['nombre_completo'] ?? $nombreTop;
    $estudianteDe = $datosTop['estudiante_de'] ?? $estudianteDe;
    $direccionTop = $datosTop['direccion'] ?? $direccionTop;

}


// Consulta: obtener empleos del reclutador y contar postulaciones
$sql = "
    SELECT e.nombre_puesto, COUNT(p.id_postulacion) AS total_postulaciones
    FROM empleos e
    LEFT JOIN postulaciones p ON e.id_empleo = p.id_empleo
    WHERE e.id_usuario_reclutador = $idReclutador
    GROUP BY e.id_empleo
";

$resultado = $model->ejecutarConsulta($sql)->fetchAll(PDO::FETCH_ASSOC);

// Crear arrays de etiquetas y datos
$labels = [];
$datos = [];

foreach ($resultado as $fila) {
    $labels[] = $fila['nombre_puesto'];
    $datos[] = $fila['total_postulaciones'];
}

// Convertirlos en JSON para pasarlos a JavaScript
$labelsJSON = json_encode($labels);
$datosJSON = json_encode($datos);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Empleos agregados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
        <a href="<?php echo APP_URL; ?>a-home/" class="link-activo">Inicio</a>
        <a href="<?php echo APP_URL; ?>a-view-jobs/">Lista de empleos</a>
        <a href="<?php echo APP_URL; ?>a-student-list/">Alumnos Disponibles</a>
        <a href="<?php echo APP_URL; ?>a-chat/">Chat Alumnos</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h2>Inicio</h2>

        <div class="container mt-4 flex" style="align-content: space-between;">
            <div class="d-flex flex-wrap gap-3">
                <!-- Alumnos destacados -->
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded">
                    <h5>Alumno Destacado</h5>
                    <div class="row student-card">
                        <div class="col-md-5">
                            <img src="../app/views/img/user.png"
                                style="margin-top: 20px; height: 200px; border-radius: 100%; box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.1);" />
                        </div>
                        <div class="col-md-6 text-center">
                            <h5><?php echo $nombreTop; ?></h5>
                            <br />
                            <p style="font-weight: 500;">Estudiante de <?php echo $estudianteDe; ?></p>
                            <p>
                                <?php echo $direccionTop; ?>
                            </p>



                            <div>
                                <a href="<?php echo APP_URL; ?>s-profile/<?php echo $idEstudianteTop; ?>/"
                                    class="btn btn-info" style="background-color: #2b338c; color: white;">Ver perfil</a>
                                <a href="<?php echo APP_URL; ?>a-chat/?id=<?php echo $idEstudianteTop; ?>"
                                    class="btn btn-info"
                                    style="background-color: #ffda00; color: #2b338c;">Contactar</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfica -->
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded">
                    <h5>Postulaciones por empleo</h5>
                    <canvas id="jobChart"></canvas>
                </div>

                <!-- Métricas -->
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded text-center">
                    <h5>Total Ofertas Publicadas</h5>
                    <p class="fs-3 fw-bold"><?php echo $totalEmpleos; ?></p>
                </div>
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded text-center">
                    <h5>Total de Alumnos en la Plataforma</h5>
                    <p class="fs-3 fw-bold"><?php echo $totalEstudiantes; ?></p>
                </div>
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded text-center">
                    <h5>Postulaciones Recibidas</h5>
                    <p class="fs-3 fw-bold"><?php echo $totalPostulaciones; ?></p>
                </div>
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded text-center">
                    <h5>Otra Tarjeta de Información</h5>
                    <p>Datos adicionales relevantes</p>
                </div>
            </div>
        </div>

        <script>
            const jobLabels = <?php echo $labelsJSON; ?>;
            const jobData = <?php echo $datosJSON; ?>;

            const ctx = document.getElementById('jobChart').getContext('2d');
            const jobChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: jobLabels,
                    datasets: [{
                        label: 'Postulaciones',
                        data: jobData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

    </div>
</body>

</html>