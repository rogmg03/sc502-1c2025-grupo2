<?php
use app\controllers\editarUsuarioController;
require_once "./app/views/inc/session_start.php";
$controller = new editarUsuarioController();
$id_usuario = $_SESSION['id'];
$usuario = $controller->obtenerDatosUsuario($id_usuario);
$controller->actualizarUsuario($id_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      <img src="<?php echo APP_URL; ?>app/views/img/Logo_Universidad_Fidélitas.jpg" alt="Logo" style="height: 80px; width: 80px; margin-right: 10px;">
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
          <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre_completo']); ?>" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($usuario['correo_electronico']); ?>" required>
        </div>
        <div class="mb-3">
          <label for="contrasena" class="form-label">Nueva Contraseña</label>
          <input type="password" id="contrasena" name="contrasena" class="form-control">
        </div>
        <div class="mb-3">
          <label for="confirmar" class="form-label">Confirmar Contraseña</label>
          <input type="password" id="confirmar" name="confirmar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
      </form>

      <p class="text-center mt-3">
        <a class="btn btn-secondary" href="<?php echo APP_URL; ?>s-home/">Volver al inicio</a>
      </p>
    </div>
  </div>

  <?php if (isset($_SESSION['perfil_actualizado'])): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      icon: 'success',
      title: '¡Éxito!',
      text: '<?php echo $_SESSION['perfil_actualizado']; ?>',
      confirmButtonText: 'Continuar'
    });
  </script>
  <?php unset($_SESSION['perfil_actualizado']); ?>
<?php endif; ?>

</body>
</html>
