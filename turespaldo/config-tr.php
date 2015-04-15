<?php
	include_once("../inc/config.php");

	$x[0] = "http://www.congresosyjornadas.net/turespaldo";	// url empresa
	$x[1] = "ftp.turespaldoonline.com.ar"; 				//server //apolo.servidoraweb.net
	$x[2] = "congresos@turespaldoonline.com.ar"; 	//user
	$x[3] = "Congres2013"; 							//pass
	$x[4] = "contacto@congresosyjornadas.net"; 					//emailto
	$x[5] = "Congresos y Jornadas"; 							//empresa
	$x[6] = "/web/"; 								//Ruta en TuRespaldo Web
	$x[7] = "turespaldoonline@gmail.com"; 			//Mi email
	$x[8] = "/bd/"; 								//Ruta en TuRespaldo bd

	
	/* Usuario para la conexion a Mysql. */
	$usuario = $user;
	/* Password para la conexion a Mysql. */
	$passwd = $password;
	 /* Host para la conexion a Mysql. */
	$host = $server;
	/* Base de Datos que se seleccionará. */
	$bd = $database;
?>