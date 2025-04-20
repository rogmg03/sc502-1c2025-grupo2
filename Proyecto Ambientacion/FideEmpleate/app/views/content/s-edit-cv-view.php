<?php
use app\controllers\editarCVController;

$id_cv = intval(explode("/", $_GET['views'])[1] ?? 0);
$cvController = new editarCVController();

$datosCV = $cvController->obtenerDatosCV($id_cv);
$info = $datosCV['info_personal'];
$exp = $datosCV['experiencia'];
$edu = $datosCV['formacion'];
$cert = $datosCV['certificaciones'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = $cvController->actualizarCVController($id_cv);
    echo "<script>
        Swal.fire({
            title: '¡Éxito!',
            text: '$mensaje',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '" . APP_URL . "s-view-cv/';
        });
    </script>";
}

?>
<?php if (isset($_SESSION['cv_mensaje']) && isset($_SESSION['cv_redirect'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: '¡Éxito!',
                text: "<?= $_SESSION['cv_mensaje'] ?>",
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "<?= APP_URL ?>s-view-cv/";
            });
        });
    </script>
    <?php
    unset($_SESSION['cv_mensaje']);
    unset($_SESSION['cv_redirect']);
?>
<?php endif; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
    <style>
        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .card-form {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            margin-bottom: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .btn-close {
            z-index: 10;
        }
    </style>

</head>

<body>
    <div class="vertical-nav">
        <img src="../app/views/img/userImg.png" alt="Logo" />
        <div class="usuario d-flex align-items-center justify-content-center" style="gap: 8px;">
            <span><?php echo $_SESSION['nombre']; ?></span>
            <a href="<?php echo APP_URL; ?>s-edit-info/" title="Editar perfil">
                <i class="bi bi-pencil-square" style="color: white; font-size: 1.2rem;"></i>
            </a>
        </div>
        <div class="correo"><?php echo $_SESSION['correo']; ?></div>
        <hr class="horizontal-divider" />
        <a href="<?php echo APP_URL; ?>s-home/">Inicio</a>
        <a href="<?php echo APP_URL; ?>s-view-cv/" class="link-activo">Mis Curriculums</a>
        <a href="<?php echo APP_URL; ?>s-view-jobs/">Lista de empleos</a>
        <a href="<?php echo APP_URL; ?>a-chat/">Chat</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h2>Editar Curriculum</h2>
        <form method="POST">
            <div class="form-section active" data-index="0">
                <h3>Información Personal</h3>
                <input name="nombre" class="form-control mb-2" value="<?= htmlspecialchars($info['nombre']) ?>"
                    required>
                <input name="apellidos" class="form-control mb-2" value="<?= htmlspecialchars($info['apellidos']) ?>"
                    required>
                <input type="date" name="fecha_nacimiento" class="form-control mb-2"
                    value="<?= $info['fecha_nacimiento'] ?>">
                <input name="cedula" class="form-control mb-2" value="<?= htmlspecialchars($info['cedula']) ?>"
                    required>
                <input name="telefono" class="form-control mb-2" value="<?= htmlspecialchars($info['telefono']) ?>"
                    required>
                <input type="email" name="email" class="form-control mb-2"
                    value="<?= htmlspecialchars($info['email']) ?>" required>
                <textarea name="direccion" class="form-control mb-2"
                    required><?= htmlspecialchars($info['direccion']) ?></textarea>
                <textarea name="descripcion"
                    class="form-control mb-2"><?= htmlspecialchars($info['sobre_mi']) ?></textarea>
                <input name="estudiante_de" class="form-control mb-2"
                    value="<?= htmlspecialchars($info['estudiante_de']) ?>" required>
            </div>

            <div class="form-section" data-index="1">
                <h3>Experiencia Laboral</h3>
                <div id="contenedorExperiencias"></div>
                <button type="button" class="btn btn-info mt-3" id="btnAgregarExperiencia">+ Agregar
                    experiencia</button>
            </div>

            <div class="form-section" data-index="2">
                <h3>Formación</h3>
                <div id="contenedorFormaciones"></div>
                <button type="button" class="btn btn-info mt-3" id="btnAgregarFormacion">+ Agregar formación</button>
            </div>

            <div class="form-section" data-index="3">
                <h3>Certificaciones</h3>
                <div id="contenedorCertificados"></div>
                <button type="button" class="btn btn-info mt-3" id="btnAgregarCertificado">+ Agregar
                    certificación</button>
            </div>

            <ul class="pagination mt-4">
                <li class="page-item"><a class="page-link" href="#" data-page="0">1</a></li>
                <li class="page-item"><a class="page-link" href="#" data-page="1">2</a></li>
                <li class="page-item"><a class="page-link" href="#" data-page="2">3</a></li>
                <li class="page-item"><a class="page-link" href="#" data-page="3">4</a></li>
            </ul>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".page-link").forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    let page = parseInt(this.dataset.page);
                    document.querySelectorAll(".form-section").forEach((sec, idx) => {
                        sec.classList.toggle("active", idx === page);
                        sec.classList.toggle("d-none", idx !== page);
                    });
                    document.querySelectorAll(".page-item").forEach(li => li.classList.remove("active"));
                    this.parentElement.classList.add("active");
                });
            });

            const experienciaHTML = () => `<div class='grupo-experiencia border p-3 mb-3 rounded position-relative'>
        <button type='button' class='btn-close position-absolute top-0 end-0 m-2 btn-eliminar-custom'></button>
        <input name='cargo[]' class='form-control mb-2' placeholder='Cargo' required>
        <input name='tipo_empleo[]' class='form-control mb-2' placeholder='Tipo de empleo'>
        <input name='empresa[]' class='form-control mb-2' placeholder='Empresa' required>
        <input type='date' name='fecha_inicio[]' class='form-control mb-2'>
        <input type='date' name='fecha_fin[]' class='form-control mb-2'>
        <input name='ubicacion[]' class='form-control mb-2' placeholder='Ubicación'>
        <select name='modalidad[]' class='form-select mb-2'>
            <option disabled selected>Seleccione la modalidad</option>
            <option value='Presencial'>Presencial</option>
            <option value='Remoto'>Remoto</option>
            <option value='Híbrido'>Híbrido</option>
        </select>
        <textarea name='descripciondelempleo[]' class='form-control' placeholder='Descripción del empleo'></textarea>
    </div>`;

            const formacionHTML = () => `<div class='grupo-formacion border p-3 mb-3 rounded position-relative'>
        <button type='button' class='btn-close position-absolute top-0 end-0 m-2 btn-eliminar-custom'></button>
        <input name='institucion[]' class='form-control mb-2' placeholder='Institución' required>
        <input name='titulo[]' class='form-control mb-2' placeholder='Título' required>
        <input type='date' name='fecha_inicio[]' class='form-control mb-2'>
        <input type='date' name='fecha_fin[]' class='form-control mb-2'>
    </div>`;

            const certificadoHTML = () => `<div class='grupo-certificado border p-3 mb-3 rounded position-relative'>
        <button type='button' class='btn-close position-absolute top-0 end-0 m-2 btn-eliminar-custom'></button>
        <input name='nombre_certificado[]' class='form-control mb-2' placeholder='Nombre del certificado' required>
        <input name='empresa_emisora[]' class='form-control mb-2' placeholder='Empresa emisora' required>
        <input type='date' name='fecha_expedicion[]' class='form-control mb-2'>
        <input type='date' name='fecha_caducidad[]' class='form-control mb-2'>
        <input name='idcredenciales[]' class='form-control mb-2' placeholder='ID de la credencial'>
        <input name='urlcredenciales[]' class='form-control mb-2' placeholder='URL de la credencial'>
    </div>`;

            document.getElementById("btnAgregarExperiencia").addEventListener("click", () => {
                document.getElementById("contenedorExperiencias").insertAdjacentHTML("beforeend", experienciaHTML());
            });

            document.getElementById("btnAgregarFormacion").addEventListener("click", () => {
                document.getElementById("contenedorFormaciones").insertAdjacentHTML("beforeend", formacionHTML());
            });

            document.getElementById("btnAgregarCertificado").addEventListener("click", () => {
                document.getElementById("contenedorCertificados").insertAdjacentHTML("beforeend", certificadoHTML());
            });

            document.addEventListener("click", function (e) {
                if (e.target.classList.contains("btn-eliminar")) {
                    const bloque = e.target.closest(".grupo-experiencia, .grupo-formacion, .grupo-certificado");
                    if (bloque) bloque.remove();
                }
            });

            const exp = <?= json_encode($exp) ?>;
            const edu = <?= json_encode($edu) ?>;
            const cert = <?= json_encode($cert) ?>;

            exp.forEach(() => document.getElementById("btnAgregarExperiencia").click());
            edu.forEach(() => document.getElementById("btnAgregarFormacion").click());
            cert.forEach(() => document.getElementById("btnAgregarCertificado").click());

            setTimeout(() => {
                document.querySelectorAll(".grupo-experiencia").forEach((grupo, i) => {
                    grupo.querySelector('[name="cargo[]"]').value = exp[i].cargo;
                    grupo.querySelector('[name="tipo_empleo[]"]').value = exp[i].tipo_empleo;
                    grupo.querySelector('[name="empresa[]"]').value = exp[i].empresa;
                    grupo.querySelector('[name="fecha_inicio[]"]').value = exp[i].fecha_inicio;
                    grupo.querySelector('[name="fecha_fin[]"]').value = exp[i].fecha_finalizacion;
                    grupo.querySelector('[name="ubicacion[]"]').value = exp[i].ubicacion;
                    grupo.querySelector('[name="modalidad[]"]').value = exp[i].modalidad;
                    grupo.querySelector('[name="descripciondelempleo[]"]').value = exp[i].descripcion;
                });

                document.querySelectorAll(".grupo-formacion").forEach((grupo, i) => {
                    grupo.querySelector('[name="institucion[]"]').value = edu[i].institucion;
                    grupo.querySelector('[name="titulo[]"]').value = edu[i].titulo_obtenido;
                    grupo.querySelector('[name="fecha_inicio[]"]').value = edu[i].fecha_inicio;
                    grupo.querySelector('[name="fecha_fin[]"]').value = edu[i].fecha_finalizacion;
                });

                document.querySelectorAll(".grupo-certificado").forEach((grupo, i) => {
                    grupo.querySelector('[name="nombre_certificado[]"]').value = cert[i].nombre;
                    grupo.querySelector('[name="empresa_emisora[]"]').value = cert[i].empresa_emisora;
                    grupo.querySelector('[name="fecha_expedicion[]"]').value = cert[i].fecha_expedicion;
                    grupo.querySelector('[name="fecha_caducidad[]"]').value = cert[i].fecha_caducidad;
                    grupo.querySelector('[name="idcredenciales[]"]').value = cert[i].id_credencial;
                    grupo.querySelector('[name="urlcredenciales[]"]').value = cert[i].url_credencial;
                });
            }, 300);

            
        });

        document.addEventListener("click", function(e) {
    if (e.target.classList.contains("btn-eliminar-custom")) {
        e.preventDefault();
        
        const bloque = e.target.closest(".grupo-experiencia, .grupo-formacion, .grupo-certificado");
        if (bloque) {
            Swal.fire({
                title: '¿Eliminar bloque?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    bloque.remove();
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });
        }
    }
});
        
    </script>
</body>

</html>