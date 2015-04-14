<?php
	require('../inc/config.php');
    if( !esta_login() ) { 
        $Mensaje["mensaje"]   = $Traducciones['login_requerido'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['user_id']    = '';
        redirect(URL);   die();  
    }

	
	$user_id     = $_SESSION['user_id'];	
	$producto_id = request('producto_id',0);
	$certificado_id = request('certificado_id',0);

	//------------------------------------------------------
	//                         Obtiene los datos del evento
	//------------------------------------------------------
	$sql = "SELECT titulo, subtitulo FROM productos WHERE id='$producto_id' AND user_id='$user_id'";
	$rs = $db->Execute($sql);
	$Evento = $rs->FetchRow();
	if(empty($Evento)){
		redirect(URL.'/account/listar_anuncios.php');
		die();
	}

	$data    = request('data','');
	$data['producto_id'] = $producto_id;
	$data['id']          = $certificado_id;


	
	if(!empty($_FILES['img_certificado']['name'])){
		$destino = SUBIR_CERTIFICADOS."/";
		$x = explode('.',$_FILES['img_certificado']['name']);
		$extension = strtolower(end($x));
		$nombre = $producto_id.'-'.time().'.'.$extension;
		$temp   = $_FILES['img_certificado']['tmp_name'];

		if(move_uploaded_file($temp, $destino.$nombre)){
			$data['imagen'] = $nombre;
			
			//---------------------- Ajustamos el tamaño de la imagen
			$ruta_imagen = $destino.$nombre;
			$im = imagecreatefromjpeg("$ruta_imagen");

			//Original sizes
			$ow = imagesx($im); 
			$oh = imagesy($im);

			$width = '1170';
			$alto  = '770';
			
			//To fit the image in the new box by cropping data from the image, i have to check the biggest prop. in height and width
			if($width/$ow > $alto/$oh) {
				$nw = $width;
				$nh = ($oh*$nw)/$ow;
				$px = 0;
				$py = ($alto-$nh)/2;
			} else {
				$nh = $alto;
				$nw = ($ow * $nh) / $oh;
				$py = 0;
				$px = ($width-$nw) / 2;
			}
				   
			//Create a new image width requested size
			$new = imagecreatetruecolor($width,$alto);
				   
			//Copy the image loosing the least space
			imagecopyresampled($new, $im, $px, $py, 0, 0, $nw, $nh, $ow, $oh);
			$ok = imagejpeg( $new, $destino.$nombre, 90 );
			
		}		
	} else {
		$data['imagen'] = $data['imagen_original'];
	}

	unset($data['imagen_original']);		

	$data['updated'] = time();
	if( $data['id']==0 ){
		$data['created'] = time();
	}	
	
	$ok = $db->Replace('certificados', $data,'id', $autoquote = true); 			

	if ($ok) { 
    	$_SESSION['Mensaje']["mensaje"] = "El Registro se ha eliminado correctamente.";
        $_SESSION['Mensaje']["tipo"]    = 'alert-success';
	} else { 
    	$_SESSION['Mensaje']["mensaje"] = "ERROR! No se pudo eliminar el registro.";
        $_SESSION['Mensaje']["tipo"]    = 'alert-error';
	}

	redirect(URL.'/account/certificados.php?producto_id='.$producto_id);
	die();


?>