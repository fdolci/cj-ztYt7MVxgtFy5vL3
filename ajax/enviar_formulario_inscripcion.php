<?php
    $mipath='../';
	include ('../inc/config.php');

    $data = $_GET['form_data'];

	$sql = "select email_inscripcion,titulo from productos 
			where id='{$data['producto_id']}' and user_id='{$data['user_id']}'";
	$rs  = $db->SelectLimit($sql,1);
	$Prod = $rs->FetchRow();
	$RutaProducto = obtiene_ruta_producto($data['producto_id']);

	//---------------------------------------------------------------------------
	//             Grabo en mi base de mailing
	//---------------------------------------------------------------------------
	$base['id']             = 0;
	$base['user_id']        = $data['user_id'];
	$base['producto_id']    = $data['producto_id'];
	$base['subject']        = 'Inscripcion';
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
    $base['fecha']          = date("Y-m-d H:i:s");
    $xx = $db->AutoExecute('base_mailing', $base, 'INSERT');        
	unset($base['subject']);
	
	if(isset($data['forma_de_pago'])){ $existe_forma_de_pago=true; } else { $existe_forma_de_pago=false; }
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
			$base['importe']             = $arancel_importe;
			$base['moneda_id']           = $arancel_moneda;
			$base['arancel_id']          = $arancel_id;
		}
	}
	
	
	//---------------------------------------------------------------------------
	//             Grabo en la tabla de inscripciones
	//---------------------------------------------------------------------------
    $base['tipo_doc']  = $data['tipo_doc'];
    $base['nro_doc']   = intval($data['nro_doc'],10);
    $base['fecha']     = time();

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
	
	//----- Obtiene el ID del registro
	$sql = "select id from inscripciones 
			where producto_id='{$data['producto_id']}' 
				and user_id='{$data['user_id']}' 
				and fecha='{$base['fecha']}' 
				and email='{$base['email']}'";
	$rs = $db->SelectLimit($sql,1);				
	$xz = $rs->FetchRow();
	$inscripto_id = $xz['id'];
	
	unset($data);
	
    $subject   = "[{$DatosEmpresa['nombre_empresa']}] Inscripción";

	$TituloMensaje = "Formulario de Inscripción: <a href='$RutaProducto' style='color:#693D85;'>{$Prod['titulo']}</a>";
	$msg = "<table class='tbl_contenido'>";
	$msg.= "<tr><td class='td_titulo'>Apellido:</td><td class='td_contenido'><big>{$base['apellido']}</big></td></tr>";
	$msg.= "<tr><td class='td_titulo'>Nombre:</td><td class='td_contenido'><big>{$base['nombre']}</big></td></tr>";
	$msg.= "<tr><td class='td_titulo'>Email:</td><td class='td_contenido'><big>{$base['email']}</big></td></tr>";
	$msg.= "<tr><td class='td_titulo'>Teléfono:</td><td class='td_contenido'>{$base['telefono']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Documento:</td><td class='td_contenido'>{$base['tipo_doc']}: {$base['nro_doc']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Domicilio:</td><td class='td_contenido'>{$base['domicilio']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Ciudad:</td><td class='td_contenido'>{$base['ciudad']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Provincia:</td><td class='td_contenido'>{$base['provincia']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>País:</td><td class='td_contenido'>{$base['pais']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Cómo se entero de esta Actividad?:</td><td class='td_contenido'>{$base['como_se_entero']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Posición Arancelaria:</td><td class='td_contenido'>{$base['categoria_aranceles']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Importe Arancel:</td><td class='td_contenido'>{$base['importe']} {$Monedas[$arancel_moneda]}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Comentarios:</td><td class='td_contenido'>{$base['comentario']}</td></tr>";
	if(!empty($base['resto'])){
		$msg.= "<tr><td class='td_titulo'>Datos Personalizados:</td><td class='td_contenido'>{$base['resto']}</td></tr>";
	}
	
	$msg.="</table>";
	
	$CuerpoMensaje = $msg;
	
	$EmailDestinatario = $Prod['email_inscripcion'];
	
	include(ROOT.'/ajax/plantilla_email.html.php');
	

    // ------------------------------------------------------------------- PHP-Mailer
    $PHPMailer_Ruta     = ROOT.'/modules/PHPMailer_5.2.1/';
    include($PHPMailer_Ruta."class.phpmailer.php"); 
    include($PHPMailer_Ruta."class.smtp.php"); 
    $mail = new PHPMailer(); 

	//--------------------------------------------------------------------------
	//                                                Envia Mail al Organizador
	//--------------------------------------------------------------------------
    $mail->IsSMTP(); 
    $mail->SMTPAuth   = $PHPMailer['auth']; 
    $mail->SMTPSecure = $PHPMailer['secure']; 
    $mail->Host       = $PHPMailer['host']; 
    $mail->Port       = $PHPMailer['port']; 
    $mail->Username   = $PHPMailer['username']; 
    $mail->Password   = $PHPMailer['password'];
    $mail->CharSet    = "UTF-8";
    $mail->SMTPDebug  = 1;

    $mail->SetFrom('inscripciones@CongresosyJornadas.net', "Inscripciones CongresosyJornadas.net");
    //$mail->AddReplyTo("name@yourdomain.com","First Last");

    $mail->Subject    = $subject;
    $mail->AltBody    = "$CuerpoMensaje"; // optional, comment out and test
    $mail->MsgHTML($ContenidoMail);
    $mail->AddAddress($EmailDestinatario, "Inscripción {$Prod['titulo']}"); 
    $mail->AddAddress("inscripciones@CongresosyJornadas.net", "Inscripción {$Prod['titulo']}"); 

    if(!$mail->Send()) {
      $error = "Mailer Error: " . $mail->ErrorInfo;
      $msg = mensaje_error("No se pudo enviar el formulario:<br>$error");

    } else {

		//------------------------------------------------------------------------
		//                 Envia copia al inscripto
		//------------------------------------------------------------------------
		$mail = new PHPMailer(); 

		$mail->IsSMTP(); 
		$mail->SMTPAuth   = $PHPMailer['auth']; 
		$mail->SMTPSecure = $PHPMailer['secure']; 
		$mail->Host       = $PHPMailer['host']; 
		$mail->Port       = $PHPMailer['port']; 
		$mail->Username   = $PHPMailer['username']; 
		$mail->Password   = $PHPMailer['password'];
		$mail->CharSet    = "UTF-8";
		$mail->SMTPDebug  = 1;

		$mail->SetFrom('inscripciones@CongresosyJornadas.net', "Inscripciones CongresosyJornadas.net");
		//$mail->AddReplyTo("name@yourdomain.com","First Last");

		$mail->Subject    = $subject;
		$mail->AltBody    = "$CuerpoMensaje"; // optional, comment out and test
		$mail->MsgHTML($ContenidoMail);
		$mail->AddAddress("{$base['email']}", "{$base['apellido']}, {$base['nombre']}"); 

		if(!$mail->Send()) {
		  $error = "Mailer Error: " . $mail->ErrorInfo;
		  $msg = mensaje_error("No se pudo enviar el formulario:<br>$error");

		} else {

			$msg = mensaje_ok('Inscripción enviada correctamente!!<br>A la brevedad el Organizador se contactará con Ud.');

			if(isset($existe_forma_de_pago)) {
				$pagar['producto_id'] = $base['producto_id'];
				$pagar['user_id']     = $base['user_id'];
				$pagar['id']          = $inscripto_id;
				$zz = base64_encode(serialize($pagar));
				redirect(URL."/pagar.php?data=$zz");
				die();
			}

			
			
		}
    }

    echo $msg;
     
?>