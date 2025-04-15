SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE cv_certificaciones;
TRUNCATE TABLE cv_documentos;
TRUNCATE TABLE cv_experiencia;
TRUNCATE TABLE cv_formacion;
TRUNCATE TABLE cv;

TRUNCATE TABLE mensajes;
TRUNCATE TABLE conversaciones;

TRUNCATE TABLE procesos_reclutamiento;
TRUNCATE TABLE postulaciones;
TRUNCATE TABLE notificaciones;

TRUNCATE TABLE documentos;
TRUNCATE TABLE certificaciones;
TRUNCATE TABLE experiencia_laboral;
TRUNCATE TABLE formacion_academica;
TRUNCATE TABLE informacion_personal;

TRUNCATE TABLE empleos;
TRUNCATE TABLE usuarios;

SET FOREIGN_KEY_CHECKS = 1;


INSERT INTO usuarios (nombre_completo, correo_electronico, contrasena, rol, verificado)
VALUES 
('Estudiante Uno', 'estudiante1@ufide.ac.cr', '$2y$10$EN/iuGarYuxP9kJWi1h16OZFKgWj8Y2v3ukb1HTa9aLNCJaWTlxtW', 'Estudiante', 1),
('Estudiante Dos', 'estudiante2@ufide.ac.cr', '$2y$10$EN/iuGarYuxP9kJWi1h16OZFKgWj8Y2v3ukb1HTa9aLNCJaWTlxtW', 'Estudiante', 1),
('Agente Uno', 'agente1@empresa.com', '$2y$10$EN/iuGarYuxP9kJWi1h16OZFKgWj8Y2v3ukb1HTa9aLNCJaWTlxtW', 'Reclutador', 1),
('Agente Dos', 'agente2@empresa.com', '$2y$10$EN/iuGarYuxP9kJWi1h16OZFKgWj8Y2v3ukb1HTa9aLNCJaWTlxtW', 'Reclutador', 1);

INSERT INTO informacion_personal (id_usuario, nombre, apellidos, fecha_nacimiento, cedula, telefono, email, direccion, sobre_mi, estudiante_de)
VALUES
(1, 'Luis', 'Mora Castro', '2000-01-15', '101230456', '8888-1111', 'estudiante1@ufide.ac.cr', 'San José, Costa Rica', 'Apasionado por la inteligencia artificial.', 'Ingeniería en Software'),
(2, 'Andrea', 'Valverde López', '2001-06-10', '202345678', '8888-2222', 'estudiante2@ufide.ac.cr', 'Heredia, Costa Rica', 'Interesada en el desarrollo web y diseño UX.', 'Ingeniería Informática');

INSERT INTO formacion_academica (id_usuario, institucion, titulo_obtenido, fecha_inicio, fecha_finalizacion)
VALUES
(1, 'UFIDE', 'Bachillerato en Ingeniería en Software', '2019-03-01', '2024-12-01'),
(2, 'UFIDE', 'Bachillerato en Ingeniería Informática', '2020-03-01', '2025-12-01');

INSERT INTO experiencia_laboral (id_usuario, cargo, tipo_empleo, empresa, fecha_inicio, fecha_finalizacion, ubicacion, modalidad, descripcion)
VALUES
(1, 'Asistente de Desarrollo Web', 'Medio Tiempo', 'WebPro CR', '2022-06-01', '2023-02-01', 'San José', 'Híbrido', 'Apoyo en frontend con HTML, CSS y JavaScript.'),
(2, 'Soporte Técnico', 'Pasantía', 'Soluciones TI', '2023-01-10', '2023-06-30', 'Heredia', 'Presencial', 'Atención a usuarios y mantenimiento de software.');

INSERT INTO certificaciones (id_usuario, nombre, empresa_emisora, fecha_expedicion, fecha_caducidad, id_credencial, url_credencial)
VALUES
(1, 'Curso Avanzado de Python', 'Coursera', '2023-01-01', NULL, 'PY-101', 'https://coursera.org/verify/PY-101'),
(2, 'Fundamentos de Redes', 'Cisco', '2022-05-01', '2025-05-01', 'NET-202', 'https://cisco.com/certificates/NET-202');

INSERT INTO documentos (id_usuario, tipo_documento, nombre_archivo, url_archivo)
VALUES
(1, 'CV', 'LuisMora_CV.pdf', '/docs/LuisMora_CV.pdf'),
(2, 'CV', 'AndreaValverde_CV.pdf', '/docs/AndreaValverde_CV.pdf');

INSERT INTO cv (id_usuario, id_informacion_personal)
VALUES
(1, 1),
(2, 2);

INSERT INTO cv_formacion (id_cv, id_formacion) VALUES (1, 1), (2, 2);
INSERT INTO cv_experiencia (id_cv, id_experiencia) VALUES (1, 1), (2, 2);
INSERT INTO cv_certificaciones (id_cv, id_certificacion) VALUES (1, 1), (2, 2);
INSERT INTO cv_documentos (id_cv, id_documento) VALUES (1, 1), (2, 2);

INSERT INTO empleos (id_usuario_reclutador, nombre_puesto, area, descripcion, requisitos, modalidad, ubicacion, salario, fecha_publicacion, estado)
VALUES
(3, 'Desarrollador Fullstack Jr.', 'Tecnología', 
 'Desarrollar y mantener aplicaciones web usando tecnologías modernas.', 
 'Experiencia con JavaScript, Node.js, y bases de datos relacionales.', 
 'Remoto', 'San José', 850000.00, '2025-04-10', 'Activo'),

(3, 'Diseñador UX/UI', 'Diseño', 
 'Diseñar experiencias intuitivas para productos digitales.', 
 'Conocimiento en Figma, prototipado y pruebas de usuario.', 
 'Presencial', 'Cartago', 700000.00, '2025-04-11', 'Activo');

INSERT INTO empleos (id_usuario_reclutador, nombre_puesto, area, descripcion, requisitos, modalidad, ubicacion, salario, fecha_publicacion, estado)
VALUES
(4, 'Soporte Técnico Nivel 1', 'Infraestructura', 
 'Brindar soporte técnico a usuarios internos.', 
 'Conocimiento básico en redes, Windows y atención al cliente.', 
 'Híbrido', 'Heredia', 620000.00, '2025-04-12', 'Activo'),

(4, 'Analista de Datos Jr.', 'Business Intelligence', 
 'Crear dashboards e interpretar KPIs para la toma de decisiones.', 
 'Experiencia en Power BI, SQL, y análisis estadístico.', 
 'Remoto', 'Alajuela', 750000.00, '2025-04-12', 'Activo');

INSERT INTO postulaciones (id_usuario_estudiante, id_empleo, estado)
VALUES
(1, 1, 'Postulado'), -- Desarrollador Fullstack Jr.
(1, 3, 'Postulado'); -- Soporte Técnico Nivel 1

INSERT INTO postulaciones (id_usuario_estudiante, id_empleo, estado)
VALUES
(2, 2, 'Postulado'), -- Diseñador UX/UI
(2, 4, 'Postulado'); -- Analista de Datos Jr.

INSERT INTO procesos_reclutamiento (id_postulacion, id_reclutador_asignado, observaciones, alerta_enviada)
VALUES
(1, 3, 'Revisar conocimientos en Node.js y experiencia en proyectos personales.', 1),
(2, 3, 'Perfil interesante para diseño. Solicitar portafolio.', 0);

INSERT INTO procesos_reclutamiento (id_postulacion, id_reclutador_asignado, observaciones, alerta_enviada)
VALUES
(3, 4, 'Experiencia previa en soporte puede ser útil. Evaluar actitud.', 1),
(4, 4, 'Verificar conocimientos en Power BI y SQL en entrevista.', 0);
