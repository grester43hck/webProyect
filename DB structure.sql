-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-02-2016 a las 15:02:24
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `memebase`
--
CREATE DATABASE IF NOT EXISTS `memebase` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `memebase`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `URI` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `referId` int(11) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `content` varchar(500) NOT NULL,
  `create_date` varchar(8) NOT NULL,
  `create_hour` varchar(8) NOT NULL,
  `delete_date` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `username` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `create_date` varchar(8) NOT NULL,
  `create_hour` varchar(8) NOT NULL,
  `delete_date` varchar(8) DEFAULT NULL,
  `media` varchar(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(500) DEFAULT NULL,
  `verified` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `create_date` varchar(8) NOT NULL,
  `delete_date` varchar(8) DEFAULT NULL,
  `lastip` varchar(15) DEFAULT NULL,
  `userLevel` int(1) NOT NULL DEFAULT '1',
  `email` varchar(40) NOT NULL,
  `verified` int(1) NOT NULL DEFAULT '0',
  `banned` int(1) NOT NULL DEFAULT '0',
  `reasson` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_levels`
--

DROP TABLE IF EXISTS `user_levels`;
CREATE TABLE `user_levels` (
  `level` int(11) NOT NULL,
  `title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_levels`
--

INSERT INTO `user_levels` (`level`, `title`) VALUES
(1, 'LoggedNotVerified'),
(1, 'NotLoggedin'),
(2, 'LoggedVerified'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `verify_email`
--

DROP TABLE IF EXISTS `verify_email`;
CREATE TABLE `verify_email` (
  `id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `code` varchar(10) NOT NULL,
  `verified` int(1) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_posts_valoracion`
--
DROP VIEW IF EXISTS `view_posts_valoracion`;
CREATE TABLE `view_posts_valoracion` (
`id` int(11)
,`categoryId` int(11)
,`create_date` varchar(8)
,`create_hour` varchar(8)
,`media` varchar(200)
,`type` varchar(20)
,`username` varchar(20)
,`title` varchar(100)
,`content` varchar(500)
,`verified` int(1)
,`likes` bigint(21)
,`reports` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_posts_valoracion`
--
DROP TABLE IF EXISTS `view_posts_valoracion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_posts_valoracion`  AS  select `p`.`id` AS `id`,`p`.`categoryId` AS `categoryId`,`p`.`create_date` AS `create_date`,`p`.`create_hour` AS `create_hour`,`p`.`media` AS `media`,`p`.`type` AS `type`,`p`.`username` AS `username`,`p`.`title` AS `title`,`p`.`content` AS `content`,`p`.`verified` AS `verified`,(select count(0) from `likes` `l` where (`p`.`id` = `l`.`postId`)) AS `likes`,(select count(0) from `reports` `r` where (`p`.`id` = `r`.`postId`)) AS `reports` from `posts` `p` where ((isnull(`p`.`delete_date`) or (`p`.`delete_date` = '')) and `p`.`username` in (select `u`.`username` from `users` `u` where ((isnull(`u`.`delete_date`) or (`u`.`delete_date` = '')) and (`u`.`banned` = 0)))) order by `p`.`id` desc ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `postId` (`postId`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postId` (`postId`),
  ADD KEY `username` (`username`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indices de la tabla `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postId` (`postId`),
  ADD KEY `username` (`username`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `id` (`id`),
  ADD KEY `userLevel` (`userLevel`);

--
-- Indices de la tabla `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`level`,`title`);

--
-- Indices de la tabla `verify_email`
--
ALTER TABLE `verify_email`
  ADD PRIMARY KEY (`email`),
  ADD KEY `id` (`id`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT de la tabla `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `verify_email`
--
ALTER TABLE `verify_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`);

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`);

--
-- Filtros para la tabla `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`userLevel`) REFERENCES `user_levels` (`level`);

--
-- Filtros para la tabla `verify_email`
--
ALTER TABLE `verify_email`
  ADD CONSTRAINT `verify_email_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
