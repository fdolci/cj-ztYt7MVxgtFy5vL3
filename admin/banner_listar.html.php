<?php
	$cond 		= "select * from slides order by nombre ASC";
	$rs 		= $db->Execute($cond);
	$Noticias 	= $rs->GetRows();

	if (!empty($Noticias)) { ?>
	<table width='800' cellpadding='8' cellspacing='0' border='1'>
		<tr  >
			<td width='30' class="th">ID</td>
			<td width='50' class="th">Acciones</td>
			<td class="th">Nombre</td>
			<td width='30' class="th">Idioma</td>
            <td width='10' class="th"></td>
			</tr>

		<?php foreach($Noticias as $not) {
		  if ($color=='#DFECFF')  {$color = '#D3DFF1';} else {$color = '#DFECFF';}
		?>

			<tr bgcolor='<?php echo $color;?>' >
				<td align='center'>	<?php echo $not[id];?> </td>
				<td align='center'>
					<a href='<?php echo ADMIN;?>banner.php?accion=editar&id=<?php echo $not['id'];?>'
						title='Editar este Banner'>
						<img src='<?php echo ADMIN;?>img/edit.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;

				<?php if ($not[activo]==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
					<a href='banner.php?accion=estado&id=<?php echo $not[id];?>'
					title='Activar/Desactivar este Banner'>
					<img src='<?php echo ADMIN;?><?php echo $imagen;?>' border='0'/></a>
				</td>
				<td ><?php echo $not['nombre'];?></td>
               
                <td>
                    <?php if ($not[activo]==1) { ?>
                        <img src='<?php echo ADMIN;?>img/del.gif' border='0' title="Para poder elimnar este banner, primero debe desactivarlo"/>
                    <?php } else { ?>
                    <a href='<?php echo ADMIN;?>banner.php?accion=delete&id=<?php echo $not['id'];?>'
    				    title='Eliminar este Banner'
    					onclick="return confirm('Est&aacute; seguro de eliminar este Banner?');">
    					<img src='<?php echo ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php } ?>
                </td>
			</tr>
		<?php } ?>

	</table>
<?php } else { ?>
	<span class='titulo'>No hay Banners para mostrar</span>
<?php } ?>
