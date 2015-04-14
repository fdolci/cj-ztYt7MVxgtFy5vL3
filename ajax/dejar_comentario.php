<?php

	include ('../inc/config.php');

    $data = $_GET['data'];

    $comentario = $data['comentario'];
    unset($data['comentario']);

    //------------------------------------------------------------------------------------------------
    //                                                                       Existe ese comentarista ?
    //------------------------------------------------------------------------------------------------
        $sql = "select * from comentaristas where email='{$data['email']}'";
        $rs  = $db->SelectLimit($sql,1);
        $Existe = $rs->FetchRow();
        if($Existe) {
            $db->Execute("update comentaristas set cantidad = (cantidad+1) where email='{$data['email']}'");
        } else {
            $xx = $db->AutoExecute('comentaristas', $data, 'INSERT');                 
        }
    //------------------------------------------------------------------------------------------------


    $subject   = "[{$DatosEmpresa['nombre_empresa']}] Nuevo Comentario";

    $data['subject'] = $subject;
    $data['fecha']   = date("Y-m-d H:i:s");
    $data['id']      = 0;
    $data['fecha']   = time();


    //----------------- Grabo el comentario
    $data['id']        = 0;
    $data['user_id']   = $usuario_id;
    $data['publicado'] = 0;
    $data['fecha']   = date("Y-m-d H:i:s");
    $xx = $db->AutoExecute('comentarios', $data, 'INSERT');            

    $message   = "";
    $message .= '<span style="color:black;font-family:Verdana, Tahoma,Arial;font-size:12px;font-weight:normal;" >';
    $message .= "<b>Email:</b> {$data['email']}<br>";
    $message .= "<b>Comentario:</b> {$data['comentario']}<br>";


    // ------------------------------------------------------------------- PHP-Mailer
    $PHPMailer_Ruta     = $mipath.'modules/PHPMailer_5.2.1/';
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
    $mail->CharSet    = "UTF-8";
    $mail->SMTPDebug  = 1;

    $mail->SetFrom($data['email'], "$nombre");
    //$mail->AddReplyTo("name@yourdomain.com","First Last");

    $mail->Subject    = $subject;
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    $mail->MsgHTML($message);
    $mail->AddAddress($DatosEmpresa['email'], "{$DatosEmpresa['nombre_empresa']}"); 

    if(!$mail->Send()) {
      $error = "Mailer Error: " . $mail->ErrorInfo;
      $msg = mensaje_error('No se pudo guardar el comentario:<br>$error');

    } else {



      $msg = mensaje_ok('El comentario será visible en unos minutos. Muchas gracias');
    }

    echo $msg;
     
?>