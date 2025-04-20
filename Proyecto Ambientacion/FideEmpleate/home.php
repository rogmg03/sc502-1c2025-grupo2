<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Aplicación para Docentes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f9ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-top {
            display: flex;
            justify-content: end;
            padding: 10px 30px;
            background-color: transparent;
        }

        .hero {
            text-align: center;
            padding: 60px 20px 40px;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #0c1e45;
        }

        .hero p {
            font-size: 1.1rem;
            color: #555;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .hero .btn {
            font-size: 1rem;
            padding: 10px 30px;
        }

        .features {
            padding: 40px 20px;
        }

        .feature-box {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            text-align: center;
        }

        .feature-box h5 {
            margin-top: 20px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            background-color: #f0f2f5;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>

<!-- Barra superior -->
<div class="navbar-top">
    <a href="login" class="btn btn-outline-primary btn-sm">Iniciar Sesión</a>
</div>

<!-- Sección principal -->
<div class="hero">
    <h1>Bienvenido al Sistema de Aplicación FideEmpleate!!</h1>
    <p>
        Únase a nuestro sistema para encontrar oportunidades laborales de forma sencilla.
        Registre una cuenta para aplicar en tan solo unos minutos.
    </p>
    <a href="register" class="btn btn-primary">Registrarse Ahora</a>
</div>

<!-- Características -->
<div class="container features">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-box">
                <div><img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" width="50" alt="Icono Registro"></div>
                <h5>Registro Sencillo</h5>
                <p>Proceso de registro rápido y fácil.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <div><img src="https://cdn-icons-png.flaticon.com/512/2659/2659360.png" width="50" alt="Icono Documentos"></div>
                <h5>Gestión de Documentos</h5>
                <p>Suba sus atestados y documentos importantes en múltiples formatos.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <div><img src="https://cdn-icons-png.flaticon.com/512/189/189792.png" width="50" alt="Icono Seguimiento"></div>
                <h5>Seguimiento en Línea</h5>
                <p>Monitoree el estado de su aplicación en tiempo real desde su panel personal.</p>
            </div>
        </div>
    </div>
</div>

<!-- Pie de página -->
<div class="footer">
    © 2025 FideEmpleate. Todos los derechos reservados.
</div>

</body>
</html>
