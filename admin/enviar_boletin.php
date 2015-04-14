<?php

    $mipath='../';
	include ('../inc/config.php');
    $de_donde = '';
    
    if (!isset($_SESSION["admin"])) {
        redirect(URL);
        die();
    }
    
    $boletin_id = request('boletin_id',0);
    if ($boletin_id == 0) {
        $Mensaje["mensaje"]   = "Bolet&iacute;n inexistente!!";
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        redirect( URL.'/index.php');
    }

    $categoria_boletin = ($Config['categoria_boletin']);
    
    set_time_limit(0);
    
    $boletin = busco_publicacion('',$boletin_id);
    $pagina = file_get_contents(URL."/ver_boletin.php?boletin_id=$boletin_id",FILE_USE_INCLUDE_PATH);
    



	//------------------------------------------Listado de Usuarios pertenecientes al Rol seleccionado
	$cond 		= "select email from suscriptores where activo=1";
	$rs 		= $db->Execute($cond);
	$Usuarios 	= $rs->GetRows();

    if (empty($Usuarios)){ echo "No hay usuarios en los grupos elegidos."; die();}
    $body    = $pagina;

    foreach($Usuarios as $dest){

        $asunto  = $boletin['titulo'];
        
        //$Para    = $dest['email']." <".$dest['email']."> ";
        $Para    = $dest['email'];

        $Origen = $DatosEmpresa['email'];

        // Para enviar correo HTML, la cabecera Content-type debe definirse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $cabeceras .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
        
        // Cabeceras adicionales
          $cabeceras .= 'From: '.$Origen . "\r\n";
          
          $cabeceras = "From: ".$Origen."\nContent-Type: text/html; charset=utf-8";
/*
echo "$asunto<br>";
echo "$body<br>";
echo "$Para<br>";
echo "$cabeceras<br>";
*/
 		if (mail($Para,$asunto,$body, $cabeceras)){
 		   echo "Enviado a: ".$Para."<br>";
 		} else {
 		   echo "<b>NO</b> Enviado a: ".$Para."<br>";
 		}
        sleep(2);


    }

?>