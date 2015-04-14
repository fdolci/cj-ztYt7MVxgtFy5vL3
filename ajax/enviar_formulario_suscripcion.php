<?php
	include ('../inc/config.php');

    $data = $_GET['data'];

    $subject   = "[{$DatosEmpresa['nombre_empresa']}] Nuevo Suscriptor";

    $data['subject'] = $subject;
    $data['fecha']   = date("Y-m-d H:i:s");
    $data['id']      = 0;

    $xx = $db->AutoExecute('base_mailing', $data, 'INSERT');        

    ///----------- Cual es el grupo por Defecto?
    $rs = $db->SelectLimit("select id from grupos where defecto='1'",1);
    $xx = $rs->FetchRow();
    $grupo_defecto_id = $xx['id'];


    ///----------- Cual es el grupo de Suscriptores?
    $rs = $db->SelectLimit("select id from grupos where suscriptores='1'",1);
    $xx = $rs->FetchRow();
    $grupo_suscriptor_id = $xx['id'];

    //-- Existe en la tabla de usuarios ??
    $sql = "select id from usuarios where email='{$data['email']}'";
    $rs = $db->SelectLimit($sql,1);
    $usuario = $rs->FetchRow();

    if(!empty($usuario)){


        // Existe en el grupo por defecto
        $rs = $db->SelectLimit("select * from usuarios_grupos where usuario_id='{$usuario['id']}' and grupo_id='$grupo_defecto_id'",1);
        $usuario_grupo = $rs->FetchRow();
        if (empty($usuario_grupo)){
            // No pertence al grupo suscriptore, lo agrego
            $ud['id']         = 0;
            $ug['usuario_id'] = $usuario['id'];
            $ug['grupo_id']   = $grupo_defecto_id;
            $xx = $db->AutoExecute('usuarios_grupos', $ug, 'INSERT');        
        }


        // Existe en el grupo suscriptor
        $rs = $db->SelectLimit("select * from usuarios_grupos where usuario_id='{$usuario['id']}' and grupo_id='$grupo_suscriptor_id'",1);
        $usuario_grupo = $rs->FetchRow();
        if (empty($usuario_grupo)){
            // No pertence al grupo suscriptore, lo agrego
            $ud['id']         = 0;
            $ug['usuario_id'] = $usuario['id'];
            $ug['grupo_id']   = $grupo_suscriptor_id;
            $xx = $db->AutoExecute('usuarios_grupos', $ug, 'INSERT');        
        }

    } else {

        // NO existe como usuario, lo agrego
        $usuario['id']       = 0;
        $usuario['activo']   = 1;
        $usuario['username'] = $data['email'];
        $usuario['email']    = $data['email'];
        $usuario['clave']    = md5($data['email']);
        $ok = $db->AutoExecute('usuarios', $usuario, 'INSERT');        
        $usuario_id = $db->Insert_ID();

        // Lo agrego al grupo por defecto
        $ud['id']         = 0;
        $ug['usuario_id'] = $usuario_id;
        $ug['grupo_id']   = $grupo_defecto_id;
        $xx = $db->AutoExecute('usuarios_grupos', $ug, 'INSERT');        

        // Lo agrego al grupo por suscriptor
        $ud['id']         = 0;
        $ug['usuario_id'] = $usuario_id;
        $ug['grupo_id']   = $grupo_suscriptor_id;
        $xx = $db->AutoExecute('usuarios_grupos', $ug, 'INSERT');        

    }


    $message   = "";
    $message .= '<span style="color:black;font-family:Verdana, Tahoma,Arial;font-size:12px;font-weight:normal;" >';
    $message .= "<b>Email:</b> {$data['email']}<br>";


    // ------------------------------------------------------------------- PHP-Mailer
    $PHPMailer_Ruta     = ROOT.'/modules/PHPMailer_5.2.1/';
    include($PHPMailer_Ruta."class.phpmailer.php"); 
    include($PHPMailer_Ruta."class.smtp.php"); 
    $mail = new PHPMailer(); 

    $mail->IsSMTP(); 
    $mail->SMTPAuth   = $PHPMailer['auth']; 
    $mail->SMTPSecure = $PHPMailer['secure']; 
    $mail->Host       = $PHPMailer['host']; 
    $mail->Port       = $PHPMailer['port']; 
    $mail->Username   = $PHPMailer['username']; 
    $mail->Password   = $PHPMailer['password'];
    $mail->SMTPDebug  = 1;

    $mail->SetFrom($data['email'], "$nombre");
    //$mail->AddReplyTo("name@yourdomain.com","First Last");

    $mail->Subject    = $subject;
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    $mail->MsgHTML($message);
    $mail->AddAddress($DatosEmpresa['email'], "{$DatosEmpresa['nombre_empresa']}"); 

    if(!$mail->Send()) {
      $error = "Mailer Error: " . $mail->ErrorInfo;
      $msg = mensaje_error('No se pudo enviar el formulario:<br>$error');

    } else {
      $msg = mensaje_ok('Gracias por suscribirse');
    }

    echo $msg;
     
?>