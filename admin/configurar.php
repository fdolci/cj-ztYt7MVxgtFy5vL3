<?php
    if (isset($_GET['panel'])) {$panel = $_GET['panel'] ;
    } elseif (isset($_POST['panel'])){$panel = $_POST['panel'];
    } else {$panel=1;}
    
    $item_menu[0] = 1; 
    if ($panel==1 ) { $item_menu[1] = 2; $titulo='Datos de la Empresa'; $title = 'Datos de la Empresa';} //Datos Empresa
    if ($panel==3 ) { $item_menu[1] = 5; $titulo='Iframe para ubicación con Google Maps'; $title = "Google Apps";} // Google Maps    
   
    
	include('header.php');
    if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	$submit = request('submit','');
    if (!empty($submit)) {
		foreach ($_POST as $clave => $valor){
			$sql 	= "update setting  set valor = '".$valor."' where name='".$clave."'";
			$rs 	= $db->Execute($sql);
		}
        echo mensaje_ok("Los cambios se guardaron correctamente");
	}

	$sql 	= "select * from setting where panel=$panel order by orden ASC";
	$rs 	= $db->Execute($sql);
	$stt	= $rs->GetRows();


?>
<h2><?php echo $titulo;?></h2>
<center>
<?php

	echo "<table width='800'>\n";
	echo "<form action='configurar.php' method='post'>\n";
	foreach ($stt as $clave => $valor){
		if ($bgcolor='#FFFFFF') {$bgcolor='#CCFFFF';} else {$bgcolor='#FFFFFF';}
		echo "<tr>";
		echo '<td width="300" class="th" style="text-align:right;padding-right:5px;">'.$valor[desc]."\n";
		echo "<td width='500'><textarea name='".$valor[name]."' row='1' cols='60'>".$valor[valor]."</textarea></td>\n";
		echo "</tr>";
	}
?>
		<tr>
			<td colspan="2" align="center"><br />
            <input type="hidden" name="panel" value="<?php echo $panel;?>" />
			<input type="submit" name="submit" value="Guardar Cambios" />
			</td>
		</tr>

		</form>
		</table>
</center>
		</td>
    </tr>
</table>
</div>
</body></html>