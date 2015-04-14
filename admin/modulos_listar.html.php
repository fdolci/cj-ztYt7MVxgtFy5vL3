<center>
<table width='800' border="0" >
    <tr><td colspan="2"><h2>Gestor de Módulos</h2></td></tr>    
    <tr>
	<td align='left' nowrap="nowrap" valign="middle">
        
	</td>
    <td align="right">
        <a href='modulos_contenido_edicion.php?id=0' title='Crear nuevo Módulo' class='boton1'>Crear nuevo Módulo</a>
    </td>
    
</tr>
</table>

<?php if (!empty($Publicidades)) { ?>
	<table width='800' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000">
		<tr >
			<td width='30' class="th">ID</td>
			<td width='50' class="th">Orden</td>
			<td width='100' class="th">Acciones</td>
			<td width='40%' class="th">Titulo</td>
			<td width='30' class="th">Idioma</td>
			<td class="th" >Mostrar cuando?</td>
            <td class="th" >Bloque</td>
			</tr>

		<?php foreach($Publicidades as $not) { 
            if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
        ?>
            
			<tr bgcolor='<?php echo $color;?>' >
				<td align='left' nowrap='nowrap'><?php echo $not['id'];?></td>

				<td align='center' nowrap='nowrap'>
					<a href='modulos_contenido.php?accion=orden&sube=no&id=<?php echo $not['id'];?>' title='Bajar de Nivel' >
						<img src='<?php echo ADMIN;?>img/abajo.gif' border='0' /></a>
					<a href='modulos_contenido.php?accion=orden&sube=si&id=<?php echo $not['id'];?>' title='Subir de Nivel' >
						<img src='<?php echo ADMIN;?>img/arriba.gif' border='0' /></a>
				</td>


				<td align='center' nowrap="nowrap">
					<a href='modulos_contenido.php?accion=eliminar&id=<?php echo $not['id'];?>' title='Eliminar este módulo'
						onclick="return confirm('Est&aacute; seguro de eliminar este módulo?\n <?php echo $not['titulo'];?>');">
						<img src='<?php echo ADMIN;?>img/del.gif' border='0'/></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='modulos_contenido_edicion.php?id=<?php echo $not['id'];?>' title='Editar este Módulo'>
						<img src='<?php echo ADMIN;?>img/edit.gif' border='0'/></a>&nbsp;&nbsp;&nbsp;&nbsp;

				<?php if ($not['activo']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
					<a href='modulos_contenido.php?accion=estado&id=<?php echo $not['id'];?>'
					title='Activar/Desactivar este módulo'> <img src='<?php echo ADMIN.$imagen;?>' border='0'/></a>

				</td>
				<td nowrap="nowrap"><?php echo $not['titulo'];?></td>
				<td >
					<?php 
						$idioma_id = $not['idioma_id'];
						if ($idioma_id==0){
							echo "Todos";
						} else {
							$rs = $db->SelectLimit("select name from idiomas where id='$idioma_id'",1);
							$idioma = $rs->FetchRow();
							echo $idioma['name'];
						}
					?>
				</td>
				
                <td nowrap="nowrap">[<?php echo $not['categorias'];?>] <?php echo $not['titulo1'];?> </td>

                <td nowrap="nowrap" align="center">B<?php echo $not['ubicacion'];?></td>
			</tr>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Contenidos para mostrar</span>
<?php } ?>
