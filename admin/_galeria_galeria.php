<center>
<h2>Fotos del Departamento</h2>
<table width='80%' style="border-width:1px; border-style:solid; border-color:#000000;" cellpadding='8' cellspacing="1">
	<tr bgcolor='#000'>
		<td width='10' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">ID</td>
		<td width='20' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Orden</td>
		<td width='80' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Acci&oacute;n</td>
		<td style="color:#FFFFFF; font-weight:bold; font-size:12px;">Foto</td>
	</tr>
<?php
	$sql = "select * from departamentos_fotos where departamento_id='$dpto_id' order by orden ASC";
	$rs  = $db->Execute($sql);
    $ax = $rs->GetRows();
    
	if (empty($ax)) {
		echo "<tr><td colspan='4'><h3><center>No existen fotos para ese Departamento</center></h3></td></tr>";
	} else {
		foreach($ax as $x){
			if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
?>
	<tr bgcolor=<?=$color;?> >
		<td width='10' style="color:#000000; font-weight:bold; font-size:12px;"><?=$x['id'];?></td>
		<td width='20' style="color:#000000; font-weight:bold; font-size:12px;">
			<a href="galeria.php?accion=foto_orden&sube=no&dpto_id=<?=$dpto_id;?>&foto_id=<?=$x[id];?>"
				title='Bajar de Nivel' >	<img src='<?=ADMIN;?>img/abajo.gif' border='0' /></a>
			<a href='galeria.php?accion=foto_orden&sube=si&dpto_id=<?=$dpto_id;?>&foto_id=<?=$x[id];?>'
				title='Subir de Nivel' >	<img src='<?=ADMIN;?>img/arriba.gif' border='0' /></a>

		</td>
		<td width='20' align='center' style="color:#000000; font-weight:bold; font-size:12px;">
			<a href='galeria.php?accion=foto_eliminar&dpto_id=<?=$dpto_id;?>&foto_id=<?=$x[id];?>'
				title='Eliminar esta Foto'
				onclick="return confirm('Est&aacute; seguro de eliminar esta Foto?');">
				<img src='<?=ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='galeria.php?accion=foto_estado&dpto_id=<?=$dpto_id;?>&foto_id=<?=$x[id];?>' title='Activar / Desactivar' >
				<?php if ($x[activo]==1){ echo "<img src='".ADMIN."img/activo.gif' border='0' />";
				} else { echo "<img src='".ADMIN."img/inactivo.gif' border='0' />"; }
				?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='galeria.php?accion=foto_editar&dpto_id=<?=$dpto_id;?>&foto_id=<?=$x[id];?>' title='Editar esta Foto'>
				<img src='<?=ADMIN;?>img/edit.gif' border='0' /></a>

		</td>

		<td style="color:#000000; font-weight:bold; font-size:12px;" valign='middle'>
			<img src='<?=$x['archivo'];?>' height='70' width='70' title="<?=$x['descripcion'];?>" /> <?=$x['nombre1'];?>
		</td>

	</tr>


<?php

		}
	}

?>

</table>
</center>

<br/>
<center><h2>Agregar / Modificar foto</h2></center>
<form name='foto' action='galeria.php?accion=<?=$accion;?>' method='post' >

<table width="70%">
<?php
    echo "<tr><td align='right'><strong>".$Idiomas[0]['name'].":</strong></td><td> <input type='text' name='nombre1' size='60' value='{$Foto['nombre1']}' /><small>Etiqueta 'Alt'</small></td></tr>";
    if (!empty($Idiomas[1]['name'])) {
        echo "<tr><td align='right'><strong>".$Idiomas[1]['name'].":</strong></td><td> <input type='text' name='nombre2' size='60' value='{$Foto['nombre2']}' /><small>Etiqueta 'Alt'</small></td></tr>";    
    } else {
        echo "<input type='hidden' name='valor[nombre2]' size='60' value='' />";
    }
    if (!empty($Idiomas[2]['name'])) {
        echo "<tr><td align='right'><strong>".$Idiomas[2]['name'].":</strong></td><td> <input type='text' name='nombre3' size='60' value='{$Foto['nombre3']}' /><small>Etiqueta 'Alt'</small></td></tr>";    
    } else {
        echo "<input type='hidden' name='valor[nombre3]' size='60' value='' />";
    }
    if (!empty($Idiomas[3]['name'])) {
        echo "<tr><td align='right'><strong>".$Idiomas[3]['name'].":</strong></td><td> <input type='text' name='nombre4' size='60' value='{$Foto['nombre4']}' /><small>Etiqueta 'Alt'</small></td></tr>";    
    } else {
        echo "<input type='hidden' name='valor[nombre4]' size='60' value='' />";
    }
    if (!empty($Idiomas[4]['name'])) {
        echo "<tr><td align='right'><strong>".$Idiomas[4]['name'].":</strong></td><td> <input type='text' name='nombre5' size='60' value='{$Foto['nombre5']}' /><small>Etiqueta 'Alt'</small></td></tr>";    
    } else {
        echo "<input type='hidden' name='valor[nombre5]' size='60' value='' />";
    }
?>
<tr>
    <td align='right'><b>Foto: </b></td>
    <td><input name="archivo" type="text" size='60' id="archivo" value='<?=$Foto['archivo'];?>'/><br/><small>Pegar la url obtenida con el Adm.de Archivos</small></td>
</tr>

</table>
<input type='hidden' name='accion' value='guardar' />
<input type='hidden' name='dpto_id' value='<?=$dpto_id;?>' />
<input type='hidden' name='foto_id' value='<?=$Foto['id'];?>' />
<center><input type='submit' name='subir_foto' value='Guardar' /></center>
</form>
