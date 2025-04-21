<?php
use app\controllers\agregarCVController;

$cvController = new agregarCVController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = $cvController->agregarCVController();

    echo "<script>
        Swal.fire({
            title: '¡Éxito!',
            text: '$mensaje',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>";
}
?>

<!-- Aquí iría todo el HTML del formulario que ya te compartí previamente, con JS incluido para añadir/eliminar bloques dinámicos -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agregar CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
</head>
<body>
<div class="vertical-nav">
    <img src="<?php echo APP_URL; ?>app/views/img/userImg.png" alt="Logo" />
    <div class="usuario"><?php echo $_SESSION['nombre']; ?></div>
    <div class="correo"><?php echo $_SESSION['correo']; ?></div>
    <hr class="horizontal-divider" />
    <a href="<?php echo APP_URL; ?>s-home/">Inicio</a>
        <a href="<?php echo APP_URL; ?>s-view-cv/" class="link-activo">Mis Curriculums</a>
    <a href="<?php echo APP_URL; ?>s-view-jobs/">Empleos Disponibles</a>
    <a href="<?php echo APP_URL; ?>s-my-applications/">Mis Postulaciones</a>
	<a href="<?php echo APP_URL; ?>s-chat/">Chat</a>
    <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
</div>

    <div class="main-content">
        <h2>Agregar Curriculum</h2>
        <form method="POST">
            <div class="form-section active" data-index="0">
                <h3>Información Personal</h3>
                <input name="nombre" class="form-control mb-2" placeholder="Nombre" required>
                <input name="apellidos" class="form-control mb-2" placeholder="Apellidos" required>
                <input type="date" name="fecha_nacimiento" class="form-control mb-2" required>
                <input name="cedula" class="form-control mb-2" placeholder="Cédula" required>
                <input name="telefono" class="form-control mb-2" placeholder="Teléfono" required>
                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                <textarea name="direccion" class="form-control mb-2" placeholder="Dirección" required></textarea>
                <textarea name="descripcion" class="form-control mb-2" placeholder="Sobre mí"></textarea>
                <input name="estudiante_de" class="form-control mb-2" placeholder="Carrera" required>
            </div>

            <div class="form-section" data-index="1">
                <h3>Experiencia Laboral</h3>
                <div id="contenedorExperiencias"></div>
                <button type="button" class="btn btn-info mt-3" id="btnAgregarExperiencia">+ Agregar experiencia</button>
            </div>

            <div class="form-section" data-index="2">
                <h3>Formación</h3>
                <div id="contenedorFormaciones"></div>
                <button type="button" class="btn btn-info mt-3" id="btnAgregarFormacion">+ Agregar formación</button>
            </div>

            <div class="form-section" data-index="3">
                <h3>Certificaciones</h3>
                <div id="contenedorCertificados"></div>
                <button type="button" class="btn btn-info mt-3" id="btnAgregarCertificado">+ Agregar certificación</button>
            </div>

            <ul class="pagination mt-4">
                <li class="page-item"><a class="page-link" href="#" data-page="0">1</a></li>
                <li class="page-item"><a class="page-link" href="#" data-page="1">2</a></li>
                <li class="page-item"><a class="page-link" href="#" data-page="2">3</a></li>
                <li class="page-item"><a class="page-link" href="#" data-page="3">4</a></li>
            </ul>

            <button type="submit" class="btn btn-primary">Guardar Curriculum</button>
        </form>
    </div>

    <script>
    document.querySelectorAll(".page-link").forEach(link => {
        link.addEventListener("click", function(e) {
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

    document.getElementById("btnAgregarExperiencia").addEventListener("click", () => {
        const html = `
        <div class='grupo-experiencia border p-3 mb-3 rounded position-relative'>
            <button type='button' class='btn-close position-absolute top-0 end-0 m-2 btn-eliminar'></button>
            
            <label class="form-label mt-2">Cargo</label>
            <input name='cargo[]' class='form-control mb-2' placeholder='Cargo' required>

            <label class="form-label mt-2">Tipo de empleo</label>
            <input name='tipo_empleo[]' class='form-control mb-2' placeholder='Tipo de empleo'>

            <label class="form-label mt-2">Empresa</label>
            <input name='empresa[]' class='form-control mb-2' placeholder='Empresa' required>

            <label class="form-label mt-2">Fecha de inicio</label>
            <input type='date' name='fecha_inicio[]' class='form-control mb-2'>

            <label class="form-label mt-2">Fecha de finalización</label>
            <input type='date' name='fecha_fin[]' class='form-control mb-2'>

            <label class="form-label mt-2">Ubicación</label>
            <input name='ubicacion[]' class='form-control mb-2' placeholder='Ubicación'>

            <label class="form-label mt-2">Modalidad</label>
            <select name='modalidad[]' class='form-select mb-2'>
                <option disabled selected>Seleccione la modalidad</option>
                <option value='Presencial'>Presencial</option>
                <option value='Remoto'>Remoto</option>
                <option value='Híbrido'>Híbrido</option>
            </select>

            <label class="form-label mt-2">Descripción</label>
            <textarea name='descripciondelempleo[]' class='form-control' placeholder='Descripción del empleo'></textarea>
        </div>`;
        document.getElementById("contenedorExperiencias").insertAdjacentHTML("beforeend", html);
    });

    document.getElementById("btnAgregarFormacion").addEventListener("click", () => {
        const html = `
        <div class='grupo-formacion border p-3 mb-3 rounded position-relative'>
            <button type='button' class='btn-close position-absolute top-0 end-0 m-2 btn-eliminar'></button>

            <label class="form-label mt-2">Institución educativa</label>
            <input name='institucion[]' class='form-control mb-2' placeholder='Institución' required>

            <label class="form-label mt-2">Título</label>
            <input name='titulo[]' class='form-control mb-2' placeholder='Título' required>

            <label class="form-label mt-2">Fecha de inicio</label>
            <input type='date' name='fecha_inicio[]' class='form-control mb-2'>

            <label class="form-label mt-2">Fecha de finalización</label>
            <input type='date' name='fecha_fin[]' class='form-control mb-2'>
        </div>`;
        document.getElementById("contenedorFormaciones").insertAdjacentHTML("beforeend", html);
    });

    document.getElementById("btnAgregarCertificado").addEventListener("click", () => {
        const html = `
        <div class='grupo-certificado border p-3 mb-3 rounded position-relative'>
            <button type='button' class='btn-close position-absolute top-0 end-0 m-2 btn-eliminar'></button>

            <label class="form-label mt-2">Nombre</label>
            <input name='nombre_certificado[]' class='form-control mb-2' placeholder='Nombre del certificado' required>

            <label class="form-label mt-2">Empresa emisora</label>
            <input name='empresa_emisora[]' class='form-control mb-2' placeholder='Empresa emisora' required>

            <label class="form-label mt-2">Fecha de expedición</label>
            <input type='date' name='fecha_expedicion[]' class='form-control mb-2'>

            <label class="form-label mt-2">Fecha de caducidad</label>
            <input type='date' name='fecha_caducidad[]' class='form-control mb-2'>

            <label class="form-label mt-2">ID de la credencial</label>
            <input name='idcredenciales[]' class='form-control mb-2' placeholder='ID de la credencial'>

            <label class="form-label mt-2">URL de la credencial</label>
            <input name='urlcredenciales[]' class='form-control mb-2' placeholder='URL de la credencial'>
        </div>`;
        document.getElementById("contenedorCertificados").insertAdjacentHTML("beforeend", html);
    });

    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("btn-eliminar")) {
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
                        Swal.fire({ icon: 'success', title: 'Eliminado', showConfirmButton: false, timer: 1000 });
                    }
                });
            }
        }
    });
</script>

</body>
</html>