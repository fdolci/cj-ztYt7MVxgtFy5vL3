<?php
	include_once('./inc/config.php');
    
    if ($login) { 
        $Mensaje["mensaje"]   = $Traducciones['ya_logueado'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect(URL.'/index.php');
        die();
    }

    if (!empty($_POST['captcha'])) { 
        redirect(URL.'/index.php');
        die();
    }

    $breadcrumb[0]['href']  = URL;
    $breadcrumb[0]['title'] = $Traducciones['home'];
    $breadcrumb[1]['href']  = URL.'/login.php';
    $breadcrumb[1]['title'] = 'Login';
    $route='login';

    if ($_POST['accion'] == 'recordar_password') {
        
        $email = trim($_POST['data']['email']);

        if (!empty($email) ) {

            $sql   = "select * from usuarios where email='$email' ";
            $rs    = $db->SelectLimit($sql,1);
            $Usuario = $rs->FetchRow();

            if ($Usuario){


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
                $mail->SMTPDebug  = 1;
                $mail->CharSet = "UTF-8";
                $mail->SetFrom($DatosEmpresa['email'], "{$DatosEmpresa['nombre_empresa']}");
                //$mail->AddReplyTo("name@yourdomain.com","First Last");

                $recupero['id']    = $Usuario['id'];
                $recupero['email'] = $Usuario['email'];
                $recupero['dia']   = date(Ymd);
                $datos = base64_encode( serialize($recupero) );
                $url_recuperar = URL.'/resetear_password.php?data='.$datos;

                $message = 'Para reestablecer la contraseña, por favor haga click en el siguiente enlace, o copie y pegue en el navegador de internet.';
                $message.= '<br>';
                $message.= "<a href='$url_recuperar'>$url_recuperar</a>";


                $mail->Subject    = 'Reestablecer la Contraseña ';
                $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->MsgHTML($message);
                $mail->AddAddress($email, "{$Usuario['titulo']}"); 

                if(!$mail->Send()) {
                    $_SESSION['login']  = '';
                    $Mensaje["mensaje"] = 'ERROR, no se pudo enviar el formulario. Intente nuevamente en unos minutos. Gracias.';
                    $Mensaje["tipo"]    = 'error';
                    $Mensaje["autoclose"] = true;
                    $_SESSION['Mensaje'] = $Mensaje;                
                    redirect(URL.'/');
                    die();

                } else {
                    $_SESSION['login']  = '';
                    $Mensaje["mensaje"] = 'En unos minutos recibirá un email, con los pasos para reestablecer la contraseña';
                    $Mensaje["tipo"]    = 'success';
                    $Mensaje["autoclose"] = true;
                    $_SESSION['Mensaje'] = $Mensaje;                
                    redirect(URL.'/');
                    die();

                }

               

            } else {
                $Mensaje["mensaje"]   = 'ERROR, Usuario inexistente!!!';
                $Mensaje["tipo"]      = 'error';
                $Mensaje["autoclose"] = false;
                $_SESSION['Mensaje']  = $Mensaje;                
                $_SESSION['login']    = '';
                redirect(URL.'/');
                die();

            }
        }




    }


    include_once('./html/header.html.php');
    include_once('./html/login.html.php');
    include_once('./html/footer.html.php');

?>