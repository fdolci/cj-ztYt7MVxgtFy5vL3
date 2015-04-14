<?php

    $item_menu[0] = 1; 
    $item_menu[1] = 11; 
    $titulo = $title = 'Configuración de PHP Mailer';
    
	include('header.php');
    if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$submit = request('submit','');
    if (!empty($submit)) {
		foreach ($_POST as $clave => $valor){
			$sql 	= "update setting  set valor = '$valor' where name='$clave'";
			$rs 	= $db->Execute($sql);
		}
        echo mensaje_ok("Los cambios se guardaron correctamente");
	}

	$sql 	= "select * from setting where panel=7 order by orden ASC";
	$rs 	= $db->Execute($sql);
	$stt	= $rs->GetRows();


?>
<h2><?php echo $titulo;?></h2>
<center>
<?php

	echo "<table width='800'>\n";
	echo "<form action='config_phpmailer.php' method='post'>\n";
	foreach ($stt as $clave => $valor){
		if ($bgcolor='#FFFFFF') {$bgcolor='#CCFFFF';} else {$bgcolor='#FFFFFF';}
		echo "<tr>\n";
		echo '<td width="400" class="th" style="text-align:right;padding-right:5px;">'.$valor[desc]."\n";
		echo "<td width='400'><input type='text' name='{$valor[name]}' size='50' value='{$valor[valor]}' ></td>\n";
		echo "</tr>\n";

	}
?>
		<tr>
			<td colspan="2" align="center"><br />
            <input type="hidden" name="panel" value="<?=$panel;?>" />
			<input type="submit" name="submit" value="Guardar Cambios" />
			</td>
		</tr>

		</form>
		</table>
</center>
<pre>
<b><u>Ejemplo para configuración con Gmail:</u></b>
PHPMailer_Auth: Requiere Autorizacion (true | false): <b>true</b>
PHPMailer_Secure: Servidor seguro (ssl | tsl): <b>ssl</b>
PHPMailer_Host: Servidor de correo: <b>smtp.gmail.com</b>	
PHPMailer_Port: Puerto (465 | 587): <b>465</b>
PHPMailer_Username: <b>email@gmail.com</b>
PHPMailer_Password: <b>contraseña de gmail</b>	
</pre>