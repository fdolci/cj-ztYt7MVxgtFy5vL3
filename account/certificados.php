<?php

    include ('../inc/config.php'); 

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
	$accion      = request('accion','listar');


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

    include_once(ROOT.'/html/header.html.php');

	switch ($accion) {

		case 'editar':
			//------------------------------------------------------
			//                                Editar un Certificado
			//------------------------------------------------------
			$sql = "SELECT * FROM certificados WHERE producto_id='$producto_id' AND id='$certificado_id' ";
			$rs = $db->Execute($sql);
			$Certificado = $rs->FetchRow();

			if(empty($Certificado['titulo'])){
				$Certificado['titulo'] = $Evento['subtitulo'];
			}
			include_once(ROOT.'/account/certificados_editar.html.php');

			break;


		case 'eliminar':
			// Elimina la publicacion
			$cond 	= "update inscripciones set eliminado='1' where id='$id'";
			$ok		= $db->Execute($cond);
			$msg = '';
			if ($ok) { 
                $_SESSION['Mensaje']["mensaje"] = "El Registro se ha eliminado correctamente.";
                $_SESSION['Mensaje']["tipo"]    = 'alert-success';

			} else { 
                $_SESSION['Mensaje']["mensaje"] = "ERROR! No se pudo eliminar el registro.";
                $_SESSION['Mensaje']["tipo"]    = 'alert-error';
			}
			$id = 0;
			break;

		default:
			//------------------------------------------------------
			//                     Obtiene los certificados creados
			//------------------------------------------------------
			$sql = "SELECT * FROM certificados WHERE producto_id='$producto_id' ";
			$rs = $db->Execute($sql);
			$Certificados = $rs->GetRows();

		    include_once(ROOT.'/account/certificados.html.php');
		    break;
	}


    include_once(ROOT.'/html/footer.html.php');

?>
