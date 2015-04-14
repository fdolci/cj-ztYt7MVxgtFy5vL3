<?php
	include_once('header.php');
	$sql = "select * from admin where id>1";
	$rs 	= $db->SelectLimit($sql, 1);
	$usr	= $rs->GetRows();
	if (empty($usr)) {
		echo "<h2>No hay administradores definidos.</h2>";
	} else {
		$Username = $usr[0][username];
		$Password = $usr[0][password];
		$Email	  = $usr[0][email];

	    $emailto   = $Email;
		$emailsend = MAIL_AVISO;
		$subject   = "Recordatorio de contraseña: ".$HeaderTit;
		$message   = "";
		$message .= '<span style="color:black;font-family:Verdana, Tahoma,Arial;font-size:12px;font-weight:normal;" >';
		$message .= "

Recordatorio de contrase&ntilde;a:<br>
------------------------------------------<br>
Username: ".$Username."<br>
Contrase&ntilde;a: ".$Password."<br>
<br></span>";
				
		$encabezados = "From: ".$emailsend."\nContent-Type: text/html; charset=iso-8859-1";
		if (mail($emailto,$subject,$message, $encabezados)){
			echo "<h2>Se ha enviado un email con los datos de acceso.</h2>";
			echo "<br /><a href='login.php'>Regresar</a>";
		} else {
			echo "<h2>No se pudo enviar un email con los datos de acceso.</h2>";
			echo "<br /><a href='login.php'>Regresar</a>";
		}

	}
?>