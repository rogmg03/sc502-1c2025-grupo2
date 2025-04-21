<?php
use app\controllers\chatController;

require_once __DIR__ . '/../../../config/server.php';


$chatController = new chatController();
$idUsuario = $_SESSION['id'] ?? 1;

$conversaciones = $chatController->obtenerConversaciones($idUsuario);

$mensajes = [];
$receptor = null;

if (isset($_GET['id'])) {
    $receptor = (int) $_GET['id'];
    $mensajes = $chatController->obtenerMensajesConversacion($idUsuario, $receptor);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Chat Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .chat-list {
            height: 85vh;
            overflow-y: auto;
        }

        .chat-body {
            height: 70vh;
            overflow-y: scroll;
        }

        .chat-footer input {
            flex-grow: 1;
        }
    </style>
</head>

<body>

    <div class="vertical-nav">
        <img src="<?php echo APP_URL; ?>app/views/img/userImg.png" alt="Logo" />
        <div class="usuario d-flex align-items-center justify-content-center" style="gap: 8px;">
            <span><?php echo $_SESSION['nombre']; ?></span>
            <a href="<?php echo APP_URL; ?>s-edit-info/" title="Editar perfil">
                <i class="bi bi-pencil-square" style="color: white; font-size: 1.2rem;"></i>
            </a>
        </div>
        <div class="correo"><?php echo $_SESSION['correo']; ?></div>
        <hr class="horizontal-divider" />
        <a href="<?php echo APP_URL; ?>s-home/">Inicio</a>
        <a href="<?php echo APP_URL; ?>s-view-jobs/">Lista de empleos</a>
        <a href="<?php echo APP_URL; ?>s-student-list/">Alumnos Disponibles</a>
        <a href="<?php echo APP_URL; ?>s-postings/">Postulaciones</a>
        <a href="<?php echo APP_URL; ?>s-chat/" class="link-activo">Chat Alumnos</a>
        <a href="<?php echo APP_URL; ?>logOut/" class="btn btn-secondary logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Chat Alumnos</h2>
            <button class="btn btn-dark btn-sm" dats-bs-toggle="modal" dats-bs-target="#modalAgregarConversacion">
                <i class="bi bi-plus-circle me-1"></i> Iniciar conversación
            </button>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <ul class="list-group chat-list">
                    <?php foreach ($conversaciones as $conv): ?>
                        <li
                            class="list-group-item <?php echo ($receptor == $conv['id_contacto']) ? 'active text-white' : ''; ?>">
                            <a href="?id=<?= $conv['id_contacto'] ?>"
                                class="text-decoration-none <?php echo ($receptor == $conv['id_contacto']) ? 'text-white' : ''; ?>">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong><?= $conv['nombre_contacto'] ?></strong><br>
                                        <small class="text-muted"><?= $conv['ultimo_mensaje'] ?? 'Sin mensajes' ?></small>
                                    </div>
                                    <div>
                                        <small
                                            class="text-muted"><?= $conv['fecha_envio'] ? date('H:i', strtotime($conv['fecha_envio'])) : '' ?></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Conversación</div>
                    <div class="card-body chat-body">
                        <?php if ($receptor && count($mensajes) > 0): ?>
                            <?php foreach ($mensajes as $msg): ?>
                                <?php if ($msg['id_usuario_emisor'] == $idUsuario): ?>
                                    <div class="text-end mb-2">
                                        <span class="badge bg-primary"><?= htmlspecialchars($msg['contenido']) ?></span><br>
                                        <small class="text-muted"><?= date('d/m H:i', strtotime($msg['fecha_envio'])) ?></small>
                                    </div>
                                <?php else: ?>
                                    <div class="text-start mb-2">
                                        <span class="badge bg-secondary"><?= htmlspecialchars($msg['contenido']) ?></span><br>
                                        <small class="text-muted"><?= date('d/m H:i', strtotime($msg['fecha_envio'])) ?></small>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php elseif ($receptor): ?>
                            <p class="text-center">No hay mensajes con este usuario aún.</p>
                        <?php else: ?>
                            <p class="text-center">Selecciona una conversación para comenzar.</p>
                        <?php endif; ?>
                    </div>
                    <?php if ($receptor): ?>
                        <form method="POST" action="<?php echo APP_URL; ?>app/controllers/postMensajeController.php"
                            class="card-footer d-flex chat-footer">
                            <input type="hidden" name="receptor" value="<?= $receptor ?>">
                            <input type="text" name="contenido" class="form-control me-2"
                                placeholder="Escribe un mensaje..." required>
                            <button class="btn btn-primary">Enviar</button>
                        </form>


                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para iniciar conversación -->
    <div class="modal fade" id="modalAgregarConversacion" tabindex="-1" aris-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buscar estudiante para chatear</h5>
                    <button type="button" class="btn-close" dats-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" id="inputBuscarEstudiante"
                        placeholder="Buscar por nombre o correo...">
                    <ul class="list-group" id="listaResultadosEstudiantes"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" dats-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmarChat" disabled>Iniciar
                        conversación</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Script para buscar estudiantes -->
    <script>
        let estudianteSeleccionado = null;

        document.getElementById('inputBuscarEstudiante').addEventListener('input', function () {
            const query = this.value.trim();
            const lista = document.getElementById('listaResultadosEstudiantes');
            const boton = document.getElementById('btnConfirmarChat');
            estudianteSeleccionado = null;
            boton.disabled = true;

            if (query.length < 2) {
                lista.innerHTML = '';
                return;
            }

            fetch("<?= APP_URL ?>app/ajax/buscarEstudiantesAjax.php?q=" + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    lista.innerHTML = '';
                    if (data.length === 0) {
                        lista.innerHTML = '<li class="list-group-item text-muted">No se encontraron estudiantes</li>';
                        return;
                    }

                    data.forEach(est => {
                        const item = document.createElement('li');
                        item.className = "list-group-item list-group-item-action";
                        item.innerHTML = `<strong>${est.nombre_completo}</strong><br><small>${est.correo_electronico}</small>`;
                        item.onclick = function () {
                            estudianteSeleccionado = est.id_usuario;
                            boton.disabled = false;

                            // resaltar el seleccionado
                            document.querySelectorAll("#listaResultadosEstudiantes .list-group-item").forEach(li => li.classList.remove("active"));
                            item.classList.add("active");
                        };
                        lista.appendChild(item);
                    });
                });
        });

        document.getElementById('btnConfirmarChat').addEventListener('click', function () {
            if (estudianteSeleccionado) {
                window.location.href = "<?= APP_URL ?>s-chat/?id=" + estudianteSeleccionado;
            }
        });
    </script>
    <?php if (isset($_SESSION['mensaje_enviado'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?= $_SESSION['mensaje_enviado'] ?>',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        <?php unset($_SESSION['mensaje_enviado']); endif; ?>

    <?php if (isset($_SESSION['chat_error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= $_SESSION['chat_error'] ?>',
                confirmButtonText: 'Ok'
            });
        </script>
        <?php unset($_SESSION['chat_error']); endif; ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>