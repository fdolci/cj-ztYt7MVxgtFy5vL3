<?php
set_time_limit(0);
ini_set ('error_reporting', E_ALL);
include_once('config-tr.php');
//$x = unserialize(base64_decode($_GET['z'])); 

// variables
//$carpetas 	= array('archivos/','biblioteca/','boletines/','files/', 'img_publicaciones/','img_publicidad/');
$ruta_local 	= '../';
$carpetas 		= array('/');

$ftp_server 	= $x[1];
$ftp_user_name 	= $x[2];
$ftp_user_pass 	= $x[3];
$emailto 		= $x[4];
$empresa 		= $x[5];
$ruta_remota 	= $x[6];
$emailcc 		= $x[7];
$Directorios 	= array();
$Archivos 		= array();
$num 			= 0;

// Leer carpetas y archivos recursivamente
foreach ($carpetas as $c) {
	$listar = $ruta_local.$c;
	listar_directorios_ruta($listar);
}

// Asignar fecha y tamaño de cada archivo encontrado
foreach ($Archivos as $clave => $valor){
	$Archivos[$clave]['fecha'] 	= obtener_fecha($ruta_local.''.$valor['nombre']);
	$Archivos[$clave]['size'] 	= obtener_size($ruta_local.''.$valor['nombre']);
}

//---- Abrir conexion FTP
$conn_id 		= ftp_connect($ftp_server);
$login_result 	= ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
if ((!$conn_id) || (!$login_result)) {
    $x = "ERROR ";
} else {
    $x = "OK ";

	ftp_pasv ( $conn_id, TRUE); 
	//Compruebo que existan todas las carpetas
	foreach ($Directorios as $d) {
		creardir($ruta_remota.$d,$conn_id);
	}

	$almenos1 = FALSE;	
	//-- Enviar los archivos al servidor
	foreach($Archivos as $clave => $valor){
		$file = $valor['nombre'];
	//	$Archivos[$clave]['subido'] = enviar_archivo($file,$conn_id,$ruta_remota,$ruta_local);
		$date = ftp_mdtm($conn_id, $ruta_remota.''.$file);
		if ( $date<0 or $valor['fecha']>$date ) {
			if (ftp_put($conn_id, $ruta_remota.''.$file , $ruta_local.''.$file, FTP_BINARY)){
				$subido = 1;
				$almenos1 = TRUE;
			} else {
				$subido=0;
			}
		} else {
			$subido=9;		
		}
		$Archivos[$clave]['subido'] = $subido;
/*
		echo "<pre>";
		print_r($Archivos[$clave]);
		echo "</pre>";
*/		
	}
}

echo '2';
/* --------- Envia mail con resultado */

$emailsend = "noreply@TuRespaldo.com.ar";
$subject   = "[TuRespaldo- $empresa] $x";
$message   = "";
$message .= '<span style="color:black;font-family:Verdana, Tahoma,Arial;font-size:12px;font-weight:normal;" >';
$message .= "Backup fecha: ".date("d/m/Y",time() )."<hr>";
if ($almenos1==TRUE) {
	$message .= "Archivos actualizados:<br> ";
	$message .= '<table style="color:black;font-family:Verdana, Tahoma,Arial;font-size:12px;font-weight:normal;" border="1">';
	$message .= '<tr style="background-color:#C0C0C0;"><td>Nombre</td><td>Fecha</td><td>Size</td></tr>';
	foreach ($Archivos as $ar){
		if ($ar['subido']==1){
			$size = $ar['size']/1024;
			$message.= '<tr >';
			$message.="<td width='300'>".$ar['nombre']."</td>";
			$message.= "<td align='center' width='80'>".date("d/m/Y",$ar['fecha'])."</td>";
			$message.= "<td align='right'>".number_format($size,2)."Kb</td></tr>";
		}
	}
	
	$message.="</table>";
} else {$message.="Todos los archivos estaban actualizados"; }
$message.= "<br><br>Para ver la copia, puede acceder a <a href='http://www.TuRespaldo.com.ar'>http://www.TuRespaldo.com.ar</a><br>";
$encabezados = "From: ".$emailsend."\r\nCC:".$emailcc."\nContent-Type: text/html; charset=iso-8859-1";

//	echo $message;
if (mail($emailto,$subject,$message, $encabezados)) { $enviado=1; } else { $enviado=0;}

$proceso['conexion'] = $x;
$proceso['mail'] = $enviado;
print_r($proceso);
echo base64_encode(serialize($proceso));
 	
/*
	echo "Estructura de Carpetas:<hr>";
	echo "<pre>";
	print_r($Directorios);
	echo "</pre>";
	echo "<br>Listado de Archivos:<hr>";
	echo "<pre>";
	print_r($Archivos);
	echo "</pre>";
*/
die();


	




// Listar carpetas recursivamente para buscar todo el contenido
function listar_directorios_ruta($ruta){
	global $ruta_local, $num, $Directorios, $Archivos;
	$xruta = str_replace($ruta_local,'',$ruta);
	// abrir un directorio y listarlo recursivo
	if (is_dir($ruta)) {
		$Directorios[] = $xruta;
		//	echo "<br>Directorio: $xruta";	
		if ($dh = opendir($ruta)) {
			while (($file = readdir($dh)) !== false) {
				//esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
				//mostraría tanto archivos como directorios
				if ($file!='.' and $file!='..'){
					if (is_dir($ruta . $file) && $file!="." && $file!=".."){
						//solo si el archivo es un directorio, distinto que "." y ".."
						//echo "<br>Directorio: $ruta$file";
						listar_directorios_ruta($ruta . $file . "/");
					} else {
						$Archivos[$num]['nombre'] = "$xruta$file";
						$Archivos[$num]['fecha'] = "fecha";
						$Archivos[$num]['size'] = "size";
						$Archivos[$num]['subido'] = "";
						$num++;
						//echo "<br>Nombre de archivo: $xruta$file ";	
					}
				}
			}
			closedir($dh);
		}
	} else {
		echo "<br>No es ruta valida: $xruta";
	}
}

//- Obtener fecha de creacion/modificacion del archivo
function obtener_fecha($archivo) {
	if (file_exists($archivo)) {
	   return filectime($archivo);
	} else {
	   return '';	
	} 
}

//- Obtener tamaño del archivo
function obtener_size($archivo) {
	if (file_exists($archivo)) {
	   return filesize($archivo);
	} else {
	   return '';	
	} 
}


//- Crear una carpeta en el servidor remoto
function creardir($carpeta,$conn_id){
	$esta = @ftp_chdir ( $conn_id , $carpeta );
	if (!$esta ) {
		ftp_mkdir($conn_id,$carpeta);	
	}
}


//- Enviar el archivo al servidor
function enviar_archivo($file,$conn_id,$ruta_remota,$ruta_local){
	$date = ftp_mdtm($conn_id, $ruta_remota.''.$file);
	echo $file.": ".$date."<hr>";
	if (ftp_put($conn_id, $ruta_remota.''.$file , $ruta_local.''.$file, FTP_BINARY)){
		return 'si';
	}else {return 'no';}
}
?>