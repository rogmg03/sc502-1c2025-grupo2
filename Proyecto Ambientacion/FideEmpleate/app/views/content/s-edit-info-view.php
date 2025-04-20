<?php
require_once '../inc/session_start.php';
use app\models\mainModel;

$model = new mainModel();
$id_usuario = $_SESSION['id'];

$stmt = $model->ejecutarConsultaParametros("SELECT * FROM usuarios WHERE id_usuario = :id", [
    ":id" => $id_usuario
]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$usuario) {
    echo "<div class='alert alert-danger'>Usuario no encontrado.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      padding-top: 200px;
      background: radial-gradient(circle, rgb(5, 71, 253) 0%, rgba(0,212,255,0.081) 100%);
      font-family: Arial, sans-serif;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" data-bs-theme="dark">
    <div class="container-fluid d-flex align-items-center">
      <img src="../../Images/Logo_Universidad_Fidélitas.jpg" alt="Logo" style="height: 80px; width: 80px; margin-right: 10px;">
      <strong class="mx-auto text-white fs-3">Fide Empleate</strong>
    </div>
  </nav>

  <div class="container d-flex justify-content-center">
    <div class="card p-4" style="width: 400px;">
      <h2 class="text-center">Editar Perfil</h2>
      <form method="POST" action="">
        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" id="email" name="email" class="form-control" value="<?php echo $usuario['email']; ?>" required>
        </div>
        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $usuario['telefono']; ?>" required>
        </div>
        <div class="mb-3">
          <label for="cedula" class="form-label">Cédula</label>
          <input type="text" id="cedula" name="cedula" class="form-control" value="<?php echo $usuario['cedula']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
      </form>

      <p class="text-center mt-3">
        <a href="../a-home/">Volver al inicio</a>
      </p>
    </div>
  </div>
</body>
</html>
