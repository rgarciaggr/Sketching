-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2018 a las 17:17:17
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sketching`
--
CREATE DATABASE IF NOT EXISTS `sketching` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sketching`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE `acceso` (
  `id_usuario` int(11) NOT NULL,
  `password` varchar(64) NOT NULL,
  `ultimo_acceso` datetime NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`id_usuario`, `password`, `ultimo_acceso`, `rol`) VALUES
(1, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2018-05-13 00:00:00', 0),
(5, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2018-05-17 02:26:31', 1),
(30, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2018-05-17 08:47:09', 1),
(32, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2018-05-17 09:44:35', 1),
(34, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2018-05-17 10:01:03', 1),
(39, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2018-05-21 02:01:53', 1),
(40, 'f2c28760605693c73d3855b73769d606c1f5dbbebcb1f5f2fd951fb6b8ef2d36', '2018-05-21 08:46:47', 1),
(41, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2018-05-24 07:16:53', 1),
(43, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2018-05-30 07:56:13', 0),
(45, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2018-05-30 08:17:53', 1),
(46, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2018-05-30 08:59:44', 1),
(47, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2018-05-31 08:37:57', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria`
--

CREATE TABLE `galeria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `autor` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `visitas` int(11) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `galeria`
--

INSERT INTO `galeria` (`id`, `nombre`, `descripcion`, `autor`, `fecha_creacion`, `visitas`, `tipo`) VALUES
(41, 'Best gallery ever!!1!', '', 43, '2018-05-30 07:59:42', 116, 0),
(42, 'Just another gallery', 'such a stupid description', 43, '2018-05-30 08:04:58', 61, 0),
(58, 'Prueba buena', 'Prueba imagen ddbb', 1, '2018-06-05 12:48:35', 27, 5),
(59, 'Galeria de 6 semanal', 'Galeria semanal para los fans', 1, '2018-06-06 01:30:31', 21, 3),
(66, 'Galeria de pruebas', 'Galeria de pruebas ', 34, '2018-06-06 08:34:33', 6, 0),
(71, 'Galeria gratuita', 'Galeria de muestras', 5, '2018-06-06 10:54:05', 4, 0),
(72, 'Private gallery', 'Just for the only one', 30, '2018-06-06 10:55:14', 3, 5),
(73, 'Galeria de pruebas', 'Galeria para rellenar', 1, '2018-06-07 07:20:25', 0, 5),
(74, 'Galeria publica ', 'galeria para pruebas', 1, '2018-06-07 07:20:58', 6, 0),
(75, 'Prueba buena', 'Galeria niceeeeeeeeeeeeeeeee', 1, '2018-06-07 07:21:27', 1, 1),
(76, 'Galeria de 6', 'Galeria probar', 1, '2018-06-07 07:22:29', 6, 3),
(77, 'Galeria semanal', 'Galeria par fans', 34, '2018-06-08 03:59:16', 1, 3),
(78, 'Galeria de pruebas', 'Hello world', 39, '2018-06-08 05:00:47', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `link` varchar(40) NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_galeria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`id`, `nombre`, `link`, `fecha_subida`, `id_galeria`) VALUES
(10, 'contact-1600x900.jpg', '0.jpg', '2018-06-04 22:48:35', 58),
(11, 'dark-souls-iii.jpg', '1.jpg', '2018-06-04 22:48:35', 58),
(12, 'debonair_vi_wallpaper.jpg', '2.jpg', '2018-06-04 22:48:35', 58),
(13, 'digimon-ova1.jpg', '3.jpg', '2018-06-04 22:48:35', 58),
(14, 'digimon-ova2.jpg', '4.jpg', '2018-06-04 22:48:35', 58),
(15, '0.jpg', '0.jpg', '2018-06-05 23:27:16', 41),
(16, '1.jpg', '1.jpg', '2018-06-05 23:27:16', 41),
(17, '2.png', '2.png', '2018-06-05 23:27:50', 41),
(18, '3.jpg', '3.jpg', '2018-06-05 23:27:50', 41),
(19, '0.jpg', '0.jpg', '2018-06-05 23:28:38', 42),
(20, '1.jpg', '1.jpg', '2018-06-05 23:28:38', 42),
(21, 'BioShock-Infinite-Wallpaper.jpg', '0.jpg', '2018-06-05 23:30:31', 59),
(22, 'bioshock-infinite-wallpaper-6.jpg', '1.jpg', '2018-06-05 23:30:31', 59),
(23, 'blood-moon-diana.jpg', '2.jpg', '2018-06-05 23:30:31', 59),
(24, 'bonefire.jpg', '3.jpg', '2018-06-05 23:30:31', 59),
(25, 'Breaking-Bad-I-won.jpg', '4.jpg', '2018-06-05 23:30:31', 59),
(26, 'bring-me-the-horizon-bmth.jpg', '5.jpg', '2018-06-05 23:30:31', 59),
(27, 'cat starcraft.jpg', '6.jpg', '2018-06-05 23:30:31', 59),
(28, 'cheshire.jpg', '7.jpg', '2018-06-05 23:30:31', 59),
(29, 'contact-1600x900.jpg', '8.jpg', '2018-06-05 23:30:31', 59),
(30, 'dark-souls-iii.jpg', '9.jpg', '2018-06-05 23:30:31', 59),
(31, 'debonair_vi_wallpaper.jpg', '10.jpg', '2018-06-05 23:30:31', 59),
(32, 'digimon-ova1.jpg', '11.jpg', '2018-06-05 23:30:31', 59),
(33, 'digimon-ova2.jpg', '12.jpg', '2018-06-05 23:30:31', 59),
(57, 'bioshock 3.jpg', '0.jpg', '2018-06-06 18:34:33', 66),
(58, 'BioShock-Infinite-Wallpaper.jpg', '1.jpg', '2018-06-06 18:34:33', 66),
(59, 'bioshock-infinite-wallpaper-6.jpg', '2.jpg', '2018-06-06 18:34:33', 66),
(60, 'blood-moon-diana.jpg', '3.jpg', '2018-06-06 18:34:33', 66),
(79, 'bioshock 3.jpg', '0.jpg', '2018-06-06 20:54:05', 71),
(80, 'BioShock-Infinite-Wallpaper.jpg', '1.jpg', '2018-06-06 20:54:05', 71),
(81, 'bioshock-infinite-wallpaper-6.jpg', '2.jpg', '2018-06-06 20:54:05', 71),
(82, 'blood-moon-diana.jpg', '3.jpg', '2018-06-06 20:54:05', 71),
(83, 'bonefire.jpg', '4.jpg', '2018-06-06 20:54:05', 71),
(84, 'cat starcraft.jpg', '0.jpg', '2018-06-06 20:55:14', 72),
(85, 'cheshire.jpg', '1.jpg', '2018-06-06 20:55:14', 72),
(86, 'contact-1600x900.jpg', '2.jpg', '2018-06-06 20:55:14', 72),
(87, 'dark-souls-iii.jpg', '3.jpg', '2018-06-06 20:55:14', 72),
(88, 'BioShock-Infinite-Wallpaper.jpg', '0.jpg', '2018-06-07 17:20:25', 73),
(89, 'bioshock-infinite-wallpaper-6.jpg', '1.jpg', '2018-06-07 17:20:25', 73),
(90, 'blood-moon-diana.jpg', '2.jpg', '2018-06-07 17:20:25', 73),
(91, 'bonefire.jpg', '3.jpg', '2018-06-07 17:20:25', 73),
(92, '3m3wCGC.jpg', '0.jpg', '2018-06-07 17:20:58', 74),
(93, '5cmps.jpg', '1.jpg', '2018-06-07 17:20:59', 74),
(94, '1489012262696.jpg', '2.jpg', '2018-06-07 17:20:59', 74),
(95, '1489755432370.png', '3.png', '2018-06-07 17:20:59', 74),
(96, 'anime_protagonist-1600x900.jpg', '4.jpg', '2018-06-07 17:20:59', 74),
(97, 'arcade theme.jpg', '5.jpg', '2018-06-07 17:20:59', 74),
(98, 'minas_tirith.jpg', '0.jpg', '2018-06-07 17:21:27', 75),
(99, 'mirror edge.jpg', '1.jpg', '2018-06-07 17:21:27', 75),
(100, 'oblivion_keyblade.jpg', '2.jpg', '2018-06-07 17:21:27', 75),
(101, 'observation_deck-wide.jpg', '3.jpg', '2018-06-07 17:21:27', 75),
(102, 'digimon-ova1.jpg', '0.jpg', '2018-06-07 17:22:29', 76),
(103, 'digimon-ova2.jpg', '1.jpg', '2018-06-07 17:22:29', 76),
(104, 'digimon-ova3.jpg', '2.jpg', '2018-06-07 17:22:29', 76),
(105, 'digimon-ova4.jpg', '3.jpg', '2018-06-07 17:22:29', 76),
(106, 'digimon-tri.jpg', '4.jpg', '2018-06-07 17:22:29', 76),
(107, 'cat starcraft.jpg', '0.jpg', '2018-06-08 13:59:16', 77),
(108, 'cheshire.jpg', '1.jpg', '2018-06-08 13:59:16', 77),
(109, 'contact-1600x900.jpg', '2.jpg', '2018-06-08 13:59:16', 77),
(110, 'dark-souls-iii.jpg', '3.jpg', '2018-06-08 13:59:16', 77),
(111, '5cmps.jpg', '0.jpg', '2018-06-08 15:00:47', 78),
(112, '1489012262696.jpg', '1.jpg', '2018-06-08 15:00:47', 78),
(113, '1489755432370.png', '2.png', '2018-06-08 15:00:47', 78);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `estado` enum('pending','payed','cancel') NOT NULL,
  `emisor` int(11) NOT NULL,
  `destinatario` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `estado`, `emisor`, `destinatario`, `cantidad`, `fecha`) VALUES
(2, 'pending', 30, 1, '5.00', '2018-06-02 16:22:43'),
(3, 'pending', 5, 1, '3.00', '2018-06-06 19:35:19'),
(4, 'cancel', 1, 34, '1.00', '2018-06-06 19:31:06'),
(5, 'payed', 34, 1, '3.00', '2018-06-02 16:23:35'),
(11, 'pending', 1, 43, '3.00', '2018-06-06 19:29:40'),
(12, 'payed', 34, 1, '3.00', '2018-06-06 19:31:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes_sociales`
--

CREATE TABLE `redes_sociales` (
  `id_usuario` int(11) NOT NULL,
  `twitter` varchar(50) DEFAULT NULL,
  `instagram` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `redes_sociales`
--

INSERT INTO `redes_sociales` (`id_usuario`, `twitter`, `instagram`) VALUES
(1, 'archillect', 'archillectgram'),
(30, 'ggrobert10', 'ggrobert10'),
(32, 'CarlosGonzlez42', 'maveriick95');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subs`
--

CREATE TABLE `subs` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `subs`
--

INSERT INTO `subs` (`id`, `id_user`, `id_autor`, `tipo`) VALUES
(1, 30, 1, 5),
(2, 5, 1, 3),
(5, 39, 1, 0),
(12, 1, 34, 1),
(22, 34, 1, 3),
(27, 1, 43, 3),
(29, 45, 1, 0),
(30, 32, 1, 0),
(31, 34, 43, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `birth_date` date NOT NULL,
  `profile_image` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `nombre`, `apellido`, `birth_date`, `profile_image`, `descripcion`) VALUES
(1, 'kurokawa', 'rgkurokawa@gmail.com', 'Roberto', 'Garcia', '1993-11-15', 'kurokawa.jpg', 'Me apasiona el dibujo y quiero compartilo con los demas.'),
(5, 'ggrobert', 'robert5_gg@hotmail.com', 'Alejandro', 'Gordillo', '1968-05-02', 'ggrobert.jpg', ''),
(30, 'rgarciag', 'robert6_gg@hotmail.com', 'Jose', 'Broncano', '1978-05-02', 'rgarciag.jpg', 'Descripcion de rgarciag'),
(32, 'cargonben1', 'carlo64@hotmail.com', 'Carlos', 'CASd', '1987-05-05', 'cargonben1.jpg', 'asdaf'),
(34, 'kurokawa10', 'robert_gg@hotmail.com', 'John', 'Smith', '1987-05-05', 'kurokawa10.jpg', 'Descripcion Lorem ipsum'),
(39, 'rgarciag11', 'robert5_gg@hotmail.com2', 'Roberto', 'García', '1999-05-02', 'rgarciag11.jpg', 'Fanatico del dibujo, ayudame a ayudar a ayudate.'),
(40, 'Hasam', 'jsmjsmjsm17@gmail.com', 'Jorge', 'Sánchez Muñoz', '1997-05-06', '', ''),
(41, 'Infante', 'ainfanter01@gmail.com', 'PichaBrava69', 'PichaBrava69', '1993-12-29', 'Infante.jpg', ''),
(43, 'Rodolfo', 'rodolfoelgolfo@gmail.com', 'Rodolfo', 'Golfo', '1999-01-01', 'Rodolfo.jpg', NULL),
(45, 'roberto', 'robert5_gg@hotmail.c', 'Roberto', 'Gordillo', '1987-12-12', '', NULL),
(46, 'RosaLaCosa', 'rosalacosa@gmail.com', 'Rosa', 'Cosa', '0008-05-09', 'RosaLaCosa.gif', NULL),
(47, 'jantonio', 'guijarroguijarro@hotmail.com', 'José Antonio', 'Guijarro', '1994-05-01', 'jantonio.jpg', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas_dia`
--

CREATE TABLE `visitas_dia` (
  `id` int(11) NOT NULL,
  `autor` int(11) NOT NULL,
  `visitas` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `visitas_dia`
--

INSERT INTO `visitas_dia` (`id`, `autor`, `visitas`, `fecha`) VALUES
(5, 43, 25, '2018-06-04'),
(11, 43, 20, '2018-06-01'),
(12, 1, 10, '2018-05-31'),
(13, 43, 15, '2018-05-30'),
(14, 1, 5, '2018-05-28'),
(17, 43, 29, '2018-06-05'),
(18, 1, 15, '2018-06-06'),
(19, 43, 30, '2018-06-06'),
(20, 34, 27, '2018-06-06'),
(23, 5, 3, '2018-06-06'),
(24, 30, 2, '2018-06-06'),
(25, 30, 1, '2018-06-07'),
(26, 1, 21, '2018-06-07'),
(27, 43, 48, '2018-06-07'),
(28, 5, 1, '2018-06-07'),
(29, 1, 4, '2018-06-08'),
(30, 34, 2, '2018-06-08');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor` (`autor`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imagen_ibfk_1` (`id_galeria`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pagos_ibfk_1` (`emisor`),
  ADD KEY `pagos_ibfk_2` (`destinatario`);

--
-- Indices de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `subs`
--
ALTER TABLE `subs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UC_suscripciones` (`id_user`,`id_autor`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `subs_ibfk_2` (`id_autor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `visitas_dia`
--
ALTER TABLE `visitas_dia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitas_dia_ibfk_1` (`autor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acceso`
--
ALTER TABLE `acceso`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `galeria`
--
ALTER TABLE `galeria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `subs`
--
ALTER TABLE `subs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `visitas_dia`
--
ALTER TABLE `visitas_dia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD CONSTRAINT `acceso_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD CONSTRAINT `galeria_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`id_galeria`) REFERENCES `galeria` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`emisor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`destinatario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  ADD CONSTRAINT `redes_sociales_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `subs`
--
ALTER TABLE `subs`
  ADD CONSTRAINT `subs_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subs_ibfk_2` FOREIGN KEY (`id_autor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subs_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `visitas_dia`
--
ALTER TABLE `visitas_dia`
  ADD CONSTRAINT `visitas_dia_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
