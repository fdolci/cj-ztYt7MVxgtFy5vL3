<?php
    $mipath='../';
	include ('../inc/config.php');

    $data = $_POST['data'];

    $subject   = "[{$DatosEmpresa['nombre_empresa']}] Contacto web";


    $data['subject'] = $subject;
    $data['fecha']   = date("Y-m-d H:i:s");
    $data['id']      = 0;

    $xx = $db->AutoExecute('base_mailing', $data, 'INSERT');        


    //--------------- Obtengo los datos del Alojamiento
    $rs = $db->SelectLimit("select email, titulo from productos where id='{$data['producto_id']}'",1);
    $Alojamiento = $rs->FetchRow();



    $nombre = $data['apellido'].', '.$data['nombre'];
    $message   = "";
    $message .= '<span style="color:black;font-family:Verdana, Tahoma,Arial;font-size:12px;font-weight:normal;" >';
    $message .= "<b>Apellido:</b> {$data['apellido']}<br>";
    $message .= "<b>Nombre:</b> {$data['nombre']}<br>";
    $message .= "<b>Email:</b> {$data['email']}<br>";
    $message .= "<b>Telefono:</b> {$data['telefono']}<br>";
    $message .= "<b>Mensaje:</b> {$data['comentario']}<br>";


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
    $mail->AddAddress($Alojamiento['email'], "{$Alojamiento['titulo']}"); 

    if(!$mail->Send()) {
      $error = "Mailer Error: " . $mail->ErrorInfo;
      echo 'No se pudo enviar el formulario:<br>$error';

    } else {
      echo 'Formulario enviado correctamente!!<br>A la brevedad nos contactaremos con Ud.';
    }

     
?>