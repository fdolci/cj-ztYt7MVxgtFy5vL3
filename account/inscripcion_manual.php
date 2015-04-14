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

	
	$id          = request('id',0);
	$user_id     = $_SESSION['user_id'];	
	$producto_id = request('producto_id',0);
	$accion      = request('accion','');

	$sql = "select * from productos where id='$producto_id' and user_id='$user_id'";
	$rs  = $db->SelectLimit($sql,1);
    $Producto = $rs->FetchRow();
	if(!$Producto){ die('Hacking attempt!!!'); }
	
	$sql = "select * from productos_inscripcion where producto_id='$producto_id' and user_id='$user_id' order by orden ASC";
	$rs  = $db->Execute($sql);
    $CamposBD = $rs->GetRows();

    //----------------------------------------------------------------
    //                                   Hay Aranceles ?
    //----------------------------------------------------------------
    $sql = "select * from productos_aranceles where producto_id='$producto_id' order by orden ASC";
    $rs  = $db->Execute($sql);
    $Aranceles = $rs->GetRows();
	
	
	if($_POST['submit']){
	
		//pr($_POST,1);

		$data = $_POST['form_data'];
		
		$fecha_inscripcion = mktime(0,0,0,$_POST['x_mes'],$_POST['x_dia'],$_POST['x_ano']);
		
		//---------------------------------------------------------------------------
		//             Grabo en mi base de mailing
		//---------------------------------------------------------------------------
		$base['id']             = 0;
		$base['user_id']        = $data['user_id'];
		$base['producto_id']    = $data['producto_id'];
		$base['subject']        = 'Inscripcion Manual';
		$base['apellido']       = $data['apellido'];
		$base['nombre']         = $data['nombre'];
		$base['domicilio']      = $data['domicilio'];
		$base['ciudad']         = $data['ciudad'];
		$base['provincia']      = $data['provincia'];
		$base['pais']           = $data['pais'];
		$base['email']          = $data['email'];
		$base['telefono']       = $data['telefono'];
		$base['como_se_entero'] = $data['como_se_entero'];
		$base['comentario']     = $data['comentario'];
		$base['fecha']          = date("Y-m-d H:i:s", $fecha_inscripcion);
		$db->debug = false;
		$xx = $db->AutoExecute('base_mailing', $base, 'INSERT');        
		unset($base['subject']);
		
		
		//--------------------------------------------------------------------------
		// Cual es la categoria de Arancel seleccionada
		//--------------------------------------------------------------------------
		$base['categoria_aranceles'] = '';
		$base['importe']   = 0;
		$base['moneda_id'] = 0;

		if(isset($data['categoria_aranceles'])){
			list($arancel_id, $arancel_importe, $arancel_moneda ) = explode('|',$data['categoria_aranceles']);
			$sql = "select * from productos_aranceles where id='$arancel_id' and user_id = '{$data['user_id']}' and producto_id = '{$data['producto_id']}' ";
			$rs  = $db->SelectLimit($sql,1);
			$Arancel = $rs->FetchRow();
			
			if($Arancel) {
				$base['categoria_aranceles'] = $Arancel['descripcion'];
				$base['importe']   = $arancel_importe;
				$base['moneda_id'] = $arancel_moneda;
			}
		}
		
		
		//---------------------------------------------------------------------------
		//             Grabo en la tabla de inscripciones
		//---------------------------------------------------------------------------
		$base['documento']           = $data['documento'];
		$base['fecha']               = $fecha_inscripcion;
		
		//--------------------------------------------------------------------------
		//                                                               Esta  pago?
		//--------------------------------------------------------------------------
		if( $_POST['fecha_pago_dia']>0 and $_POST['fecha_pago_mes']>0 and $_POST['fecha_pago_ano']>0  ) {
			$base['fecha_de_pago'] = mktime(0,0,0,$_POST['fecha_pago_mes'],$_POST['fecha_pago_dia'],$_POST['fecha_pago_ano']);
		}
		$base['anotaciones'] = $data['anotaciones'];
		
		//-------------------------------- Armo el resto de los datos del formulario
		$dato_armado = '';
		foreach($data as $clave=>$valor){
			if(substr($clave,0,2)=='c_'){
				list($nada,$tipo_campo_id) = explode('_',$clave);
				$sql = "select * from productos_inscripcion where id='$tipo_campo_id' ";
				$rs  = $db->SelectLimit($sql,1);
				$TipoCampo = $rs->FetchRow();
				if( $tipo_campo_id==8 ){
					//----------------------- CheckBox
					$dato_armado.= "<b>{$TipoCampo[etiqueta]}:</b> ";
					foreach($valor as $chk){$dato_armado.= "$chk | ";}
					$dato_armado.= "<br>";
				} else {
					$dato_armado.= "<b>{$TipoCampo[etiqueta]}:</b> $valor<br>";
				}
			
			}
		}
		
		$base['resto'] = $dato_armado;
		$xx = $db->AutoExecute('inscripciones', $base, 'INSERT');        
		
		
		
		
	
	}
	
    include_once(ROOT.'/html/header.html.php');
    include_once(ROOT.'/account/inscripcion_manual.html.php');
    include_once(ROOT.'/html/footer.html.php');

?>
