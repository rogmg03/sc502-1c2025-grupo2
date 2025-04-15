
CREATE DATABASE IF NOT EXISTS `sistema_reclutamiento`;
USE `sistema_reclutamiento`;

DROP TABLE IF EXISTS `certificaciones`;
CREATE TABLE `certificaciones` (
  `id_certificacion` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `empresa_emisora` varchar(100) DEFAULT NULL,
  `fecha_expedicion` date DEFAULT NULL,
  `fecha_caducidad` date DEFAULT NULL,
  `id_credencial` varchar(100) DEFAULT NULL,
  `url_credencial` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_certificacion`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `certificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

DROP TABLE IF EXISTS `conversaciones`;
CREATE TABLE `conversaciones` (
  id_conversacion INT AUTO_INCREMENT PRIMARY KEY,
  usuario1_id INT NOT NULL,
  usuario2_id INT NOT NULL,
  fecha_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE(usuario1_id, usuario2_id),
  CONSTRAINT fk_usuario1 FOREIGN KEY (usuario1_id) REFERENCES usuarios(id_usuario),
  CONSTRAINT fk_usuario2 FOREIGN KEY (usuario2_id) REFERENCES usuarios(id_usuario)
);

DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos` (
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `tipo_documento` enum('CV','Titulo','Certificacion','Pasaporte','Otro') NOT NULL,
  `nombre_archivo` varchar(255) DEFAULT NULL,
  `url_archivo` varchar(255) DEFAULT NULL,
  `fecha_subida` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_documento`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

DROP TABLE IF EXISTS `empleos`;
CREATE TABLE `empleos` (
  `id_empleo` int NOT NULL AUTO_INCREMENT,
  `id_usuario_reclutador` int NOT NULL,
  `nombre_puesto` varchar(100) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `requisitos` text,
  `modalidad` enum('Presencial','Remoto','Híbrido') NOT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  PRIMARY KEY (`id_empleo`),
  KEY `id_usuario_reclutador` (`id_usuario_reclutador`),
  CONSTRAINT `empleos_ibfk_1` FOREIGN KEY (`id_usuario_reclutador`) REFERENCES `usuarios` (`id_usuario`)
);

DROP TABLE IF EXISTS `experiencia_laboral`;
CREATE TABLE `experiencia_laboral` (
  `id_experiencia` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `tipo_empleo` varchar(50) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_finalizacion` date DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `modalidad` enum('Presencial','Remoto','Híbrido') DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`id_experiencia`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `experiencia_laboral_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

DROP TABLE IF EXISTS `formacion_academica`;
CREATE TABLE `formacion_academica` (
  `id_formacion` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `institucion` varchar(100) DEFAULT NULL,
  `titulo_obtenido` varchar(100) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_finalizacion` date DEFAULT NULL,
  PRIMARY KEY (`id_formacion`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `formacion_academica_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

DROP TABLE IF EXISTS `informacion_personal`;
CREATE TABLE `informacion_personal` (
  `id_personal` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` text,
  `sobre_mi` text,
  `estudiante_de` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_personal`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `informacion_personal_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes` (
  `id_mensaje` int NOT NULL AUTO_INCREMENT,
  `id_conversacion` int NOT NULL,
  `id_usuario_emisor` int NOT NULL,
  `contenido` text NOT NULL,
  `leido` tinyint(1) DEFAULT '0',
  `fecha_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mensaje`),
  KEY `id_conversacion` (`id_conversacion`),
  KEY `id_usuario_emisor` (`id_usuario_emisor`),
  CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_conversacion`) REFERENCES `conversaciones` (`id_conversacion`),
  CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_usuario_emisor`) REFERENCES `usuarios` (`id_usuario`)
);

DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE `notificaciones` (
  `id_notificacion` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `mensaje` text,
  `tipo` enum('Sistema','Mensaje','Proceso','Otro') DEFAULT 'Sistema',
  `leido` tinyint(1) DEFAULT '0',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notificacion`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

DROP TABLE IF EXISTS `postulaciones`;
CREATE TABLE `postulaciones` (
  `id_postulacion` int NOT NULL AUTO_INCREMENT,
  `id_usuario_estudiante` int NOT NULL,
  `id_empleo` int NOT NULL,
  `fecha_postulacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('Postulado','En Proceso','Seleccionado','Rechazado') DEFAULT 'Postulado',
  PRIMARY KEY (`id_postulacion`),
  KEY `id_usuario_estudiante` (`id_usuario_estudiante`),
  KEY `id_empleo` (`id_empleo`),
  CONSTRAINT `postulaciones_ibfk_1` FOREIGN KEY (`id_usuario_estudiante`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `postulaciones_ibfk_2` FOREIGN KEY (`id_empleo`) REFERENCES `empleos` (`id_empleo`)
);

DROP TABLE IF EXISTS `procesos_reclutamiento`;
CREATE TABLE `procesos_reclutamiento` (
  `id_proceso` int NOT NULL AUTO_INCREMENT,
  `id_postulacion` int NOT NULL,
  `id_reclutador_asignado` int NOT NULL,
  `fecha_asignacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `observaciones` text,
  `alerta_enviada` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_proceso`),
  KEY `id_postulacion` (`id_postulacion`),
  KEY `id_reclutador_asignado` (`id_reclutador_asignado`),
  CONSTRAINT `procesos_reclutamiento_ibfk_1` FOREIGN KEY (`id_postulacion`) REFERENCES `postulaciones` (`id_postulacion`),
  CONSTRAINT `procesos_reclutamiento_ibfk_2` FOREIGN KEY (`id_reclutador_asignado`) REFERENCES `usuarios` (`id_usuario`)
);

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('Estudiante','Reclutador') NOT NULL,
  `verificado` tinyint(1) DEFAULT '0',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`)
);

DROP TABLE IF EXISTS `cv`;
CREATE TABLE `cv` (
  id_cv INT NOT NULL AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  id_informacion_personal INT NOT NULL,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  activo BOOLEAN DEFAULT 0,
  PRIMARY KEY (id_cv),
  UNIQUE (id_usuario),
  CONSTRAINT fk_cv_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
  CONSTRAINT fk_cv_info_personal FOREIGN KEY (id_informacion_personal) REFERENCES informacion_personal(id_personal)
);
-- Relación CV - Certificaciones
DROP TABLE IF EXISTS `cv_certificaciones`;
CREATE TABLE `cv_certificaciones` (
  id_cv INT NOT NULL,
  id_certificacion INT NOT NULL,
  PRIMARY KEY (id_cv, id_certificacion),
  CONSTRAINT fk_cv_cert FOREIGN KEY (id_cv) REFERENCES cv(id_cv),
  CONSTRAINT fk_cert_cv FOREIGN KEY (id_certificacion) REFERENCES certificaciones(id_certificacion)
);

-- Relación CV - Documentos
DROP TABLE IF EXISTS `cv_documentos`;
CREATE TABLE `cv_documentos` (
  id_cv INT NOT NULL,
  id_documento INT NOT NULL,
  PRIMARY KEY (id_cv, id_documento),
  CONSTRAINT fk_cv_doc FOREIGN KEY (id_cv) REFERENCES cv(id_cv),
  CONSTRAINT fk_doc_cv FOREIGN KEY (id_documento) REFERENCES documentos(id_documento)
);

-- Relación CV - Experiencia Laboral
DROP TABLE IF EXISTS `cv_experiencia`;
CREATE TABLE `cv_experiencia` (
  id_cv INT NOT NULL,
  id_experiencia INT NOT NULL,
  PRIMARY KEY (id_cv, id_experiencia),
  CONSTRAINT fk_cv_exp FOREIGN KEY (id_cv) REFERENCES cv(id_cv),
  CONSTRAINT fk_exp_cv FOREIGN KEY (id_experiencia) REFERENCES experiencia_laboral(id_experiencia)
);

-- Relación CV - Formación Académica
DROP TABLE IF EXISTS `cv_formacion`;
CREATE TABLE `cv_formacion` (
  id_cv INT NOT NULL,
  id_formacion INT NOT NULL,
  PRIMARY KEY (id_cv, id_formacion),
  CONSTRAINT fk_cv_form FOREIGN KEY (id_cv) REFERENCES cv(id_cv),
  CONSTRAINT fk_form_cv FOREIGN KEY (id_formacion) REFERENCES formacion_academica(id_formacion)
);
