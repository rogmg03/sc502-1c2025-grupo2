<?php
use app\controllers\aplicar_empleoController;
use app\models\mainModel;

$model = new mainModel();
$aplicacion = new aplicar_empleoController();

$mensaje = "";
$alerta = "";

// Obtener ID del empleo desde URL
$id_empleo = $_GET['id'] ?? null;
$empleo = [];

// Obtener datos del empleo si existe
if ($id_empleo) {
    $datos = $model->ejecutarConsultaParametros(
        "SELECT * FROM empleos WHERE id_empleo = :id",
        [":id" => $id_empleo]
    );
    $empleo = $datos->fetch();
}

// Obtener ID del alumno desde sesión
$id_alumno = $_SESSION['id'] ?? null;

// Procesar postulación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST['id_alumno'] = $id_alumno;
    $_POST['id_empleo'] = $id_empleo;

    $mensaje = $aplicacion->aplicar_empleoController();

    // Tipo de alerta
    if (str_contains($mensaje, "correctamente")) {
        $alerta = "success";
    } elseif (str_contains($mensaje, "Ya has aplicado")) {
        $alerta = "info";
    } else {
        $alerta = "error";
    }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detalles del Empleo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .vertical-nav {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #001bb3;
            padding-top: 20px;
        }

        .vertical-nav img {
            display: block;
            margin: 0 auto 20px auto;
            height: 150px;
            width: 150px;
        }

        .vertical-nav .usuario,
        .vertical-nav .correo {
            text-align: center;
            color: mintcream;
        }

        .vertical-nav .usuario {
            font-size: 20px;
            margin-bottom: 1px;
        }

        .vertical-nav .correo {
            font-size: 15px;
            font-style: italic;
            margin-bottom: 5px;
        }

        .vertical-nav .horizontal-divider {
            border-top: 2px solid white;
            width: 100%;
            margin: 10px 0;
        }

        .vertical-nav a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: mintcream;
            display: block;
        }

        .vertical-nav a:hover {
            background-color: #001bb3;
        }

        .vertical-nav a.link-activo {
            background-color: white;
            color: #001bb3;
            font-weight: bold;
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            width: 90%;
            left: 5%;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .card-form {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            margin-bottom: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <div class="vertical-nav">
        <img src="<?php echo APP_URL; ?>app/views/img/userImg.png" alt="Logo" />
        <div class="usuario d-flex align-items-center justify-content-center" style="gap: 8px;">
            <span><?php echo $_SESSION['nombre']; ?></span>
            <a href="<?php echo APP_URL; ?>s-edit-info/" title="Editar perfil">
                <i class="bi bi-pencil-square" style="color: white; font-size: 1.2rem;"></i>
            </a>
        </div>
        <div class="correo"><?php echo $_SESSION['correo']; ?></div>
        <hr class="horizontal-divider" />
        <a href="<?php echo APP_URL; ?>s-home/">Inicio</a>
        <a href="<?php echo APP_URL; ?>s-view-cv/">Mis Currículums</a>
        <a href="<?php echo APP_URL; ?>s-view-jobs/" class="link-activo">Lista de Empleos</a>
        <a href="<?php echo APP_URL; ?>s-chat/">Chat</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h2>Detalles del Empleo</h2>

        <?php if (!empty($empleo)): ?>
            <div class="card-form">
                <h4>Información General</h4>
                <p><strong>Nombre del Puesto:</strong> <?= htmlspecialchars($empleo['nombre_puesto']) ?></p>
                <p><strong>Área:</strong> <?= htmlspecialchars($empleo['area']) ?></p>
                <p><strong>Modalidad:</strong> <?= htmlspecialchars($empleo['modalidad']) ?></p>
                <p><strong>Ubicación:</strong> <?= htmlspecialchars($empleo['ubicacion']) ?></p>
                <p><strong>Salario:</strong> <?= htmlspecialchars($empleo['salario']) ?></p>
                <p><strong>Fecha de Publicación:</strong> <?= htmlspecialchars($empleo['fecha_publicacion']) ?></p>
            </div>

            <div class="card-form">
                <h4>Descripción</h4>
                <p><?= nl2br(htmlspecialchars($empleo['descripcion'])) ?></p>
            </div>

            <div class="card-form">
                <h4>Requisitos</h4>
                <p><?= nl2br(htmlspecialchars($empleo['requisitos'])) ?></p>
                <p><strong>Estado:</strong> <?= htmlspecialchars($empleo['estado']) ?></p>
            </div>

            <form method="post" action="">
                <input type="hidden" name="id_empleo" value="<?= $id_empleo ?>">
                <button type="submit" class="btn btn-primary">Aplicar a este empleo</button>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">Empleo no encontrado.</div>
        <?php endif; ?>
    </div>

    <?php if (!empty($mensaje)): ?>
        <script>
            Swal.fire({
                icon: '<?= $alerta ?>',
                title: 'Postulación',
                text: '<?= $mensaje ?>',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>

</body>

</html>