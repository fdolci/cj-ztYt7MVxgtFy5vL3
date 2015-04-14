<?php

	include ('../inc/config.php');

    $data = $_GET;

    //--------------- Obtengo los datos del Anuncio
    $rs = $db->SelectLimit("select * from productos where id='{$data['producto_id']}'",1);
    $Evento = $rs->FetchRow();
	$RutaProducto = obtiene_ruta_producto($data['producto_id']);
	
    $db->Execute("update productos set consultas=(consultas+1) where producto_id='{$data['producto_id']}'");

    //--------------- Obtengo los datos del Asociacion
    $rs = $db->SelectLimit("select * from usuarios where id='{$Evento['user_id']}'",1);
    $Usuario = $rs->FetchRow();

    // Actualizo Contador de formularios enviados
    $ano_mes = date("Y-m");
    $rs = $db->SelectLimit("select * from envio_formularios where producto_id='{$data['producto_id']}' and ano_mes='$ano_mes'",1);
    $Stats = $rs->FetchRow();
    if($Stats) {
        $Stats['cantidad'] = $Stats['cantidad']+1;
    } else {
        $Stats['id'] = 0;
        $Stats['cantidad'] = 1;
        $Stats['ano_mes'] = $ano_mes;
        $Stats['producto_id'] = $data['producto_id'];
    }

    $ok = $db->Replace('envio_formularios', $Stats,'id', $autoquote = true); 
    //------------ Fin actualizacion envio de formularios


    //---------------------------------------------------------------------------------------------
    //                                     Guardo los datos del consultante para mi base de mailing
    //---------------------------------------------------------------------------------------------
    unset($data['submit']);
    $data['user_id']     = $Evento['user_id'];
    $data['producto_id'] = $Evento['id'];
    $data['subject']     = 'Consulta: '.$Evento['titulo'];
    $data['fecha']       = date("Y-m-d H:i:s");
    $data['id']          = 0;
    $xx = $db->AutoExecute('base_mailing', $data, 'INSERT');        

	$base = $data;
	unset($data);
	
	
    $subject   = "[{$DatosEmpresa['nombre_empresa']}] Consulta {$Evento['titulo']}";

	$TituloMensaje = "Consulta realizada: <a href='$RutaProducto' style='color:#693D85;'>{$Evento['titulo']}</a>";
	$msg = "<table class='tbl_contenido'>";
	$msg.= "<tr><td class='td_titulo'>Apellido:</td><td class='td_contenido'><big>{$base['apellido']}</big></td></tr>";
	$msg.= "<tr><td class='td_titulo'>Nombre:</td><td class='td_contenido'><big>{$base['nombre']}</big></td></tr>";
	$msg.= "<tr><td class='td_titulo'>Email:</td><td class='td_contenido'><big>{$base['email']}</big></td></tr>";
	$msg.= "<tr><td class='td_titulo'>Teléfono:</td><td class='td_contenido'>{$base['telefono']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Ciudad:</td><td class='td_contenido'>{$base['ciudad']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Provincia:</td><td class='td_contenido'>{$base['provincia']}</td></tr>";
	$msg.= "<tr><td class='td_titulo'>Comentarios:</td><td class='td_contenido'>{$base['comentario']}</td></tr>";
	
	$msg.="</table>";
	
	$CuerpoMensaje = $msg;
	
	$EmailDestinatario = $Evento['email_informes'];
	

	
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

    //$mail->SetFrom('inscripciones@CongresosyJornadas.net', "Inscripciones CongresosyJornadas.net");
    $mail->SetFrom("{$base['email']}", "{$base['apellido']}, {$base['nombre']}");

    $mail->Subject    = $subject;
    $mail->AltBody    = "$CuerpoMensaje"; // optional, comment out and test
    $mail->MsgHTML($ContenidoMail);
    $mail->AddAddress($EmailDestinatario, "Consulta: {$Prod['titulo']}"); 
//    $mail->AddAddress("inscripciones@CongresosyJornadas.net", "Inscripción {$Prod['titulo']}"); 

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

		$mail->SetFrom('no-reply@CongresosyJornadas.net', "CongresosyJornadas.net");
		//$mail->AddReplyTo("name@yourdomain.com","First Last");

		$mail->Subject    = $subject;
		$mail->AltBody    = "$CuerpoMensaje"; // optional, comment out and test
		$mail->MsgHTML($ContenidoMail);
		$mail->AddAddress("{$base['email']}", "{$base['apellido']}, {$base['nombre']}"); 

		if(!$mail->Send()) {
		  $error = "Mailer Error: " . $mail->ErrorInfo;
		  $msg = mensaje_error("No se pudo enviar el formulario:<br>$error");

		} else {

			$msg = mensaje_ok('Consulta enviada correctamente!!<br>A la brevedad el Organizador se contactará con Ud.');
		}
    }

    echo $msg;
	
	
   
?>