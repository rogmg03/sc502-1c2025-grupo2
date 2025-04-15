<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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
            <img src="../app/views/img/Logo_Universidad_Fidélitas.jpg" alt="Logo"
                style="height: 80px; width: 80px; margin-right: 10px;">
            <strong class="mx-auto text-white fs-3">Fide Empleate</strong>
        </div>
    </nav>


    <div class="container d-flex justify-content-center">
        <div class="card p-4" style="width: 400px;">
            <h2 class="text-center">Iniciar sesión</h2>

            <!-- Formulario de inicio de sesión -->
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Iniciar sesión</button>
                <div id="error-message" class="text-danger text-center mt-2">
                    <?php
                    if (isset($errorMessage)) {
                        echo $errorMessage; // Muestra el mensaje de error si existe
                    }
                    ?>
                </div>
            </form>
            <?php
            if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
                $insLogin->iniciarSesionControlador();
            }
            ?>

            <div id="response" class="mt-3"></div>
            <p class="text-center mt-3">
                ¿No tienes cuenta? <a href="<?php echo APP_URL; ?>register/">Regístrate aquí</a>.
            </p>
        </div>
    </div>

</body>

<footer class="bg-dark text-white text-center p-3" style="margin-top: 15vh;">
    <p>Fide Empléate &copy; 2025 - Universidad Fidélitas</p>
    <div class="container">
        <p>Email: info@FideEmpleate.com</p>
        <p>Numero: +506 5687-5633</p>
        <p>Redes sociales:
            <a href="#">Facebook</a> |
            <a href="#">Twitter</a> |
            <a href="#">Instagram</a> |
            <a href="#">Tik Tok</a> |
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>