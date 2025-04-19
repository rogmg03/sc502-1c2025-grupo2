<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleos agregados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
            margin-bottom: 10px;
        }


        .chart {
            height: 500px;
            width: 100%;
        }

        .pie-legend {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pie-legend span {
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 100%;
            margin-right: 16px;
            margin-bottom: -2px;
        }

        .pie-legend li {
            margin-bottom: 10px;
        }
    </style>


</head>

<body>


    <div class="vertical-nav">
        <img src="../app/views/img/userImg.png" style="height: 150px; width: 150px" alt="Logo">

        <div class="usuario">userUfide</div>
        <div class="correo">correo@ufide.ac.cr</div>
        <hr class="horizontal-divider">
        <a href="<?php echo APP_URL; ?>s-home/" class="link-activo">Inicio</a>
        <a href="<?php echo APP_URL; ?>s-view-cv/">Mis Curriculums</a>
        <a href="<?php echo APP_URL; ?>s-view-jobs/">Lista de empleos</a>
        <a href="<?php echo APP_URL; ?>s-chat/">Chat</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h2>Inicio</h2>
        <!--button class="btn btn-dark btn-sm py-1" type="button" id="agregarEmpleo">Agregar Empleo</button-->

        <div class="container mt-4 flex" style="align-content: space-between;">
            <!-- Primera fila -->
            <div class="d-flex flex-wrap gap-3">
                <div class="row">
                    <div class="col-md-8 col-lg-6 col-xl-6">
                        <div class="flex-fill p-3 row card-shadow border rounded">
                            <h5>Curriculum Activo</h5>
                            <div class="row student-card flex flex-wrap" style="flex-wrap: wrap; flex-direction: row;">
                                <div class="col-md-6 col-lg-6 d-flex">
                                    <img src="../app/views/img/user.png" class="mx-auto"
                                        style="margin-top: 20px; height: 200px; border-radius: 100%; box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.1);" />
                                </div>
                                <div class="col-md-6 col-lg-6 text-center">
                                    <h5>John Doe</h5>
                                    <br>
                                    <p style="font-weight: 500;">Software Developer</p>
                                    <p>San Pedro, San José, Costa Rica</p>
                                    <div>
                                        <button class="btn btn-info" style="background-color: #2b338c;color: white;">Ver
                                            curriculum</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-fill p-3 row card-shadow border rounded text-center">
                            <h5>Total Empleos Aplicados</h5>
                            <p>4</p>
                        </div>
                        <div class="flex-fill p-3 row card-shadow border rounded text-center">
                            <h5>Total de Empleos en la Plataforma</h5>
                            <p>350</p>
                        </div>
                        <div class="flex-fill p-3 row card-shadow border rounded text-center">
                            <h5>Vistas a tu perfil</h5>
                            <p>8</p>
                        </div>
                    </div>
                    <div class="flex-fill p-3 col-md-1 col-lg-4 col-xl-5 card-shadow border rounded"">
                    <h5>Empleos más requeridos</h5>
 
                    <div class=" card-body">
                        <div class="chart">
                            <canvas id="property_types" class="pie"></canvas>
                            <div id="pie_legend" class="py-3 text-left col-md-7 mx-auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    </div>

    </div>

    <script>

        // global options variable
        var options = {
            responsive: true,
            easing: 'easeInExpo',
            scaleBeginAtZero: true
            // you don't have to define this here, it exists inside the global defaults
            //legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        }

        // PIE
        // PROPERTY TYPE DISTRIBUTION
        // context
        var ctxPTD = $("#property_types").get(0).getContext("2d");
        // data
        var dataPTD = [
            {
                label: "Desarrollador web",
                color: "#5093ce",
                highlight: "#78acd9",
                value: 52
            },
            {
                label: "Diseñador Gráfico",
                color: "#c7ccd1",
                highlight: "#e3e6e8",
                value: 12
            },
            {
                label: "Desarrollador .Net",
                color: "#7fc77f",
                highlight: "#a3d7a3",
                value: 6
            },
            {
                label: "Ingeniero en procesos",
                color: "#fab657",
                highlight: "#fbcb88",
                value: 8
            },
            {
                label: "Cocinero",
                color: "#eaaede",
                highlight: "#f5d6ef",
                value: 4
            },
            {
                label: "Especialista en ventas",
                color: "#dd6864",
                highlight: "#e6918e",
                value: 14
            },

        ]

        // Property Type Distribution
        var propertyTypes = new Chart(ctxPTD).Pie(dataPTD, options);
        // pie chart legend
        $("#pie_legend").html(propertyTypes.generateLegend());




    </script>


    </div>


</body>


</html>