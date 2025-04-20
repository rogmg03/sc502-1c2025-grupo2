<?php
use app\controllers\agregar_empleoController;
use app\models\mainModel;

$model = new mainModel();
$empleo = new agregar_empleoController();

$idReclutador = $_SESSION['id'];

$mensaje = "";

// Si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $mensaje = $empleo->agregar_empleoController();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agregar Empleo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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

    .vertical-nav .usuario {
      text-align: center;
      color: mintcream;
      font-size: 20px;
      margin-bottom: 1px;
    }

    .vertical-nav .correo {
      text-align: center;
      color: mintcream;
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

    .vertical-nav a.active-link {
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
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }
  </style>
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
    <div class="form-container">
      <h2 class="mb-4">Agregar Nuevo Empleo</h2>

      <div class="card card-form">
        <div class="card-body">
          <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
          <?php endif; ?>
          <form action="" method="POST">
            <div class="mb-3">
              <label for="nombrePuesto" class="form-label">Nombre del Puesto</label>
              <input type="text" class="form-control" id="nombrePuesto" name="nombrePuesto"
                placeholder="Ej. Desarrollador Full Stack" required />
            </div>

            <div class="mb-3">
              <label for="areaPuesto" class="form-label">Área</label>
              <select class="form-select" id="areaPuesto" name="areaPuesto" required>
                <option selected disabled>Seleccione un área</option>
                <option value="Tecnología">Tecnología</option>
                <option value="Administración">Administración</option>
                <option value="Marketing">Marketing</option>
                <option value="Finanzas">Finanzas</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="descripcionPuesto" class="form-label">Descripción del Puesto</label>
              <textarea class="form-control" id="descripcionPuesto" name="descripcionPuesto" rows="4"
                placeholder="Describe el puesto..."></textarea>
            </div>

            <div class="mb-3">
              <label for="requisitosPuesto" class="form-label">Requisitos</label>
              <textarea class="form-control" id="requisitosPuesto" name="requisitosPuesto" rows="3"
                placeholder="Ej. Título universitario, 2 años de experiencia..."></textarea>
            </div>

            <div class="mb-3">
              <label for="modalidadPuesto" class="form-label">Modalidad</label>
              <select class="form-select" id="modalidadPuesto" name="modalidadPuesto" required>
                <option selected disabled>Seleccione la modalidad</option>
                <option value="Presencial">Presencial</option>
                <option value="Remoto">Remoto</option>
                <option value="Híbrido">Híbrido</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="ubicacionPuesto" class="form-label">Ubicación</label>
              <input type="text" class="form-control" id="ubicacionPuesto" name="ubicacionPuesto"
                placeholder="Ej. San José, Costa Rica" />
            </div>

            <div class="mb-3">
              <label for="salarioPuesto" class="form-label">Salario (opcional)</label>
              <input type="number" class="form-control" id="salarioPuesto" name="salarioPuesto"
                placeholder="Ej. 800000" />
            </div>

            <div class="mb-3">
              <label for="fechaPublicacion" class="form-label">Fecha de Publicación</label>
              <input type="date" class="form-control" id="fechaPublicacion" name="fechaPublicacion" required />
            </div>

            <div class="mb-3">
              <label for="estadoPuesto" class="form-label">Estado del Empleo</label>
              <select class="form-select" id="estadoPuesto" name="estadoPuesto" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
              </select>
            </div>

            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-primary">Guardar Empleo</button>
              <button type="reset" class="btn btn-secondary">Limpiar Formulario</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>