<?php
	include('./inc/config.php');

	$id = request('id',0);
	if ($id==0){ die(); }

	$rs = $db->SelectLimit("select * from productos_archivos where id='$id' and activo='1' ",1);
	$archivo = $rs->FetchRow();

	$nombre_original = SUBIR_ARCHIVOS.'/'.$archivo['archivo'];

	$z         = explode('.',$archivo['archivo']);
	$extension = end($z);

	$file = $archivo['titulo'].'.'.$extension;

	$type = '';

	if ( is_file($nombre_original) ) {
 		$size = filesize($nombre_original);
 		if (function_exists('mime_content_type')) {
 			$type = mime_content_type($nombre_original);
 		} elseif ( function_exists('finfo_file') ) {
 			$info = finfo_open(FILEINFO_MIME);
 			$type = finfo_file($info, $nombre_original);
 			finfo_close($info);
 		}
 		
 		if ($type == '') {
 			$type = "application/force-download";
 		}
		// Definir headers
		header("Content-Type: $type");
		header("Content-Disposition: attachment; filename=$file");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . $size);
		// Descargar archivo
		readfile($nombre_original);
		
		$ok = $db->Execute("update productos_archivos set descargas=(descargas+1) where id='$id' and activo='1' ");		
	} else {
 		echo $nombre_original;
 		die("El archivo no existe.");
	}
?>