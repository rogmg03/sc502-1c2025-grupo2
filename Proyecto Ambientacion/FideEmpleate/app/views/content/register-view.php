<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
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
                style="height: 80px; width: 80px; margin-right: 10px;" />
            <strong class="mx-auto text-white fs-3">Fide Empleate</strong>
        </div>
    </nav>

    <div class="container d-flex justify-content-center">
        <div class="card p-4" style="width: 400px;">
            <h2 class="text-center">Registro</h2>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirmar" class="form-label">Confirmar contraseña</label>
                    <input type="password" id="confirmar" name="confirmar" class="form-control" required>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="rol" name="rol">
                    <label class="form-check-label" for="rol">
                        Registrarme como agente (reclutador)
                    </label>
                </div>

                <button type="submit" name="registro" class="btn btn-primary w-100">Registrarse</button>
            </form>

            <?php
            if (isset($mensajeRegistro)) {
                echo '<div class="mt-3 alert alert-info text-center">' . $mensajeRegistro . '</div>';
            }
            ?>


            <p class="text-center mt-3">
                ¿Ya tienes una cuenta? <a href="<?php echo APP_URL; ?>login/">Inicia sesión aquí</a>.
            </p>
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

    <?php
    use app\controllers\registerController;

    if (isset($_POST['registro'])) {
        $rol = isset($_POST['rol']) ? "Reclutador" : "Estudiante";
        $registro = new registerController();
        $mensajeRegistro = $registro->registrarUsuarioControlador($rol);
    }
    ?>
</body>

</html>