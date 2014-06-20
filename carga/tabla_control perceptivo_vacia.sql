-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-11-2011 a las 18:26:57
-- Versión del servidor: 5.1.33
-- Versión de PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `inventa_pglibreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_controlperceptivo`
--

DROP TABLE IF EXISTS `tbl_controlperceptivo`;
CREATE TABLE IF NOT EXISTS `tbl_controlperceptivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nota_entrega` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pedido` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sucursal_envio` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sucursal_carga` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `fecha_creada` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_carga` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `observaciones` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `tbl_controlperceptivo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_itemcontroperceptivo`
--

DROP TABLE IF EXISTS `tbl_itemcontroperceptivo`;
CREATE TABLE IF NOT EXISTS `tbl_itemcontroperceptivo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `notaentrega` varchar(100) NOT NULL DEFAULT '0',
  `cod_producto` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Codigo Interno del Producto',
  `precio_unitario` double NOT NULL DEFAULT '0',
  `cantidad_enviada` int(10) unsigned NOT NULL DEFAULT '0',
  `cantidad_cargada` int(10) unsigned NOT NULL DEFAULT '0',
  `isbn` varchar(100) DEFAULT '0',
  `codigobarra` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `tbl_itemcontroperceptivo`
--

