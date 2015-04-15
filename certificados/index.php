<?php
	include ('../inc/config.php');

    $data = request('data', false);

    if ( $data ){


        $email = trim($data['email']);
        $eventoId = trim($data['evento_id']);


        if (!empty($email) and $eventoId>0 ) {

            $clave = md5($clave);

            $sql   = "SELECT * FROM inscripciones WHERE email='$email' AND producto_id='$eventoId' AND eliminado='0'";
            $rs    = $db->SelectLimit($sql,1);
            $Usuario = $rs->FetchRow();

            if ($Usuario){

                //-----------------------------------------------------------------------------
                //                                Obtiene los certificados 
                //-----------------------------------------------------------------------------
                $sql = "SELECT ci.certificado_id, c.nombre, p.titulo, ci.code
                        FROM certificados_inscriptos AS ci
                        LEFT JOIN certificados AS c on ci.certificado_id = c.id
                        LEFT JOIN productos AS p on ci.producto_id = p.id
                        WHERE ci.inscripto_id='{$Usuario['id']}'
                        AND ci.producto_id = '$eventoId' ";
                $rs  = $db->Execute($sql);
                $Certificados = $rs->GetRows();

                if (!empty($Certificados) ) {
                    //------------------------------------------------------------
                    // Envío mail con los links a las descarga de los certificados
                    //------------------------------------------------------------

                    $subject   = "[{$DatosEmpresa['nombre_empresa']}] Certificados";

                    $TituloMensaje = "Descarga de Certificados";

                    $link = URL.'/certificados/descarga.php?code=';
                    $msg = '';
                    foreach($Certificados as $cert){
                        $msg.= '<b>'.$cert['titulo'].'<b> - Descargar certificado: ';
                        $msg.= '<a href="'.$link.$cert['code'].'" style="color:#000;text-decoration:underline;">'.$cert['nombre'].'</a><br>'; 
                    }

                    $CuerpoMensaje = $msg;
                    
                    $EmailDestinatario = $email;
                    
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

                    $mail->SetFrom('inscripciones@CongresosyJornadas.net', "Certificados - CongresosyJornadas.net");
                    //$mail->AddReplyTo("name@yourdomain.com","First Last");

                    $mail->Subject    = $subject;
                    $mail->AltBody    = "$CuerpoMensaje"; // optional, comment out and test
                    $mail->MsgHTML($ContenidoMail);
                    
                    $mail->AddAddress("$email", "{$Usuario['apellido']}, {$Usuario['nombre']}"); 

                    if(!$mail->Send()) {
                        $error = "Mailer Error: " . $mail->ErrorInfo;

                        $Mensaje["mensaje"] = "No se pudo enviar el mail de Descarga. Por favor intente mas tarde. Gracias";
                        $Mensaje["tipo"]    = 'error';
                        $Mensaje["autoclose"] = true;
                        $_SESSION['Mensaje'] = $Mensaje;                

                    } else {

                        $Mensaje["mensaje"] = "Se le ha enviado un email con los enlaces para descargar los certificados.";
                        $Mensaje["tipo"]    = 'success';
                        $Mensaje["autoclose"] = true;
                        $_SESSION['Mensaje'] = $Mensaje;                

                    }

                } else {
                    $Mensaje["mensaje"] = "Aún no posee certificados para descargar. Por favor vuelva a intentarlo más tarde. Gracias!";
                    $Mensaje["tipo"]    = 'error';
                    $Mensaje["autoclose"] = true;
                    $_SESSION['Mensaje'] = $Mensaje;                

                }


            } else {
                $Mensaje["mensaje"] = "Usuario inexistente o inactivo. Por favor vuelva a intentarlo. Gracias!";
                $Mensaje["tipo"]    = 'error';
                $Mensaje["autoclose"] = true;
                $_SESSION['Mensaje'] = $Mensaje;                
            }

        } else {
            $Mensaje["mensaje"] = "Debe ingresar la dirección de Correo electrónico y el Evento en el cual se Registró.";
            $Mensaje["tipo"]    = 'error';
            $Mensaje["autoclose"] = true;
            $_SESSION['Mensaje'] = $Mensaje;                
        }
    } // end if $_POST


    // Obtención de eventos que emiten certificados
    $sql = "select id,titulo from productos where activo='1' and certificados='1' order by desde DESC";
    $rs      = $db->Execute($sql);
    $Eventos = $rs->GetRows();    

    $cat_id = 0;
    $mostrar_en_home = 1;
    $breadcrumb[0]['href']  = URL;
    $breadcrumb[0]['title'] = $Traducciones['home'];
    $breadcrumb[1]['href']  = URL.'/certificados/index.php';
    $breadcrumb[1]['title'] = 'Solicitud de Certificados';

    $route = 'login.php';
    $oculta_publicidad_top  = false;
    include_once(ROOT.'/inc/inc_publicidad.php');

    include_once(ROOT.'/html/header.html.php');        

    include_once(ROOT.'/certificados/index.html.php');        

    include_once(ROOT.'/html/footer.html.php');
  

?>