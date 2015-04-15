<?php
	include_once('./inc/config.php');

		// Destruye todas las variables de la sesi&oacute;n
		session_unset();
		// Finalmente, destruye la sesi&oacute;n
		session_destroy();
	    
	    session_start();
	    
	    $Mensaje["mensaje"] = "Gracias por usar {$DatosEmpresa['nombre_empresa']}";
	    $Mensaje["tipo"]    = 'alert-success';
	    $_SESSION['Mensaje'] = $Mensaje;
	    $_SESSION['user_id']  = '';

	    redirect(URL);
	    die();
    	
?> 