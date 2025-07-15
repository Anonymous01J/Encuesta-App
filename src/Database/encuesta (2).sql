-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-07-2025 a las 07:19:03
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `encuesta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci,
  `tipo` enum('SUS','NPS','CSAT','OTHER') COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `nombre`, `descripcion`, `tipo`, `estado`) VALUES
(1, 'Evaluación de Usabilidad', 'Encuesta estándar para medir usabilidad percibida', 'SUS', 1),
(2, 'Satisfacción Post-Compra', 'Medición de satisfacción del cliente', 'CSAT', 1),
(3, 'Lealtad de Clientes', 'Medición de probabilidad de recomendación', 'NPS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones_respuesta`
--

CREATE TABLE `opciones_respuesta` (
  `id` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `valor` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `peso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `opciones_respuesta`
--

INSERT INTO `opciones_respuesta` (`id`, `id_pregunta`, `valor`, `peso`) VALUES
(1, 1, 'Totalmente en desacuerdo', 1),
(2, 2, 'Totalmente en desacuerdo', 1),
(3, 3, 'Totalmente en desacuerdo', 1),
(4, 4, 'Totalmente en desacuerdo', 1),
(5, 5, 'Totalmente en desacuerdo', 1),
(6, 6, 'Totalmente en desacuerdo', 1),
(7, 7, 'Totalmente en desacuerdo', 1),
(8, 8, 'Totalmente en desacuerdo', 1),
(9, 9, 'Totalmente en desacuerdo', 1),
(10, 10, 'Totalmente en desacuerdo', 1),
(11, 1, 'En desacuerdo', 2),
(12, 2, 'En desacuerdo', 2),
(13, 3, 'En desacuerdo', 2),
(14, 4, 'En desacuerdo', 2),
(15, 5, 'En desacuerdo', 2),
(16, 6, 'En desacuerdo', 2),
(17, 7, 'En desacuerdo', 2),
(18, 8, 'En desacuerdo', 2),
(19, 9, 'En desacuerdo', 2),
(20, 10, 'En desacuerdo', 2),
(21, 1, 'Neutral', 3),
(22, 2, 'Neutral', 3),
(23, 3, 'Neutral', 3),
(24, 4, 'Neutral', 3),
(25, 5, 'Neutral', 3),
(26, 6, 'Neutral', 3),
(27, 7, 'Neutral', 3),
(28, 8, 'Neutral', 3),
(29, 9, 'Neutral', 3),
(30, 10, 'Neutral', 3),
(31, 1, 'De acuerdo', 4),
(32, 2, 'De acuerdo', 4),
(33, 3, 'De acuerdo', 4),
(34, 4, 'De acuerdo', 4),
(35, 5, 'De acuerdo', 4),
(36, 6, 'De acuerdo', 4),
(37, 7, 'De acuerdo', 4),
(38, 8, 'De acuerdo', 4),
(39, 9, 'De acuerdo', 4),
(40, 10, 'De acuerdo', 4),
(41, 1, 'Totalmente de acuerdo', 5),
(42, 2, 'Totalmente de acuerdo', 5),
(43, 3, 'Totalmente de acuerdo', 5),
(44, 4, 'Totalmente de acuerdo', 5),
(45, 5, 'Totalmente de acuerdo', 5),
(46, 6, 'Totalmente de acuerdo', 5),
(47, 7, 'Totalmente de acuerdo', 5),
(48, 8, 'Totalmente de acuerdo', 5),
(49, 9, 'Totalmente de acuerdo', 5),
(50, 10, 'Totalmente de acuerdo', 5),
(64, 11, 'Muy insatisfecho', 1),
(65, 11, 'Insatisfecho', 2),
(66, 11, 'Neutral', 3),
(67, 11, 'Satisfecho', 4),
(68, 11, 'Muy satisfecho', 5),
(71, 12, '0', 0),
(72, 12, '1', 1),
(73, 12, '2', 2),
(74, 12, '3', 3),
(75, 12, '4', 4),
(76, 12, '5', 5),
(77, 12, '6', 6),
(78, 12, '7', 7),
(79, 12, '8', 8),
(80, 12, '9', 9),
(81, 12, '10', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `id_encuesta` int(11) NOT NULL,
  `texto` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_respuesta` enum('escala_5','escala_10','si_no','texto_libre','opcion_multiple') COLLATE utf8mb4_spanish2_ci NOT NULL,
  `orden` int(11) DEFAULT '0',
  `requerido` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `id_encuesta`, `texto`, `tipo_respuesta`, `orden`, `requerido`) VALUES
(1, 1, 'Creo que me gustaría usar este sitio web frecuentemente', 'escala_5', 1, 1),
(2, 1, 'Encontré el sitio innecesariamente complejo', 'escala_5', 2, 1),
(3, 1, 'Me pareció fácil de usar', 'escala_5', 3, 1),
(4, 1, 'Creo que necesitaría ayuda técnica para usarlo', 'escala_5', 4, 1),
(5, 1, 'Las funciones están bien integradas', 'escala_5', 5, 1),
(6, 1, 'Hubo demasiada inconsistencia', 'escala_5', 6, 1),
(7, 1, 'Imagino que la mayoría aprendería a usarlo rápidamente', 'escala_5', 7, 1),
(8, 1, 'Lo encontré muy engorroso', 'escala_5', 8, 1),
(9, 1, 'Me sentí confiado usándolo', 'escala_5', 9, 1),
(10, 1, 'Necesité aprender muchas cosas antes de usarlo', 'escala_5', 10, 1),
(11, 2, '¿Qué tan satisfecho estás con tu experiencia de compra?', 'escala_5', 1, 1),
(12, 3, '¿Qué tan probable es que recomiendes nuestro sitio a un amigo o colega?', 'escala_10', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `id_usuario_` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `id_opcion` int(11) DEFAULT NULL,
  `valor_texto` text COLLATE utf8mb4_spanish2_ci,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `opciones_respuesta`
--
ALTER TABLE `opciones_respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_id` (`id_pregunta`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `encuesta_id` (`id_encuesta`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`id_usuario_`),
  ADD KEY `pregunta_id` (`id_pregunta`),
  ADD KEY `opcion_id` (`id_opcion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `opciones_respuesta`
--
ALTER TABLE `opciones_respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `opciones_respuesta`
--
ALTER TABLE `opciones_respuesta`
  ADD CONSTRAINT `opciones_respuesta_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`id_encuesta`) REFERENCES `encuestas` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`id_usuario_`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id`),
  ADD CONSTRAINT `respuestas_ibfk_3` FOREIGN KEY (`id_opcion`) REFERENCES `opciones_respuesta` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
