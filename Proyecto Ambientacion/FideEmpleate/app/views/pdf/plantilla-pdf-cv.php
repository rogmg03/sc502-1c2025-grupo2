<style>
    body { font-family: Arial; }
    h1 { color: #2b338c; }
    .section { margin-bottom: 20px; }
</style>

<h1><?= $datos['info_personal']['nombre'] . " " . $datos['info_personal']['apellidos'] ?></h1>
<p><strong>Email:</strong> <?= $datos['info_personal']['email'] ?></p>
<p><strong>Teléfono:</strong> <?= $datos['info_personal']['telefono'] ?></p>
<p><strong>Carrera:</strong> <?= $datos['info_personal']['estudiante_de'] ?></p>
<p><strong>Sobre mí:</strong> <?= $datos['info_personal']['sobre_mi'] ?></p>

<div class="section">
    <h2>Experiencia Laboral</h2>
    <?php foreach ($datos['experiencia'] as $exp): ?>
        <p><strong><?= $exp['cargo'] ?></strong> en <?= $exp['empresa'] ?> (<?= $exp['fecha_inicio'] ?> a <?= $exp['fecha_finalizacion'] ?>)</p>
        <p><?= $exp['descripcion'] ?></p>
    <?php endforeach; ?>
</div>

<!-- Similar para Formación y Certificaciones -->
