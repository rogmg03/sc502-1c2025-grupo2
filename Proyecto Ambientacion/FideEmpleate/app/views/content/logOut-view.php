<?php
use app\controllers\loginController;

$logout = new loginController();
$logout->cerrarSesionControlador();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cerrando sesión...</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../app/views/css/styles.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      padding-top: 200px;
      background: radial-gradient(circle, rgb(5, 71, 253) 0%, rgba(0, 212, 255, 0.081) 100%);
      font-family: Arial, sans-serif;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" data-bs-theme="dark">
    <div class="container-fluid d-flex align-items-center">
      <img src="../app/views/img/Logo_Universidad_Fidélitas.jpg" alt="Logo" style="height: 80px; width: 80px; margin-right: 10px;" />
      <strong class="mx-auto text-white fs-3">Fide Empléate</strong>
    </div>
  </nav>

  <div class="container d-flex justify-content-center">
    <div class="card p-4 text-center" style="width: 400px;">
      <h2 class="text-center">Sesión finalizada</h2>
      <p>Gracias por utilizar Fide Empléate.</p>
      <p>Serás redirigido automáticamente en unos segundos.</p>

      <a href="<?php echo APP_URL; ?>login/" class="btn btn-primary mt-3">Iniciar sesión de nuevo</a>
    </div>
  </div>

  <footer class="bg-dark text-white text-center p-3 mt-5">
    <p>Fide Empléate &copy; 2025 - Universidad Fidélitas</p>
    <div class="container">
      <p>Email: info@FideEmpleate.com</p>
      <p>Número: +506 5687-5633</p>
      <p>Redes sociales:
        <a href="#">Facebook</a> |
        <a href="#">Twitter</a> |
        <a href="#">Instagram</a> |
        <a href="#">Tik Tok</a> |
      </p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    Swal.fire({
      icon: 'info',
      title: 'Sesión finalizada',
      text: 'Has cerrado sesión correctamente.',
      showConfirmButton: false,
      timer: 3000
    });

    setTimeout(() => {
      window.location.href = "<?php echo APP_URL; ?>login/";
    }, 3000);
  </script>
</body>
</html>
