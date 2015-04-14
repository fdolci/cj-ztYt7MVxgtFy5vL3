<?php if($categoria_id>1) { ?>
		<a href="contenidos_editar.php?id=0&categoria_id=<?php echo $categoria_id;?>" class="boton1" title="Crear nueva Publicación" 
			style='position:absolute;top:64;;left:900px;'>Crear nueva Publicación</a>
<?php } ?>

<?php
	if(!empty($_SESSION['Msg'])) {
		echo mensaje_ok($_SESSION['Msg']);
		$_SESSION['Msg']='';
	}
?>





<?php if (!empty($Noticias)) { ?>
	<table width='1000' cellpadding='8' cellspacing='0' style="border-width:1px; border-style:solid; border-color:#000000;margin-top:10px;">
		<tr >
			<td width='30'  class="th" colspan='2'>ID</td>
			<?php if($muestra_botones_orden){?>
				<td width='50'  class="th">Orden</td>
			<?php } ?>
			<td width='100' class="th">Acciones</td>
			<td width='60'  class="th">Update</td>
			<td width='60'  class="th">Fecha</td>            
			<td width='40%' class="th">Titulo</td>
			<td class="th" >URL Amigable</td>
            <td class="th" >Visitas</td>
            <td class="th" >Eliminar</td>
		</tr>

		<?php
            $color = ''; 
            foreach($Noticias as $not) { 
		       if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}  
        ?>
			<tr bgcolor='<?php echo $color;?>' >
				<td align='left' nowrap='nowrap'><?php echo $not['id'];?></td>
                <td align='left' nowrap='nowrap'><?php if ($not['destacado']==1){echo "<img src='".ADMIN."img/destacado.png' width='18' border='0' title='Publicacion destacada'/>";}?></td>
				<?php if($muestra_botones_orden){?>
					<td align='center' nowrap='nowrap'>
						<a href='contenidos_orden.php?sube=no&id=<?php echo $not['id'];?>&categoria_id=<?php echo $categoria_id;?>' title='Bajar de Nivel' >
							<img src='<?php echo ADMIN;?>img/abajo.gif' border='0' /></a>
						<a href='contenidos_orden.php?sube=si&id=<?php echo $not['id'];?>&categoria_id=<?php echo $categoria_id;?>' title='Subir de Nivel' >
							<img src='<?php echo ADMIN;?>img/arriba.gif' border='0' /></a>
					</td>
				<?php } ?>	

				<td align='center' nowrap="nowrap">
					<a href='contenidos_editar.php?id=<?php echo $not['id'];?>&categoria_id=<?php echo $not['categoria_id'];?>'
						title='Editar esta publicaci&oacute;n'>
						<img src='<?php echo ADMIN;?>img/edit.gif' border='0'/></a>&nbsp;&nbsp;&nbsp;&nbsp;
					<?php if($not['categoria_id']>1){ ?>
						<?php if ($not['activo']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
						<a href='contenidos.php?accion=estado&id=<?php echo $not['id'];?>&categoria_id=<?php echo $not['categoria_id'];?>'
						title='Activar/Desactivar esta publicaci&oacute;n'> <img src='<?php echo ADMIN.$imagen;?>' border='0'/></a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href='contenidos.php?accion=duplicar&id=<?php echo $not['id'];?>&categoria_id=<?php echo $not['categoria_id'];?>'
						title='Duplicar esta publicaci&oacute;n'> <img src='<?php echo ADMIN."img/duplicar.png";?>' border='0'/></a>

					<?php } ?>


				</td>
                <td nowrap='nowrap'><?php echo date("d-m-Y",$not['modificado']);?></td>
                <td nowrap='nowrap'><?php echo date("d-m-Y",$not['fecha']);?></td>                
				<td nowrap="nowrap">
					<?php if($not['pagina_inicio'] == 1) { ?>
						<img src='<?php echo ADMIN;?>img/pagina_inicio.gif' border='0' />
					<?php } ?>
					<?php echo substr($not['titulo1'],0,50);?>
				</td>
				<td nowrap="nowrap"><?php echo $not['urlamigable1'];?></td>
                <td align="right"><?php echo $not['lecturas'];?></td>
                <td align="right">
					<?php if($not['categoria_id']>1){ ?>
						<?php if ($not['activo'] == 1) { ?>
							<img src='<?php echo ADMIN;?>img/del_inactivo.gif' border='0' title="La publicación debe estar inactiva para poder eliminarla!"/>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php } else { ?>
							<a href='contenidos.php?accion=delete&id=<?php echo $not[id];?>&categoria_id=<?php echo $not['categoria_id'];?>'
								title='Eliminar esta publicaci&oacute;n'
								onclick="return confirm('Est&aacute; seguro de eliminar esta publicaci&oacute;n?\n <?php echo $not['titulo'];?>');">
								<img src='<?php echo ADMIN;?>img/del.gif' border='0'/></a>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php } ?>
					<?php } ?>
                </td>
			</tr>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Contenidos para mostrar</span>
<?php } ?>

