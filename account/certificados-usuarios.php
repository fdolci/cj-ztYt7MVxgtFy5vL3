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

	
	$letra	     = request('letra','todos');

	$user_id     = $_SESSION['user_id'];	
	$certificado_id = request('certificado_id',0);
	$inscripto_id = request('inscripto_id',0);
	$producto_id = request('producto_id',0);
	$accion      = request('accion','listar');


	//---------------------------------------------------------------------
	//   Obtiene los datos del evento y valida que tenga derechos de acceso
	//---------------------------------------------------------------------
	$sql = "SELECT titulo, subtitulo FROM productos WHERE id='$producto_id' AND user_id='$user_id'";
	$rs = $db->Execute($sql);
	$Evento = $rs->FetchRow();
	if(empty($Evento)){
		redirect(URL.'/account/listar_anuncios.php');
		die();
	}



	//--------------------------------------------------------------------------------
	//                                Recibo por ajax la solicitud de cambio de estado
	//--------------------------------------------------------------------------------
	if($accion=='cambiar-estado' && $inscripto_id>0 && $certificado_id>0 && $producto_id>0 ){
		$sql = "SELECT * FROM certificados_inscriptos 
					WHERE producto_id='$producto_id' 
					AND certificado_id='$certificado_id'
					AND inscripto_id='$inscripto_id' ";
		$rs = $db->Execute($sql);
		$x = $rs->FetchRow();

		if( empty($x) ){
			//----------------------------------- es nuevo
			$data['id']             = 0;
			$data['producto_id']    = $producto_id;
			$data['certificado_id'] = $certificado_id;
			$data['inscripto_id']   = $inscripto_id;
			$data['code']           = md5($producto_id.$certificado_id.$inscripto_id.time());
			$xx = $db->AutoExecute('certificados_inscriptos', $data, 'INSERT');
			echo 1;
			die();
		} else {
			//-----------------------------------existe - lo elimino
			$sql = "DELETE FROM certificados_inscriptos WHERE id = '{$x['id']}'";
			$rs = $db->Execute($sql);
			echo 0;
			die();
		}
	}

	//--------------------------------------------------------------------------------
	//                                                   Tengo que seleccionar a todos 
	//--------------------------------------------------------------------------------
	if($accion=='todos' && $certificado_id>0 && $producto_id>0 ){

		//----------------------------------------------------------------
		//                               Obtiene los inscriptos por letra
		//
	    if ($letra=='todos'){
	    	$sql="SELECT * FROM inscripciones WHERE producto_id='$producto_id' AND eliminado='0' ORDER BY apellido ASC, nombre ASC";	
	    } else {
	    	$sql="SELECT * FROM inscripciones WHERE LEFT(apellido,1)='$letra' AND producto_id='$producto_id' AND eliminado='0' ORDER BY apellido ASC, nombre ASC";
	    }
		$rs = $db->Execute($sql);
		$Inscriptos = $rs->GetRows();

		foreach( $Inscriptos as $i){

			//----------------------------------------------------------------
			//                                                     ya existe?
			//
			$inscripto_id = $i['id'];
			$sql = "SELECT * FROM certificados_inscriptos 
						WHERE producto_id='$producto_id' 
						AND certificado_id='$certificado_id'
						AND inscripto_id='$inscripto_id' ";
			$rs = $db->Execute($sql);
			$x = $rs->FetchRow();

			if( empty($x) ){
				//----------------------------------- es nuevo
				$data['id']             = 0;
				$data['producto_id']    = $producto_id;
				$data['certificado_id'] = $certificado_id;
				$data['inscripto_id']   = $inscripto_id;

				$xx = $db->AutoExecute('certificados_inscriptos', $data, 'INSERT');
			}

		}

	}

	//--------------------------------------------------------------------------------
	//                                                Tengo que De-seleccionar a todos 
	//--------------------------------------------------------------------------------
	if($accion=='ninguno' && $certificado_id>0 && $producto_id>0 ){

		//----------------------------------------------------------------
		//                               Obtiene los inscriptos por letra
		//
	    if ($letra=='todos'){
	    	$sql="SELECT * FROM inscripciones WHERE producto_id='$producto_id' AND eliminado='0' ORDER BY apellido ASC, nombre ASC";	
	    } else {
	    	$sql="SELECT * FROM inscripciones WHERE LEFT(apellido,1)='$letra' AND producto_id='$producto_id' AND eliminado='0' ORDER BY apellido ASC, nombre ASC";
	    }
		$rs = $db->Execute($sql);
		$Inscriptos = $rs->GetRows();

		foreach( $Inscriptos as $i){

			//----------------------------------------------------------------
			//                                                     ya existe?
			//
			$inscripto_id = $i['id'];
			$sql = "SELECT * FROM certificados_inscriptos 
						WHERE producto_id='$producto_id' 
						AND certificado_id='$certificado_id'
						AND inscripto_id='$inscripto_id' ";
			$rs = $db->Execute($sql);
			$x = $rs->FetchRow();

			if( !empty($x) ){
				//-----------------------------------existe - lo elimino
				$sql = "DELETE FROM certificados_inscriptos WHERE id = '{$x['id']}'";
				$rs = $db->Execute($sql);
			}

		}

	}


	//----------------------------------------------------------------
	//               Obtiene los certificados creados para este evento
	//----------------------------------------------------------------
	$sql = "SELECT id, nombre FROM certificados WHERE producto_id='$producto_id'";
	$rs = $db->Execute($sql);
	$Certificados = $rs->GetRows();
	$certificado_nombre = '';
	if(!empty($Certificados)){

		if( $certificado_id==0 ) { $certificado_id = $Certificados[0]['id']; }

		foreach( $Certificados as $key => $value ){
			if($value['id'] == $certificado_id){ $certificado_nombre = $value['nombre']; }
			break;
		}
	}

	//----------------------------------------------------------------
	//           Obtiene los registrados para recibir este certificado
	//----------------------------------------------------------------
	$sql = "SELECT * FROM certificados_inscriptos WHERE producto_id='$producto_id' AND certificado_id='$certificado_id' ";
	$rs = $db->Execute($sql);
	$x = $rs->GetRows();
	$arrRegistrados = array();
	if(!empty($x)){
		foreach( $x as $reg){
			$arrRegistrados[$reg['inscripto_id']] = 1;
		}
	}


	//----------------------------------------------------------------
	//                                              Obtiene las letras
	//----------------------------------------------------------------
	$sql="SELECT LEFT(TRIM(apellido),1) AS letra 
			FROM inscripciones 
			WHERE producto_id='$producto_id' AND eliminado=0 GROUP BY LEFT(apellido,1)";
	$rs = $db->Execute($sql);
	$Letras = $rs->GetRows();

	//----------------------------------------------------------------
	//                               Obtiene los inscriptos por letra
	//----------------------------------------------------------------
    if ($letra=='todos'){
    	$sql="SELECT * FROM inscripciones WHERE producto_id='$producto_id' AND eliminado='0' ORDER BY apellido ASC, nombre ASC";	
    } else {
    	$sql="SELECT * FROM inscripciones WHERE LEFT(apellido,1)='$letra' AND producto_id='$producto_id' AND eliminado='0' ORDER BY apellido ASC, nombre ASC";
    }
	$rs = $db->Execute($sql);
	$Inscriptos = $rs->GetRows();
	
	
    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/account/certificados-usuarios.html.php');
    include_once(ROOT.'/html/footer.html.php');

?>