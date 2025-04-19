<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculums Agregados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>


    </style>


</head>
<body>
    <div class="vertical-nav">
        <img src="../app/views/img/userImg.png" style="height: 150px; width: 150px" alt="Logo">
        
        <div class="usuario">userUfide</div>
        <div class="correo">correo@ufide.ac.cr</div>
        <hr class="horizontal-divider">
        <a href="<?php echo APP_URL; ?>s-home/">Inicio</a>
        <a href="<?php echo APP_URL; ?>s-view-cv/" class="link-activo">Mis Curriculums</a>
        <a href="<?php echo APP_URL; ?>s-view-jobs/">Lista de empleos</a>
        <a href="<?php echo APP_URL; ?>s-chat/">Chat</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>
  
    <div class="main-content">
        <h2>Curriculums Agregados</h2>
        <a href="<?php echo APP_URL; ?>s-add-cv/" class="btn btn-dark btn-sm py-1" type="button" id="agregarCurriculum">Agregar Curriculum</a>
        <div class="job-list">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Lista de Curriculums
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th>Puntaje</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Estudiante de Ingeniería en Sistemas</td>
                                <td>85%</td>
                                <td><span class="badge bg-success rounded-pill">Activo</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Ver</button>
                                    <button class="btn btn-secondary btn-sm">Editar</button>
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                    <button class="btn btn-secondary btn-sm">Estado</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Estudiante de Ingeniería Industrial</td>
                                <td>50%</td>
                                <td><span class="badge bg-warning rounded-pill">Inactivo</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Ver</button>
                                    <button class="btn btn-secondary btn-sm">Editar</button>
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                    <button class="btn btn-secondary btn-sm">Estado</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
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

                </div>
            </div>
        </div>
    </div>


</body>


</html>