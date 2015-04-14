<?php
    $mipath='../';
	include ('../inc/config.php');

    $producto_id = $_SESSION['login'];
    if($producto_id==0){
        die();
    }

    if($_POST) {

        $sql = "select * from productos where id='$producto_id'";
        $rs  = $db->SelectLimit($sql,1);
        $Prod = $rs->FetchRow();

        $subject   = "[{$Prod['titulo']}] Solicita Tarifas";
        $data['subject'] = $subject;
        $data['fecha']   = date("Y-m-d H:i:s");
        $data['id']      = 0;

        $nombre = $Prod['persona_contacto'];
        $message   = "";
        $message .= '<span style="color:black;font-family:Verdana, Tahoma,Arial;font-size:12px;font-weight:normal;" >';
        $message .= "<b>Persona de Contacto:</b> {$Prod['persona_contacto']}<br>";
        $message .= "<b>Email:</b> {$Prod['email']}<br>";
        $message .= "<b>Telefono:</b> {$Prod['telefono']}<br>";
        $message .= "<b>Mensaje:</b> SOLICTA TARIFAS PUBLICITARIAS<br>";

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


        $mail->SetFrom($Prod['email'], "$nombre");

        //$mail->AddReplyTo("name@yourdomain.com","First Last");

        $mail->Subject    = $subject;
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $mail->MsgHTML($message);
        $mail->AddAddress($DatosEmpresa['email'], "{$DatosEmpresa['nombre_empresa']}"); 
        

        if(!$mail->Send()) {
          $error = "Mailer Error: " . $mail->ErrorInfo;
          $msg = mensaje_error('No se pudo enviar el formulario:<br>$error');

        } else {
          $msg = mensaje_ok('Formulario enviado correctamente!!<br>A la brevedad nos contactaremos con Ud.');
        }
        echo $msg;
    } else {
?>
    <link rel="stylesheet" href="<?php echo URL;?>/css/formularios.css" type="text/css" media="screen" />
    <form action='enviar_promociones.php' method='post'>
        <input type='submit' name='enviar' id='enviar' value='Enviarme las Tarifas' title='Haga click aquí y le enviaremos las tarifas'>
    </form>



<?php        
    }    
    
?>