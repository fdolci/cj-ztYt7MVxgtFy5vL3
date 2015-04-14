<center>
<table width='80%' style="border-width:1px; border-style:solid; border-color:#000000;" cellpadding='8' cellspacing="1">
	<tr bgcolor='#000'>
		<td width='10' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">ID</td>
		<td width='20' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Orden</td>
		<td width='80' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Acci&oacute;n</td>
		<td width='80' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Foto</td>
        <td  align='left' style="color:#FFFFFF; font-size:12px;">Descripcion</td>
	</tr>
<?php
	$sql = "select * from galerias_fotos where galeria_id='$galeria_id' order by orden ASC";
	$rs  = $db->Execute($sql);
    $ax = $rs->GetRows();
    
	if (empty($ax)) {
		echo "<tr><td colspan='4'><h3><center>No existen fotos para esta Galeria</center></h3></td></tr>";
	} else {
		$color = '';
        foreach($ax as $x){
			if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
?>
	<tr bgcolor=<?=$color;?> >
		<td width='10' style="color:#000000; font-weight:bold; font-size:12px;"><?=$x['id'];?></td>
		<td width='20' style="color:#000000; font-weight:bold; font-size:12px;">
			<a href="pubgaleria_acciones.php?accion=foto_orden&sube=no&galeria_id=<?=$galeria_id;?>&foto_id=<?=$x['id'];?>"
				title='Bajar de Nivel' >	<img src='<?=ADMIN;?>img/abajo.gif' border='0' /></a>
			<a href='pubgaleria_acciones.php?accion=foto_orden&sube=si&galeria_id=<?=$galeria_id;?>&foto_id=<?=$x['id'];?>'
				title='Subir de Nivel' >	<img src='<?=ADMIN;?>img/arriba.gif' border='0' /></a>

		</td>
		<td width='20' align='center' style="color:#000000; font-weight:bold; font-size:12px;">
			<a href='pubgaleria_acciones.php?accion=foto_eliminar&galeria_id=<?=$galeria_id;?>&foto_id=<?=$x['id'];?>'
				title='Eliminar esta Foto'
				onclick="return confirm('Est&aacute; seguro de eliminar esta Foto?');">
				<img src='<?=ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='pubgaleria_acciones.php?accion=foto_estado&galeria_id=<?=$galeria_id;?>&foto_id=<?=$x['id'];?>' title='Activar / Desactivar' >
				<?php if ($x['activo']==1){ echo "<img src='".ADMIN."img/activo.gif' border='0' />";
				} else { echo "<img src='".ADMIN."img/inactivo.gif' border='0' />"; }
				?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='pubgaleria_acciones.php?accion=foto_editar&galeria_id=<?=$galeria_id;?>&foto_id=<?=$x['id'];?>' title='Editar esta Foto'>
				<img src='<?=ADMIN;?>img/edit.gif' border='0' /></a>

		</td>

		<td style="color:#000000; font-weight:bold; font-size:12px;" valign='middle'>
			<img src='<?=$x['archivo'];?>' height='70' width='70' title="<?=$x['nombre1'];?>" /> 
		</td>
        <td  align='left' style="color:#000; font-size:12px;">
<?php
    if (!empty($Idiomas[0]['name'])) { echo '<div style="width:60px;display:inline-block;">'.$Idiomas[0]['name'].":</div> {$x['nombre1']}<br/>"; }
    if (!empty($Idiomas[1]['name'])) { echo '<div style="width:60px;display:inline-block;">'.$Idiomas[1]['name'].":</div> {$x['nombre2']}<br/>"; }
    if (!empty($Idiomas[2]['name'])) { echo '<div style="width:60px;display:inline-block;">'.$Idiomas[2]['name'].":</div> {$x['nombre3']}<br/>"; }
    if (!empty($Idiomas[3]['name'])) { echo '<div style="width:60px;display:inline-block;">'.$Idiomas[3]['name'].":</div> {$x['nombre4']}<br/>"; }
    if (!empty($Idiomas[4]['name'])) { echo '<div style="width:60px;display:inline-block;">'.$Idiomas[4]['name'].":</div> {$x['nombre5']}<br/>"; }        
    

?>

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

<script type="text/javascript" src="<?php echo URL;?>/admin/contenidos_editar.js"></script>
<link href="<?php echo RUTA;?>/css/texto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo URL;?>/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URL;?>/js/ckfinder/ckfinder.js"></script>


<form name='foto' action='pubgaleria_acciones.php?accion=<?=$accion;?>' method='post' >

<table width="100%">
<?php
    if ($foto_id == 0 ){
        $Foto['nombre1'] = '';
        $Foto['nombre2'] = '';
        $Foto['nombre3'] = '';
        $Foto['nombre4'] = '';
        $Foto['nombre5'] = '';
        $Foto['archivo'] = '';
    }

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
    <td>
<input type="text" name="archivo" id="archivo" size='60' maxlength='255' value="<?=$Foto['archivo'];?>" />
<input type="button" value="Buscar en el servidor" onclick="BrowseServer( 'Images:/', 'archivo' );" />


    </td>
</tr>

</table>
<input type='hidden' name='accion' value='guardar' />
<input type='hidden' name='galeria_id' value='<?=$galeria_id;?>' />
<input type='hidden' name='foto_id' value='<?=$Foto['id'];?>' />
<center><input type='submit' name='subir_foto' value='Guardar' /></center>
</form>
