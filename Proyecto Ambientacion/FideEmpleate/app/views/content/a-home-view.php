<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleos agregados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Mover a styles.css cuando este listo-->
    <style>
        .vertical-nav {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #001bb3;
            /* Color azul */
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
            padding: 15px;
        }

        .job-list {
            margin-top: 40px;
        }

        .card-shadow {
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>


</head>

<body>


    <div class="vertical-nav">
        <img src="../app/views/img/userImg.png" style="height: 150px; width: 150px" alt="Logo">

        <div class="usuario">userUfide</div>
        <div class="correo">correo@ufide.ac.cr</div>
        <hr class="horizontal-divider">
        <a href="<?php echo APP_URL; ?>a-home/" class="link-activo">Inicio</a>
        <a href="<?php echo APP_URL; ?>a-view-jobs/">Lista de empleos</a>
        <a href="<?php echo APP_URL; ?>a-student-list/">Alumnos Disponibles</a>
        <a href="<?php echo APP_URL; ?>a-chat/">Chat Alumnos</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h2>Inicio</h2>
        <!--button class="btn btn-dark btn-sm py-1" type="button" id="agregarEmpleo">Agregar Empleo</button-->

        <div class="container mt-4 flex" style="align-content: space-between;">
            <!-- Primera fila -->
            <div class="d-flex flex-wrap gap-3">
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded">
                    <h5>Alumnos Destacados</h5>
                    <div class="row student-card">
                        <div class="col-md-5">
                            <img src="../app/views/img/user.png"
                                style="margin-top: 20px; height: 200px; border-radius: 100%; box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.1);" />
                        </div>
                        <div class="col-md-6 text-center">
                            <h5>John Doe</h5>
                            <br>
                            <p style="font-weight: 500;">Software Developer</p>
                            <p>San Pedro, San José, Costa Rica</p>
                            <div>
                                <button class="btn btn-info" style="background-color: #2b338c;color: white;">Ver
                                    perfil</button>
                                <button class="btn btn-info"
                                    style="background-color: #ffda00;color: #2b338c">Contactar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded"">
                    <h5>Postulaciones por empleo</h5>
                    <canvas id="jobChart"></canvas>
                </div>

                <div class="flex-fill p-3 col-md-5 card-shadow border rounded text-center">
                    <h5>Total Ofertas Publicadas</h5>
                    <p>120</p>
                </div>
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded text-center">
                    <h5>Total de Alumnos en la Plataforma</h5>
                    <p>350</p>
                </div>
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded text-center">
                    <h5>Postulaciones Recibidas</h5>
                    <p>450</p>
                </div>
                <div class="flex-fill p-3 col-md-5 card-shadow border rounded text-center">
                    <h5>Otra Tarjeta de Información</h5>
                    <p>Datos adicionales relevantes</p>
                </div>
            </div>

        </div>

        <script>
            // Datos de ejemplo para la gráfica
            // Datos de ejemplo para la gráfica
            const ctx = document.getElementById('jobChart').getContext('2d');
            const jobChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Desarrollador Web', 'Analista de Datos', 'Diseñador UX', 'Administrador de Sistemas'],
                    datasets: [{
                        label: 'Postulaciones',
                        data: [30, 45, 20, 50],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Configuración para barras horizontales
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