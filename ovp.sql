/*
 Navicat Premium Data Transfer

 Source Server         : #OVP
 Source Server Type    : MySQL
 Source Server Version : 50168
 Source Host           : localhost
 Source Database       : opv_platform

 Target Server Type    : MySQL
 Target Server Version : 50168
 File Encoding         : utf-8

 Date: 04/12/2013 20:13:13 PM
*/

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `auth`
-- ----------------------------
DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `pass` text NOT NULL,
  `auth2` text NOT NULL,
  `nombre` text,
  `fb` text,
  `tw` text,
  `mail` text,
  `fecha` text NOT NULL,
  `ip` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `debate`
-- ----------------------------
DROP TABLE IF EXISTS `debate`;
CREATE TABLE `debate` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_propuesta` text NOT NULL,
  `comentario` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `id_autor` text NOT NULL,
  `fecha` text NOT NULL,
  `ip` text NOT NULL,
  `nick` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `menuprincipal`
-- ----------------------------
DROP TABLE IF EXISTS `menuprincipal`;
CREATE TABLE `menuprincipal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `imagen` text,
  `clase` text,
  `url_destino` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `opciones_propuesta`
-- ----------------------------
DROP TABLE IF EXISTS `opciones_propuesta`;
CREATE TABLE `opciones_propuesta` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_propuesta` text NOT NULL,
  `opcion` text NOT NULL,
  `id_voto` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `propiedades`
-- ----------------------------
DROP TABLE IF EXISTS `propiedades`;
CREATE TABLE `propiedades` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `propuestas`
-- ----------------------------
DROP TABLE IF EXISTS `propuestas`;
CREATE TABLE `propuestas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` text NOT NULL,
  `descripcion` text NOT NULL,
  `estado` text NOT NULL,
  `autor` text NOT NULL,
  `contenido` text NOT NULL,
  `quorum` text NOT NULL,
  `id_autor` text NOT NULL,
  `fecha` text NOT NULL,
  `ip` text NOT NULL,
  `uid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `theme`
-- ----------------------------
DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `folder` text NOT NULL,
  `nombre` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `votos`
-- ----------------------------
DROP TABLE IF EXISTS `votos`;
CREATE TABLE `votos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `voto` text NOT NULL,
  `id_propuesta` text NOT NULL,
  `id_usuario` text NOT NULL,
  `hora` text,
  `ip` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

SET FOREIGN_KEY_CHECKS = 1;
