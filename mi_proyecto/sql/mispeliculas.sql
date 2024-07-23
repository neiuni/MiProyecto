-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 14, 2023 at 08:46 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peliculas`
--

-- --------------------------------------------------------

--
-- Table structure for table `genero`
--

DROP TABLE IF EXISTS `genero`;
CREATE TABLE IF NOT EXISTS `genero` (
  `id` bigint(20) NOT NULL,
  `genero` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genero`
--

INSERT INTO `genero` (`id`, `genero`) VALUES
(12, 'Aventura'),
(14, 'Fantasía'),
(16, 'Animación'),
(18, 'Drama'),
(27, 'Terror'),
(28, 'Acción'),
(35, 'Comedia'),
(36, 'Historia'),
(37, 'Western'),
(53, 'Suspense'),
(80, 'Crimen'),
(99, 'Documental'),
(878, 'Ciencia ficción'),
(9648, 'Misterio'),
(10402, 'Música'),
(10749, 'Romance'),
(10751, 'Familia'),
(10752, 'Bélica'),
(10770, 'Pelicula TV');

-- --------------------------------------------------------

--
-- Table structure for table `peliculas`
--

DROP TABLE IF EXISTS `peliculas`;
CREATE TABLE IF NOT EXISTS `peliculas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tmdb_id` varchar(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `estado` enum('A','D','B') NOT NULL COMMENT 'A-activo D-desactivado B-Borrar',
  `estreno` date NOT NULL,
  `overview` text,
  `opinion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `peli_genero`
--

DROP TABLE IF EXISTS `peli_genero`;
CREATE TABLE IF NOT EXISTS `peli_genero` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `peliculaid` bigint(20) NOT NULL,
  `generoid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--
-- Eliminar la tabla si existe para evitar duplicados
DROP TABLE IF EXISTS `Usuarios`;

-- Crear la tabla Usuarios
CREATE TABLE `Usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `mail` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) DEFAULT NULL,
    `rol` ENUM('A','I','U','E') NOT NULL COMMENT 'A: Administrador, U: Usuario, I: Invitado, E: Editor',
    `estado` ENUM('A','P','B','D') NOT NULL COMMENT 'A: Activo, P: Preinscrito, D: Desactivado, B: Borrado',
    `verificado` BOOLEAN DEFAULT 0,
    `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `reset_token` VARCHAR(255) DEFAULT NULL,
    `reset_token_expiration` DATETIME DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10004 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `votaciones`
--

DROP TABLE IF EXISTS `votaciones`;
CREATE TABLE IF NOT EXISTS `votaciones` (
  `usuarioid` bigint(20) NOT NULL,
  `elemento_votado` int(10) UNSIGNED NOT NULL,
  `valoracion` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
