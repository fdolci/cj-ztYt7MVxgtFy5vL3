<?php
	include_once('./inc/config.php');
    $email     = strtolower(request('email',''));

    if ( isset($_POST['submit']) ){

            $ResultadoEnvio='';
        
        		    $emailto   = $DatosEmpresa['email'];
        			$emailsend = $email;
        			$subject   = 'Suscripcion al Boletin';
        			$message   = "";
        			$message .= '<span style="color:black;font-family:Verdana, Tahoma,Arial;font-size:12px;font-weight:normal;" >';
        			$message .= "
        
        			Suscripcion al sitio web:<br>
        			------------------------------------------<br>
        			Fecha: ".date("d-m-Y H:i",time())."<br>
        			<b>Email:</b> ".$email."<br>";
        
        
        		 	$encabezados = "From: ".$emailsend."\nContent-Type: text/html; charset=iso-8859-1";
                    
                    $sql = "select * from suscriptores where email='$email'";
                    $rs  = $db->SelectLimit($sql,1);
                    $existe = $rs->FetchRow();
                    if (!$existe){
                        $sql = "insert into suscriptores (email,fecha) values ('$email','".time()."')";
                        $rs  = $db->Execute($sql);
    
                        
            	 		if (mail($emailto,$subject,$message, $encabezados)) {
                            $Mensaje["mensaje"]   = "Gracias por suscribirse al Bolet&iacute;n de Noticias";
                            $Mensaje["tipo"]      = 'success';
                            $Mensaje["autoclose"] = false;
                            $_SESSION['Mensaje']  = $Mensaje;
                            redirect( URL.'/index.php'); 
            	 		} else { 
                            $Mensaje["mensaje"]   = "No se pudo realizar la suscripci&oacute;n, por favor intente nuevamente";
                            $Mensaje["tipo"]      = 'error';
                            $Mensaje["autoclose"] = false;
                            $_SESSION['Mensaje']  = $Mensaje;

                        }
                        
                    } else {
                        $Mensaje["mensaje"]   = "Ud. ya se encontraba suscripto al Bolet&iacute;n";
                        $Mensaje["tipo"]      = 'error';
                        $Mensaje["autoclose"] = false;
                        $_SESSION['Mensaje']  = $Mensaje;
                        
                    }
        
 
    }
	
	$route = 'frm_suscripcion.php';
    $oculta_publicidad_top  = true;
    include_once(ROOT.'/inc/inc_publicidad.php');

    include_once(ROOT.'/html/header.html.php');        

    include_once(ROOT.'/html/formulario_suscripcion.html.php');        

    //include_once(ROOT.'/html/footer.html.php');
	
?>

