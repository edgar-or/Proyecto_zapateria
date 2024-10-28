-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2024 a las 15:22:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `the_walkers_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `cod_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(50) NOT NULL,
  `cod_emprsaf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`cod_categoria`, `nombre_categoria`, `cod_emprsaf`) VALUES
(1, 'Dama', 1),
(2, 'Caballero', 1),
(3, 'Niño', 1),
(4, 'Niña', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE `color` (
  `cod_color` int(11) NOT NULL,
  `color` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`cod_color`, `color`) VALUES
(1, 'negro'),
(2, 'blanco'),
(3, 'gris'),
(4, 'azul'),
(5, 'amarillo'),
(6, 'rojo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `cod_detalle_venta` int(11) NOT NULL,
  `cantidad_producto` int(11) NOT NULL,
  `cod_ventaf` int(11) NOT NULL,
  `cod_inventariof` int(11) NOT NULL,
  `precio_unitario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`cod_detalle_venta`, `cantidad_producto`, `cod_ventaf`, `cod_inventariof`, `precio_unitario`) VALUES
(1, 1, 46, 69, 32),
(2, 1, 46, 74, 32),
(37, 2, 49, 77, 190),
(38, 2, 49, 71, 45),
(39, 2, 50, 70, 23),
(44, 1, 52, 69, 32),
(46, 2, 53, 69, 32),
(48, 2, 54, 69, 32),
(50, 2, 55, 69, 32),
(51, 3, 56, 69, 32),
(53, 4, 57, 69, 32),
(55, 1, 58, 69, 32),
(57, 2, 59, 69, 32),
(59, 2, 60, 86, 55),
(60, 1, 60, 69, 32),
(61, 1, 60, 69, 32),
(62, 1, 60, 75, 32),
(63, 1, 60, 74, 32),
(64, 1, 60, 81, 55),
(65, 1, 60, 70, 23),
(66, 1, 60, 76, 190),
(67, 1, 61, 70, 23),
(68, 1, 61, 81, 55),
(69, 1, 61, 78, 190),
(70, 1, 61, 78, 190),
(71, 1, 61, 78, 190),
(72, 1, 61, 78, 190),
(73, 1, 61, 80, 55),
(74, 1, 61, 78, 160),
(75, 1, 61, 80, 55),
(76, 2, 61, 82, 70),
(77, 3, 61, 78, 160),
(78, 1, 61, 78, 160),
(79, 1, 61, 78, 160),
(80, 1, 61, 76, 200),
(81, 1, 61, 78, 160),
(82, 1, 61, 69, 32),
(83, 1, 61, 73, 34),
(84, 1, 61, 69, 32),
(85, 1, 61, 73, 34),
(86, 1, 62, 69, 32),
(87, 1, 62, 69, 32),
(88, 1, 62, 69, 32),
(89, 1, 62, 73, 34),
(90, 1, 62, 69, 32),
(91, 1, 62, 69, 32),
(92, 1, 62, 73, 34),
(93, 3, 62, 73, 34),
(94, 1, 62, 69, 32),
(95, 2, 62, 69, 32),
(96, 7, 62, 73, 34),
(97, 1, 62, 69, 32),
(98, 1, 62, 69, 32),
(99, 3, 62, 73, 34),
(100, 6, 62, 69, 32),
(101, 11, 62, 73, 34),
(102, 5, 62, 77, 190),
(103, 7, 62, 76, 200),
(104, 8, 62, 78, 160),
(105, 1, 62, 73, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `cod_empresa` int(11) NOT NULL,
  `Nombre_empresa` varchar(50) NOT NULL,
  `Direccion` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`cod_empresa`, `Nombre_empresa`, `Direccion`) VALUES
(1, 'the_walkers', 'San Vicente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `cod_inventario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  `cod_productof` int(11) NOT NULL,
  `cod_colorf` int(11) NOT NULL,
  `cod_tallaf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`cod_inventario`, `cantidad`, `precio_unitario`, `cod_productof`, `cod_colorf`, `cod_tallaf`) VALUES
(69, 56, 32, 8, 1, 1),
(70, 15, 23, 13, 5, 4),
(71, 4, 45, 16, 5, 4),
(72, 35, 60, 28, 1, 1),
(73, 12, 34, 8, 2, 4),
(74, 12, 32, 30, 1, 1),
(75, 2, 23, 30, 1, 3),
(76, 10, 199.99, 31, 2, 3),
(77, 25, 190, 31, 1, 1),
(78, 5, 160, 31, 4, 1),
(79, 12, 123, 32, 3, 1),
(80, 3, 55, 33, 1, 2),
(81, 5, 60, 33, 1, 3),
(82, 5, 70, 34, 4, 2),
(83, 5, 33, 35, 3, 1),
(84, 8, 30, 36, 4, 1),
(85, 6, 41, 37, 5, 7),
(86, 6, 55, 38, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `cod_metodo` int(11) NOT NULL,
  `nombre_titular` varchar(50) NOT NULL,
  `numero_tarjeta` varchar(32) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `cvv` int(11) NOT NULL,
  `cod_usuariof` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodo_pago`
--

INSERT INTO `metodo_pago` (`cod_metodo`, `nombre_titular`, `numero_tarjeta`, `fecha_vencimiento`, `cvv`, `cod_usuariof`) VALUES
(1, 'Edgar', '************1232', '0000-00-00', 123, 5),
(2, 'Orlando', '************4546', '2005-09-22', 123, 5),
(3, 'Orlando', '************5345', '2024-10-22', 123, 5),
(4, 'Orlando', '************4213', '2024-10-22', 234, 4),
(5, 'Orlando', '************4213', '2024-10-22', 234, 4),
(6, 'ragde', '************3434', '2024-10-22', 545, 4),
(7, 'Edgar', '************3224', '2024-10-22', 231, 4),
(8, 'Gisela', '************6654', '2024-10-23', 789, 6),
(9, 'Orlando', '************3535', '2024-11-07', 567, 1),
(11, 'emerson ', '************9309', '2024-10-25', 454, 9),
(12, 'Recinos', '************3244', '2024-11-07', 232, 10),
(13, 'catalina', '************2345', '2024-10-22', 123, 11),
(14, 'carrillo', '************3456', '2024-10-11', 123, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `cod_producto` int(11) NOT NULL,
  `nombre_producto` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `imagen` varchar(1000) NOT NULL,
  `marca` varchar(20) NOT NULL,
  `cod_categoriaf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`cod_producto`, `nombre_producto`, `descripcion`, `imagen`, `marca`, `cod_categoriaf`) VALUES
(8, 'Tenis', 'comodos', 'https://th.bing.com/th/id/R.ad5d0f01d772e4107f2e0e95c8244add?rik=%2bDsFmQjL0YYzkQ&pid=ImgRaw&r=0', 'nike', 1),
(13, 'adidas ew', 'comodos', 'https://th.bing.com/th/id/OIP.6jKRdbI1fbZuBMnpW3orLQHaHa?rs=1&pid=ImgDetMain', 'adidas', 2),
(16, 'adidas rall', 'comodos', 'https://b2cimpulsmx.vtexassets.com/arquivos/ids/208674/Tenis-Caballero-ADIDAS-ALPHAEDGE-Estilo-IF7293.jpg?v=638495148189570000', 'adidas', 2),
(24, 'Test', 'Test', 'Test', 'Test', 1),
(28, 'adidas children', 'suaves', 'https://th.bing.com/th/id/R.a4029e504ec8cffaae89a6ca2d571e2a?rik=uV5ccYLGNbS23Q&pid=ImgRaw&r=0', 'adidas', 3),
(30, 'adidas', 'suaves', 'https://images-na.ssl-images-amazon.com/images/I/812kkY7zgdL._AC_UL1500_.jpg', 'Adidas', 1),
(31, 'Jordan', 'famosa marca nike', 'https://ciconceptstore.com/cdn/shop/files/Jordan_4_Retro_Red_Cement1.webp?v=1719239162&width=2048', 'nike', 2),
(32, 'Jordan2', 'famosa marca nike', 'https://ciconceptstore.com/cdn/shop/files/Jordan_4_Retro_Red_Cement1.webp?v=1719239162&width=2048', 'nike', 2),
(33, 'Tacones Lemue', 'Descubre la elegancia de tacones', 'https://paylesssv.vtexassets.com/arquivos/ids/357735/191715_1.jpg?v=638095041674570000', 'lemue', 1),
(34, 'Zapatos deportivos', 'suaves y comodos', 'https://img.kwcdn.com/product/fancy/f57ede2a-673e-451b-952f-698af6716f5b.jpg?imageMogr2/auto-orient%7CimageView2/2/w/800/q/70/format/webp', 'lemue', 1),
(35, 'Zapatitos Kawai', 'Lindos y cómodos zapatos para niñas.', 'https://hushpuppies.sv/cdn/shop/files/30070149_1024x1024.jpg?v=1724171638', 'lemue', 4),
(36, 'Tacón de Princesa', 'Lindos tacones de princesa', 'https://paylesssv.vtexassets.com/arquivos/ids/346611/193271_1.jpg?v=638004010727370000', 'lemue', 4),
(37, 'Zapatos deportivos de princesa', 'zapatos de niñas de princesa', 'https://paylesssv.vteximg.com.br/arquivos/ids/448977/199519_1.jpg?v=638588379596600000', 'lemue', 4),
(38, 'Zapatos escolares', 'Zapatos cómodos escolar ', 'https://siman.vtexassets.com/arquivos/ids/5054567-800-800?v=638388630879170000&width=800&height=800&aspect=true', 'lemue', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talla`
--

CREATE TABLE `talla` (
  `cod_talla` int(11) NOT NULL,
  `talla` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talla`
--

INSERT INTO `talla` (`cod_talla`, `talla`) VALUES
(1, 37),
(2, 36),
(3, 44),
(4, 40),
(5, 35),
(6, 32),
(7, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `cod_usuario` int(11) NOT NULL,
  `primer_nombre` varchar(50) NOT NULL,
  `primer_apellido` varchar(50) NOT NULL,
  `tipo_usuario` varchar(50) NOT NULL,
  `telefono_usuario` int(8) NOT NULL,
  `correo_usuario` varchar(100) NOT NULL,
  `nick_name` varchar(50) NOT NULL,
  `contraseña` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`cod_usuario`, `primer_nombre`, `primer_apellido`, `tipo_usuario`, `telefono_usuario`, `correo_usuario`, `nick_name`, `contraseña`) VALUES
(1, 'Edgar', 'Ayala', 'admin', 70900475, 'ayalaalvarezedgarorlando@gmail.com', 'ragde', '1234567'),
(4, 'Elias', 'Ayala', 'cliente', 7653454, 'elias@gmail.com', 'elias', 'elias'),
(5, 'Fran', 'Ayala', 'cliente', 65768909, 'fran@gmail.com', 'fran', 'fran'),
(6, 'Gisela', 'Campos', 'cliente', 7618923, 'gisela@gmail.com', 'gisela', 'gisela'),
(7, 'Enderson', 'Mundo', 'admin', 74759314, 'ender.mundo21.17@gmail.com', 'kanon', 'password'),
(9, 'moises', 'zavala', 'cliente', 2147483647, 'moses@gmail.com', 'firenega', '12345'),
(10, 'Raul', 'Recinos', 'cliente', 4356897, 'recinos@gmail.com', 'recinos', '1234'),
(11, 'catalina', 'carrillo', 'cliente', 1223456, 'carrillo@gmail.com', 'catalina', '1234'),
(12, 'Enderson', 'Galindo', 'admin', 12313, 'ender.mundo21.17@gmail.com', 'ueu', 'wasa'),
(13, 'carrillo', 'carrillo', 'cliente', 1234566, 'carrillo@gmail.com', 'carrillo', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `cod_venta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total_venta` double NOT NULL,
  `estado_venta` varchar(15) NOT NULL,
  `cod_usuariof` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`cod_venta`, `fecha`, `total_venta`, `estado_venta`, `cod_usuariof`) VALUES
(46, '2024-10-22', 64, 'Finalizado', 4),
(48, '2024-10-22', 0, 'EN PROCESO', 7),
(49, '2024-10-22', 470, 'Finalizado', 9),
(50, '2024-10-22', 46, 'Finalizado', 9),
(51, '2024-10-23', 0, 'En proceso', 9),
(52, '2024-10-24', 32, 'Finalizado', 13),
(53, '2024-10-24', 64, 'Finalizado', 13),
(54, '2024-10-24', 64, 'Finalizado', 13),
(55, '2024-10-24', 64, 'Finalizado', 13),
(56, '2024-10-24', 96, 'Finalizado', 13),
(57, '2024-10-24', 128, 'Finalizado', 13),
(58, '2024-10-24', 32, 'Finalizado', 13),
(59, '2024-10-24', 64, 'Finalizado', 13),
(60, '2024-10-25', 506, 'Finalizado', 13),
(61, '2024-10-27', 2540, 'Finalizado', 13),
(62, '2024-10-27', 5060, 'Finalizado', 13),
(63, '2024-10-28', 0, 'En proceso', 13);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`cod_categoria`),
  ADD KEY `cod_emprsaf` (`cod_emprsaf`);

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`cod_color`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`cod_detalle_venta`),
  ADD KEY `cod_ventaf` (`cod_ventaf`),
  ADD KEY `cod_productof` (`cod_inventariof`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`cod_empresa`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`cod_inventario`),
  ADD KEY `cod_colorf_cod_productof` (`cod_productof`,`cod_colorf`),
  ADD KEY `cod_tallaf` (`cod_tallaf`),
  ADD KEY `cod_colorf` (`cod_colorf`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`cod_metodo`),
  ADD KEY `cod_usuariof` (`cod_usuariof`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`cod_producto`),
  ADD KEY `cod_categoriaf` (`cod_categoriaf`);

--
-- Indices de la tabla `talla`
--
ALTER TABLE `talla`
  ADD PRIMARY KEY (`cod_talla`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`cod_venta`),
  ADD KEY `cod_usuariof` (`cod_usuariof`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `cod_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `color`
--
ALTER TABLE `color`
  MODIFY `cod_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `cod_detalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `cod_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `cod_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `cod_metodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `cod_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `talla`
--
ALTER TABLE `talla`
  MODIFY `cod_talla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `cod_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`cod_emprsaf`) REFERENCES `empresa` (`cod_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`cod_ventaf`) REFERENCES `venta` (`cod_venta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_3` FOREIGN KEY (`cod_inventariof`) REFERENCES `inventario` (`cod_inventario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`cod_productof`) REFERENCES `producto` (`cod_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`cod_colorf`) REFERENCES `color` (`cod_color`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`cod_tallaf`) REFERENCES `talla` (`cod_talla`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD CONSTRAINT `metodo_pago_ibfk_1` FOREIGN KEY (`cod_usuariof`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`cod_categoriaf`) REFERENCES `categoria` (`cod_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`cod_usuariof`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
