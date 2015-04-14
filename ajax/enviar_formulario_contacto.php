<?php
    $mipath='../';
	include ('../inc/config.php');

    $data = $_GET['data'];

    $subject   = "[{$DatosEmpresa['nombre_empresa']}] Contacto web";


    // Registro en la bd
/*    
Field         Type          Collation        Null    Key     Default  Extra           Privileges                       Comment
------------  ------------  ---------------  ------  ------  -------  --------------  -------------------------------  -------
id            int(11)       (NULL)           NO      PRI     (NULL)   auto_increment  select,insert,update,references         
subject       varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
apellido      varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
nombre        varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
documento     varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
domicilio     varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
ciudad        varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
cp            varchar(20)   utf8_general_ci  YES             (NULL)                   select,insert,update,references         
provincia     varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
pais          varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
telefono      varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
movil         varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
email         varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
profesion     varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
especialidad  varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
institucion   varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
socio         varchar(2)    utf8_general_ci  YES             (NULL)                   select,insert,update,references         
como_entero   varchar(50)   utf8_general_ci  YES             (NULL)                   select,insert,update,references         
comentario    text          utf8_general_ci  YES             (NULL)                   select,insert,update,references         
fecha         varchar(20)   utf8_general_ci  YES             (NULL)                   select,insert,update,references         
arancel       varchar(255)  utf8_general_ci  YES             (NULL)                   select,insert,update,references         
fecha_pago    varchar(10)   utf8_general_ci  YES             (NULL)                   select,insert,update,references         
activo        tinyint(1)    (NULL)           NO              1                        select,insert,update,references             
*/
    $data['subject'] = $subject;
    $data['fecha']   = date("Y-m-d H:i:s");
    $data['id']      = 0;

    $xx = $db->AutoExecute('base_mailing', $data, 'INSERT');        

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
    $mail->AddAddress($DatosEmpresa['email'], "{$DatosEmpresa['nombre_empresa']}"); 

    if(!$mail->Send()) {
      $error = "Mailer Error: " . $mail->ErrorInfo;
      $msg = mensaje_error('No se pudo enviar el formulario:<br>$error');

    } else {
      $msg = mensaje_ok('Formulario enviado correctamente!!<br>A la brevedad nos contactaremos con Ud.');
    }

    echo $msg;
     
?>