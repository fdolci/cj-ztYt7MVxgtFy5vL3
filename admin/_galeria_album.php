<?php

if (!isset($_SESSION["admin"]) or $Permisos['galeria']!=1 ) {redirect("../login.php");	exit(); }

if ($album_id>0){
	$sql = "select * from galeria_album where id='$album_id'";
	$rs  = $db->SelectLimit($sql,1);
	$z   = $rs->FetchRow();
}

?>
<h2>Album de fotos</h2>
<a href='galeria.php?album_id=0'>Crear Album</a>
<table width='90%' style="border-width:1px; border-style:solid; border-color:#000000;" cellpadding='3'>
	<tr bgcolor='#0271E3'>
		<td width='10' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">ID</td>
		<td width='20' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Orden</td>
		<td width='80' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Acci&oacute;n</td>
		<td style="color:#FFFFFF; font-weight:bold; font-size:12px;">Nombre</td>
	</tr>
<?php
	$cond = "select * from galeria_album order by orden ASC";
    $rs 	= $db->Execute($cond);
    $ax = $rs->GetRows();
	if (empty($ax)) {
		echo "<tr><td colspan='4'><h3><center>No existen &aacute;lbumes</center></h3></td></tr>";
	} else {
		foreach($ax as $x){
			if ($color=='#99CCFF')  {$color = '#00CCFF';} else {$color = '#99CCFF';}
?>
	<tr bgcolor=<?=$color;?>>
		<td width='10' style="color:#000000; font-weight:bold; font-size:12px;"><?=$x['id'];?></td>
		<td width='20' style="color:#000000; font-weight:bold; font-size:12px;">
			<a href='galeria.php?accion=album_orden&sube=no&album_id=<?=$x[id];?>'
				title='Bajar de Nivel' >	<img src='<?=ADMIN;?>img/abajo.gif' border='0' /></a>
			<a href='galeria.php?accion=album_orden&sube=si&album_id=<?=$x[id];?>'
				title='Subir de Nivel' >	<img src='<?=ADMIN;?>img/arriba.gif' border='0' /></a>

		</td>
		<td width='20' style="color:#000000; font-weight:bold; font-size:12px;">
			<a href='galeria.php?accion=album_eliminar&album_id=<?=$x[id];?>'
				title='Eliminar este Album'
				onclick="return confirm('Est&aacute; seguro de eliminar este Album?');">
				<img src='<?=ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;
			<a href='galeria.php?accion=album_estado&album_id=<?=$x[id];?>'
				title='Activar / Desactivar' >
				<?php if ($x[activo]==1){ echo "<img src='".ADMIN."img/activo.gif' border='0' />";
				} else { echo "<img src='".ADMIN."img/inactivo.gif' border='0' />"; }
				?></a>&nbsp;&nbsp;

			<a href='galeria.php?album_id=<?=$x[id];?>' title='Editar este Album'>
				<img src='<?=ADMIN;?>img/edit.gif' border='0' /></a>

		</td>
		<td style="color:#000000; font-weight:bold; font-size:12px;">
			<a href='galeria.php?accion=mostrar_album&album_id=<?=$x['id'];?>'><?=$x['album'];?></a>
		</td>
	</tr>


<?php

		}
	}

?>

</table>
<br>
<h2>Crear / Modificar un &aacute;lbum:</h2>
<form name='album' action='galeria.php?accion=album_guardar' method='post'>
<small><b>ID:</b></small> <?php echo $z[id];?><br>
<small><b>Nombre:</b></small> <input type='text' name='nombre' value='<?php echo $z[album];?>'>
<input type='hidden' name='album_id' value='<?php echo $z[id];?>' >
<input type='submit' name='guardar_album' value='Guardar Cambios'>
</form>