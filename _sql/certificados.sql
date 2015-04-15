/*
SQLyog Enterprise - MySQL GUI v6.15
MySQL - 5.5.16 : Database - congresos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `certificados` */

DROP TABLE IF EXISTS `certificados`;

CREATE TABLE `certificados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL DEFAULT '0',
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `titulo` varchar(255) DEFAULT '',
  `cuerpo` text,
  `imagen` varchar(255) NOT NULL DEFAULT '',
  `orientacion` varchar(1) NOT NULL DEFAULT 'L',
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `certificados` */

insert  into `certificados`(`id`,`producto_id`,`nombre`,`titulo`,`cuerpo`,`imagen`,`orientacion`,`activo`,`created`,`updated`) values (1,137,'Asistencia','Congreso de MastologÃ­a y OncologÃ­a ClÃ­nica 2015\r\nX Jornadas de MastologÃ­a del Cono Sur.\r\nIV Jornadas Internacionales de MastologÃ­a y OncologÃ­a ClÃ­nica.\r\nEncuentro de EnfermerÃ­a OncolÃ³gica.','Se deja constancia que #APELLIDO#,  #NOMBRE#  (#DOCUMENTO#), ha participado en carÃ¡cter de ASISTENTE al CONGRESO DE MEDICINA CLINICA 2015 desarrollado en la ciudad de ROSARIO entre los dÃ­as 9 y 10 de Abril de 2015.','137-1428371009.jpg','L',0,0,1428433691),(2,137,'Expositor','Congreso de MastologÃ­a y OncologÃ­a ClÃ­nica 2015\r\nX Jornadas de MastologÃ­a del Cono Sur.\r\nIV Jornadas Internacionales de MastologÃ­a y OncologÃ­a ClÃ­nica.\r\nEncuentro de EnfermerÃ­a OncolÃ³gica.','Se deja constancia que #NOMBRE# #APELLIDO# participÃ³ en carÃ¡cter de EXPOSITOR en el CONGRESO DE MEDICINA CLINICA 2015 desarrollado en la ciudad de ROSARIO entre los dÃ­as 9 y 10 de Abril de 2015.','137-1428433978.jpg','L',0,1428433978,1428435425);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;