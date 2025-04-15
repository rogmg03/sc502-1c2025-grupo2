<?php
// s-add-cv-view.php

// Aquí puedes agregar la inclusión de encabezados y otros archivos PHP necesarios
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agregar CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./css/styles.css" rel="stylesheet" /> <!-- Referencia al archivo CSS unificado -->

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
        <img src="../app/views/img/userImg.png" alt="Logo" />
        <div class="usuario">userUfide</div>
        <div class="correo">correo@ufide.ac.cr</div>
        <hr class="horizontal-divider" />

        <a href="<?php echo APP_URL; ?>s-home/">Inicio</a>
        <a href="<?php echo APP_URL; ?>s-view-cv/" class="link-activo">Mis Curriculums</a>
        <a href="<?php echo APP_URL; ?>s-view-jobs/">Lista de empleos</a>
        <a href="<?php echo APP_URL; ?>a-chat/">Chat</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <div class="form-container">
            <h2 class="mb-4">Agregar Curriculum</h2>

            <div class="card card-form">
                <div class="card-body">
                    <form>
                        <h3 class="mb-4">Información Personal</h3>
                        <div id="informacionPersonal" class="form-section active">
                            <label for="nombreEstudiante" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreEstudiante" required />
                            <label for="apellidosEstudiante" class="form-label mt-2">Apellidos</label>
                            <input type="text" class="form-control" id="apellidosEstudiante" required />
                            <label for="fechaNacimientoEstudiante" class="form-label mt-2">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="fechaNacimientoEstudiante" required />
                            <label for="cedulaEstudiante" class="form-label mt-2">Cédula</label>
                            <input type="number" class="form-control" id="cedulaEstudiante" required />
                            <label for="telefonoEstudiante" class="form-label mt-2">Número de teléfono</label>
                            <input type="number" class="form-control" id="telefonoEstudiante" required />
                            <label for="emailEstudiante" class="form-label mt-2">Email</label>
                            <input type="email" class="form-control" id="emailEstudiante" required />
                            <label for="direccionEstudiante" class="form-label mt-2">Dirección</label>
                            <textarea class="form-control" id="direccionEstudiante" rows="4"
                                placeholder="Provincia, Cantón, Distrito..." required></textarea>

                            <label for="descripcionSobreMi" class="form-label mt-2">Sobre mí</label>
                            <textarea class="form-control" id="descripcionSobreMi" rows="4"
                                placeholder="Describe como eres..."></textarea>

                            <label for="areaEstudiante" class="form-label mt-2">Estudiante de: </label>
                            <select class="form-select" id="areaEstudiante" required>
                                <option selected disabled>Seleccione un área</option>
                                <option value="Tecnología">Tecnología</option>
                                <option value="Administración">Administración</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Finanzas">Finanzas</option>
                            </select>
                        </div>

                        <h3 class="mb-4 mt-5">Experiencia Laboral</h3>
                        <div id="experienciaLaboral" class="form-section">
                            <label for="cargo" class="form-label">Cargo</label>
                            <input type="text" class="form-control" id="cargo" required />
                            <label for="tipoEmpleo" class="form-label mt-2">Tipo de empleo</label>
                            <input type="text" class="form-control" id="tipoEmpleo" required />
                            <label for="empresa" class="form-label mt-2">Empresa</label>
                            <input type="text" class="form-control" id="empresa" required />
                            <label for="fechaInicio" class="form-label mt-2">Fecha de inicio</label>
                            <input type="date" class="form-control" id="fechaInicio" required />
                            <label for="fechaFin" class="form-label mt-2">Fecha de finalización </label>
                            <input type="date" class="form-control" id="fechaFin" required />
                            <label for="ubicacion" class="form-label mt-2">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" required />
                            <label for="modalidad" class="form-label mt-2">Modalidad</label>
                            <select class="form-select" id="modalidadPuesto" required>
                                <option selected disabled>Seleccione la modalidad</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Remoto">Remoto</option>
                                <option value="Híbrido">Híbrido</option>
                            </select>

                            <label for="descripciondelempleo" class="form-label mt-2">Descripción</label>
                            <textarea class="form-control" id="descripciondelempleo" rows="4"
                                placeholder="Describe la empresa..."></textarea>
                        </div>

                        <h3 class="mb-4 mt-5">Formación</h3>
                        <div id="formacion" class="form-section">
                            <label for="institucionEducativa" class="form-label">Institución educativa</label>
                            <input type="text" class="form-control" id="institucionEducativa" required />
                            <label for="titulo" class="form-label mt-2">Título</label>
                            <input type="text" class="form-control" id="titulo" required />
                            <label for="fechaInicio" class="form-label mt-2">Fecha de inicio</label>
                            <input type="date" class="form-control" id="fechaInicio" required />
                            <label for="fechaFin" class="form-label mt-2">Fecha de finalización </label>
                            <input type="date" class="form-control" id="fechaFin" required />
                        </div>

                        <hr>

                        <div>
                            <button style="font-weight: bolder; border-radius: 100%; color:white; margin-left: 46%;"
                                class="btn-info btn btn-center">+</button>
                        </div>

                        <h3 class="mb-4 mt-5">Certificaciones</h3>
                        <div id="certificados" class="form-section">
                            <label for="nombreCertificado" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreCertificado" required />
                            <label for="empresaEmisora" class="form-label mt-2">Empresa emisora</label>
                            <input type="text" class="form-control" id="empresaEmisora" required />
                            <label for="fechaExpedicion" class="form-label mt-2">Fecha de expedición</label>
                            <input type="date" class="form-control" id="fechaExpedicion" required />
                            <label for="fechaCaducidad" class="form-label mt-2">Fecha de caducidad</label>
                            <input type="date" class="form-control" id="fechaCaducidad" required />
                            <label for="idcredenciales" class="form-label mt-2">ID de la credencial</label>
                            <input type="number" class="form-control" id="idcredenciales" required />
                            <label for="urlcredenciales" class="form-label mt-2">URL de la credencial</label>
                            <input type="url" class="form-control" id="urlcredenciales" required />
                        </div>

                        <hr>

                        <div>
                            <button style="font-weight: bolder; border-radius: 100%; color:white; margin-left: 46%;"
                                class="btn-info btn btn-center">+</button>
                        </div>

                        <nav aria-label="Page navigation example" class="form-label mt-2">
                            <ul class="pagination justify-content-end">
                                <li class="page-item disabled">
                                    <a class="page-link">Anterior</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Siguiente</a>
                                </li>
                            </ul>
                        </nav>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Guardar Curriculum</button>
                            <button type="reset" class="btn btn-secondary">Limpiar Curriculum</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>