-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2026 a las 02:45:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `recuerdos_inolvidables`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `icono`) VALUES
(1, 'Salones y Quintas', 'Espacios e instalaciones para el evento', 'fa-building'),
(2, 'Fotografía y Videos', 'Sesiones de fotos, cobertura y video recuerdos', 'fa-camera'),
(3, 'Catering y Pastelería', 'Banquetes, mesas dulces y pasteles de 15 años', 'fa-utensils'),
(4, 'Vestidos y Calzado', 'Tiendas de vestidos, diseño a medida y accesorios', 'fa-user-nurse'),
(5, 'DJ y Animación', 'Música, iluminación, pantallas y shows en vivo', 'fa-music');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_evento` varchar(150) NOT NULL,
  `fecha_evento` date NOT NULL,
  `presupuesto` decimal(10,2) DEFAULT 0.00,
  `lugar` varchar(200) DEFAULT NULL,
  `estado` enum('Planificando','Confirmado','Finalizado','Cancelado') DEFAULT 'Planificando',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `nombre_comercial` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `ubicacion` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `es_destacado` tinyint(1) DEFAULT 0,
  `imagen` varchar(255) DEFAULT 'default-provider.jpg',
  `destacado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `id_usuario`, `id_categoria`, `nombre_comercial`, `descripcion`, `ubicacion`, `telefono`, `email`, `direccion`, `es_destacado`, `imagen`, `destacado`) VALUES
(9, NULL, 3, 'Catering  & Banquetes Gourmet', 'En Catering & Banquetes Gourmet nos especializamos en transformar tus celebraciones en experiencias inolvidables. Ofrecemos un servicio integral de catering y alta pastelería para bodas, XV años, eventos corporativos y reuniones sociales. Nos distingue la excelente calidad de nuestros ingredientes, una presentación impecable y una atención personalizada que se adapta al estilo y presupuesto de tu evento. Cuidamos cada detalle culinario para que tú solo te preocupes por disfrutar', '', '+57 313 4863299', 'gourmetbanquetes@gmail.com', 'Av. De las Américas # 450, Col. Centro', 1, 'default-provider.jpg', 0),
(10, NULL, 3, 'Pastelería Fina Sweet Magic', 'En Pastelería Fina Sweet Magic creamos verdaderas obras de arte comestibles para endulzar tus momentos más especiales. Nos especializamos en el diseño de pasteles personalizados, mesas de postres y alta repostería para XV años, bodas y todo tipo de eventos. Cada una de nuestras creaciones se elabora con ingredientes premium y un toque de magia que cautivará tanto a la vista como al paladar de tus invitados. Diseñamos el pastel perfecto que refleje el estilo de tu celebración\r\n', '', '+57 300 5987799', 'sweetmagic@gmail.com', 'Calle de los Dulces #12, Zona Rosa', 0, 'default-provider.jpg', 0),
(11, NULL, 5, 'Impacto Mix DJ & Iluminación', 'En Impacto Mix DJ & Iluminación llevamos tu evento al siguiente nivel con la mejor producción musical y audiovisual. Nos especializamos en la ambientación de XV años, bodas y eventos sociales, garantizando una pista de baile llena de energía de principio a fin. Contamos con DJs profesionales, un repertorio musical ilimitado y adaptado a tus gustos, así como sistemas de iluminación digital y efectos visuales de última generación que harán de tu celebración una verdadera fiesta inolvidable', '', '+57 319 4277023', 'impactomix@gmail.com', 'Av. Principal # 789, Col. San Ángel', 1, 'default-provider.jpg', 0),
(12, NULL, 5, 'Animación Estelar Eventos', 'En Animación Estelar Eventos encendemos los motores de tu celebración para garantizar una fiesta inolvidable. Nos especializamos en la animación interactiva de XV años, bodas y eventos sociales, creando dinámicas divertidas que ponen a bailar a todos tus invitados. Contamos con un equipo de animadores profesionales, excelente música y toda la energía necesaria para hacer de tu gran día un momento lleno de risas, baile y pura diversión\r\n', '', '+57 313 2165342', 'animacionestelar@gmail.com', 'Calle Fiesta # 45, Sector Norte', 0, 'default-provider.jpg', 0),
(13, NULL, 2, 'Destellos Visuales Fotografía', 'En Destellos Visuales Fotografía capturamos los destellos de felicidad y emoción que hacen único tu gran día. Nos especializamos en la cobertura fotográfica de XV años, bodas y eventos sociales, enfocándonos en congelar momentos espontáneos, sonrisas genuinas y cada pequeño gran detalle. Nuestro compromiso es entregarte memorias visuales con un estilo artístico, nítido y profesional que te permita revivir la magia de tu celebración para siempre\r\n', '', '5553456', 'destellosvisuales@gmail.com', 'Av. de la Luz # 210, Col. Obispado', 0, 'default-provider.jpg', 0),
(14, NULL, 2, 'Épico Studio Films', 'En Épico Studio Films transformamos los momentos más importantes de tu vida en recuerdos eternos. Nos especializamos en la cobertura fotográfica y cinematográfica de XV años, bodas y eventos sociales de alto nivel. Con un estilo narrativo, artístico y moderno, nuestro equipo de profesionales se encarga de capturar cada sonrisa, lágrima y detalle espontáneo, creando imágenes y videos de calidad cinematográfica que te harán revivir tu gran día una y otra vez\r\n', '', '5556543', 'epicostudio@gmail.com', 'Calzada de los Artistas # 55, Local B', 0, 'default-provider.jpg', 0),
(15, NULL, 1, 'Quinta Los Olivos', 'En Quinta Los Olivos te ofrecemos un espacio único y exclusivo rodeado de naturaleza para celebrar tus momentos más importantes. Nuestras instalaciones combinan la belleza de amplias áreas verdes con la comodidad y elegancia necesarias para tus XV años, bodas o eventos familiares. Un entorno mágico al aire libre, ideal para crear recuerdos inolvidables con un servicio profesional que cuidará cada detalle de tu gran día\r\n', '', '5557890', 'quintalosolivos@gmail.com', 'Carretera Nacional Km 15, Valle Alto', 1, 'default-provider.jpg', 0),
(16, NULL, 1, 'Salón de Eventos Cristal Palace', 'En Salón de Eventos Cristal Palace te ofrecemos el escenario perfecto para hacer realidad la celebración de tus sueños. Nuestro espacio destaca por su elegancia, amplitud y una infraestructura moderna ideal para XV años, bodas y eventos sociales inolvidables. Contamos con un equipo profesional comprometido en brindarte una atención de primer nivel y servicios integrales para que tú y tus invitados disfruten de una noche mágica, sofisticada y sin preocupaciones', '', '5550987', 'cristalpalace@gmail.com', 'Boulevard Real # 1024, Col. Virreyes', 0, 'default-provider.jpg', 0),
(17, NULL, 4, 'Quince Bella Donna', 'En Quince Bella Donna sabemos que tu vestido de XV años es el reflejo de tus sueños, por eso te ayudamos a encontrar el diseño perfecto para tu gran noche. Nos especializamos en vestidos exclusivos de alta calidad, diseñados para hacerte lucir y sentir como una verdadera reina. Contamos con una amplia variedad de estilos, desde los más tradicionales hasta las últimas tendencias de moda, además de una línea selecta de calzado y accesorios que complementarán tu look de manera espectacular', '', '5551122', 'belladonna@gmail.com', 'Pasaje Comercial El Ángel, Local 4', 0, 'default-provider.jpg', 0),
(18, NULL, 4, 'Calzado Elegante & Confort', 'Venta de calzado elegante y de alta calidad para todo tipo de eventos especiales. Ofrecemos una amplia variedad de estilos que combinan a la perfección el diseño vanguardista con la máxima comodidad, garantizando que luzcas espectacular y te sientas cómodo durante toda tu celebración', '', '5553344', 'calzadoelegante@gmail.com', 'Av. Central # 567, Col. Del Valle', 0, 'default-provider.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Cliente'),
(3, 'Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nombre`, `id_proveedor`, `id_categoria`, `titulo`, `descripcion`, `precio`) VALUES
(13, 'Paquete de Fotografíal fast', NULL, 3, '', 'fotos sencillas', 400000.00),
(14, 'alquiler trajes y vestidos', NULL, 4, '', 'vestuario para invitados', 80000.00),
(15, 'decoracion basica', NULL, 1, '', 'fiesta sencilla', 4000000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_contacto`
--

CREATE TABLE `solicitudes_contacto` (
  `id_solicitud` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) NOT NULL,
  `nombre_remitente` varchar(100) NOT NULL,
  `email_remitente` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_planificador`
--

CREATE TABLE `tareas_planificador` (
  `id_tarea` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `completada` tinyint(1) DEFAULT 0,
  `fecha_limite` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `telefono`, `id_rol`, `fecha_registro`, `created_at`) VALUES
(5, 'Marieys Azocar', 'marie@gmail.com', '$2y$10$xwHCThMv9BFzqMHb8cu7we5H9wsxk2YUg9TNg3ffy4RY.Ma0pC1W.', '123456', 2, '2026-09-27 23:21:27', '2026-09-27 23:31:47'),
(6, 'Valentina Forero', 'vale@gmail.com', '$2y$10$nH0iaAuMf2NP5gZUTz0CUec1R5kvVFLUihyC/0nte/IvvfTXv3tgm', '1234567', 2, '2026-09-27 23:21:53', '2026-09-27 23:31:47'),
(7, 'Cesar Navarrete', 'ces@gmail.com', '$2y$10$2kLyj7jGXtiJqTRLwJpWquG7.83sHB.KXj0KxIS7V/X6TXwtss97y', NULL, 2, '2026-09-27 23:31:56', '2026-09-27 23:31:56'),
(8, 'Yaremi Navarrete', 'yare@gmail.com', '$2y$10$.dJi6DUltqyrmL7.3Pve8uQFZBdTyFiPS9.J9GYnbJufbZkEehDtm', NULL, 2, '2026-09-27 23:32:49', '2026-09-27 23:32:49'),
(9, 'Jeronimo Castaño', 'Jero@gmail.com', '$2y$10$jmhg8eADtdKrW50f0/D05ukK8Ov4tsorPHACjPImrMIb5ZkeM3Ouq', NULL, 2, '2026-09-27 23:57:33', '2026-09-27 23:57:33'),
(10, 'Milo Navarrete', 'milo@gmail.com', '$2y$10$RdaHj41kK84MB/gFdZ5cHeLa4Gntj0/A9PrgBko9fDaEYzo5IQ/A2', NULL, 2, '2026-09-28 00:30:43', '2026-09-28 00:30:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `fecha_venta` date NOT NULL,
  `estado` varchar(50) DEFAULT 'Completado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `solicitudes_contacto`
--
ALTER TABLE `solicitudes_contacto`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `tareas_planificador`
--
ALTER TABLE `tareas_planificador`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `solicitudes_contacto`
--
ALTER TABLE `solicitudes_contacto`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas_planificador`
--
ALTER TABLE `tareas_planificador`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `proveedores_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitudes_contacto`
--
ALTER TABLE `solicitudes_contacto`
  ADD CONSTRAINT `solicitudes_contacto_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `solicitudes_contacto_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas_planificador`
--
ALTER TABLE `tareas_planificador`
  ADD CONSTRAINT `tareas_planificador_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
