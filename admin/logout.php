<?php
	include_once('header.php');
    
	// Destruye todas las variables de la sesi&oacute;n
	session_unset();
	// Finalmente, destruye la sesi&oacute;n
	session_destroy();
    
	redirect("index.php".$msg);
?> 