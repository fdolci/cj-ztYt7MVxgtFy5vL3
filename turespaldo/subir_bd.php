<?php
// GET www.ararosario.com.ar/respaldar/respaldar.php /dev/null
include_once('config-tr.php');
//$x = unserialize(base64_decode($_GET['z'])); 


/* Envia por ftp el archivo */
$ftp_sitio 	    = $x[1];
$ftp_user    	= $x[2];
$ftp_pass   	= $x[3];

$ftp_send  = true;  // true|false
$ftp_ruta  = $x[8];
$elimina_archivo_enviado = true;



/* Determina si la tabla ser? vaciada (si existe) cuando  restauremos la tabla. */            
$drop = true;
/* Nombre del archivo de salida  2010-11-05-15-52-nombre_bd.sql */
$backup = date("Y")."-".date("m")."-".date("d")."-".date("H")."-".date("i")."-".$bd.".sql";
/* Hace un comprimido .gz true|false y borra el .sql original? */
$gz = true;
$borra_sql = true;


set_time_limit(0);
$ar=fopen("$backup","w") or die("Problemas en la creacion");
/* 
* Array que contiene las tablas de la base de datos que seran resguardadas.
* Puede especificarse un valor false para resguardar todas las tablas
* de la base de datos especificada en  $bd.
* 
* Ejs.:
* $tablas = false;
*    o
* $tablas = array("tabla1", "tabla2", "tablaetc");
* 
*/
$tablas = false;
/* 
* Tipo de compresion.
* Puede ser "gz", "bz2", o false (sin comprimir)
*/
$compresion = false;

/* Conexion y eso*/
$conexion = mysql_connect($host, $usuario, $passwd)
or die("No se conectar con el servidor MySQL: ".mysql_error());
mysql_select_db($bd, $conexion)
or die("No se pudo seleccionar la Base de Datos: ". mysql_error());


/* Se busca las tablas en la base de datos */
if ( empty($tablas) ) {
    $consulta = "SHOW TABLES FROM $bd;";
    $respuesta = mysql_query($consulta, $conexion)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_NUM)) {
        $tablas[] = $fila[0];
    }
}


/* Se crea la cabecera del archivo */
$info['dumpversion'] = "1.1b";
$info['fecha'] = date("d-m-Y");
$info['hora'] = date("h:m:s A");
$info['mysqlver'] = mysql_get_server_info();
$info['phpver'] = phpversion();
ob_start();
print_r($tablas);
$representacion = ob_get_contents();
ob_end_clean ();
preg_match_all('/(\[\d+\] => .*)\n/', $representacion, $matches);
$info['tablas'] = implode(";  ", $matches[1]);
$dump = <<<EOT
# +===================================================================
# | TuRespaldo.com.ar! 
# |
# | Generado el {$info['fecha']} a las {$info['hora']} por el usuario '$usuario'
# | Servidor: {$_SERVER['HTTP_HOST']}
# | MySQL Version: {$info['mysqlver']}
# | PHP Version: {$info['phpver']}
# | Base de datos: '$bd'
# | Tablas: {$info['tablas']}
# +-------------------------------------------------------------------

\n
EOT;
fputs($ar,$dump);

foreach ($tablas as $tabla) {
    
    $drop_table_query = "";
    $create_table_query = "";
    $insert_into_query = "";
    
    /* Se halla el query que ser? capaz vaciar la tabla. */
    if ($drop) {
        $drop_table_query = "DROP TABLE IF EXISTS `$tabla`;";
    } else {
        $drop_table_query = "# No especificado.";
    }

$dump = <<<EOT
\n
# | Vaciado de tabla '$tabla'
# +------------------------------------->
$drop_table_query \n
EOT;
	fputs($ar,$dump);
	
    /* Se halla el query que ser? capaz de recrear la estructura de la tabla. */
    $create_table_query = "";
    $consulta = "SHOW CREATE TABLE $tabla;";
    $respuesta = mysql_query($consulta, $conexion)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_NUM)) {
            $create_table_query = $fila[1].";";
    }
$dump = <<<EOT
\n
# | Estructura de la tabla '$tabla'
# +------------------------------------->
$create_table_query \n
EOT;
    fputs($ar,$dump);
	
	
    /* Se halla el query que ser? capaz de insertar los datos. */
$dump = <<<EOT
\n
# | Carga de datos de la tabla '$tabla'
# +------------------------------------->
\n
EOT;
	fputs($ar,$dump);
    $insert_into_query = "";
    $consulta = "SELECT * FROM $tabla;";
    $respuesta = mysql_query($consulta, $conexion)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_ASSOC)) {
            $columnas = array_keys($fila);
            foreach ($columnas as $columna) {
                if ( gettype($fila[$columna]) == "NULL" ) {
                    $values[] = "NULL";
                } else {
                    $values[] = "'".mysql_real_escape_string($fila[$columna])."'";
                }
            }
            $insert_into_query = "INSERT INTO `$tabla` VALUES (".implode(", ", $values).");\n";
			fputs($ar,$insert_into_query);
            unset($values);
    }
    
}
fclose($ar);	



/*
	Comienza la compresion a .GZ
*/
if ($gz==true) {
	$input	= $backup;
	$output	= $backup.'.gz';
	$fp = fopen($input, rb);
	$fd = fopen($output, wb);
	while (!feof($fp)) {
		$data = fread($fp,8192);
		$gzdata = gzencode($data,9);
		fwrite($fd, $gzdata);
	 }
	fclose($fp);
	fclose($fd);
	if ($borra_sql==true){ unlink($input); }
} else { $output = $backup; }



/*
	Envia por FTP
*/
if ($ftp_send){
	$file = $output;
	$remote_file = $ftp_ruta.$output;

	// establecer una conexi?n b?sica
	$conn_id = ftp_connect($ftp_sitio);

	// iniciar sesi?n con nombre de usuario y contrase?a
	$login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);
	
	// cargar un archivo
	if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) {
	   echo "Se ha cargado $file correctamente\n";
       ftp_close($conn_id);
       if ($elimina_archivo_enviado==true) { unlink($output); }

	} else {
        ftp_close($conn_id);
	    echo "Hubo un problema durante la transferencia de $file\n";
	}
	// cerrar la conexi?n ftp
}


?> 