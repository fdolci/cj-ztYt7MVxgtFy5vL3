<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>



<style>
	#test-list {
		list-style: none;
	}

	#test-list li {
		display: block;
		/* padding: 20px 10px;  */
		margin-bottom: 3px;
		background-color: #efefef;
	}

	#test-list li img.handle {
		margin-right: 20px;
		cursor: move;
	}
</style>


<?php if (!empty($ax)) { ?>
	<div id="info"></div> 
	
	<table width='100%' style="border-width:1px; border-style:solid; border-color:#001860;" cellpadding='8' cellspacing="1">
		<tr bgcolor='#001860'>
			<td width='20' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Orden</td>
			<td width='80' align='center' style="color:#FFFFFF; font-weight:bold; font-size:12px;">Acci&oacute;n</td>
			<td style="color:#FFFFFF; font-weight:bold; font-size:12px; width:40px;">Archivo</td>
			<td style="color:#FFFFFF; font-weight:bold; font-size:12px;">Título | Descripción</td>
		</tr>
	</table>	
	<ul id="test-list" style='margin:0 0 10px 0;'> 	
	<?php foreach($ax as $x){ ?>
		<li id="listItem_<?php echo $x['id'];?>">
		<?php  $color = iif ($color=='#DFECFF', '#D3DFF1', '#DFECFF'); ?>

			<table width='100%' >
				<tr>
					<td width='20' style="color:#000000; font-weight:bold; font-size:12px;text-align:center;">
						<img src="<?php echo URL;?>/img/arrow.png" alt="move" width="16" height="16" class="handle" title='Arrastre para ordenar'/>
					</td>

					<td width='80' align='center' style="color:#000000; font-weight:bold; font-size:12px;">
						<a href='aviso_disertantes.html.php?accion=eliminar&producto_id=<?php echo $producto_id;?>&id=<?php echo $x['id'];?>'
							title='Eliminar este Item'
							onclick="return confirm('Est&aacute; seguro de eliminar este Item?');">
							<img src='<?php echo ADMIN;?>img/del.gif' border='0' /></a>&nbsp;&nbsp;&nbsp;&nbsp;

						<a href='aviso_disertantes.html.php?accion=estado&producto_id=<?php echo $producto_id;?>&id=<?php echo $x['id'];?>' title='Activar / Desactivar' >
							<?php if ($x['activo']==1){ echo "<img src='".ADMIN."img/activo.gif' border='0' />";
							} else { echo "<img src='".ADMIN."img/inactivo.gif' border='0' />"; }?>
						</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href='aviso_disertantes.html.php?accion=editar&producto_id=<?php echo $producto_id;?>&id=<?php echo $x['id'];?>' title='Editar este Item'>
							<img src='<?php echo ADMIN;?>img/edit.gif' border='0' /></a>
					</td>

					<?php if (empty($x['estilo'])) { ?>
						<td style="text-align:center;" valign='middle' style='width:50px;'>
							<?php $foto_perfil = iif(!empty($x['archivo']) , VER_ARCHIVOS.'/'.$x['archivo'] , URL.'/img/sin_foto_perfil.jpg' );?>
							<img src='<?php echo $foto_perfil;?>' height='40' width='40' title='<?php echo $x['nombre'];?>' />
						</td>
						<td style="color:#000000; font-weight:bold; font-size:12px; width:535px;" valign='middle'>
							<img src='<?php echo URL.'/img/flags/'.$x['pais_origen'];?>' style='width:20px;height:20px;margin-right:10px;'>
							<?php echo $x['nombre'];?><small><br><?php echo $x['descripcion'];?></small>
						</td>
					<?php } else { ?>
						<td >
							<<?php echo $x['estilo'];?> class='autoridades'><?php echo $x['nombre'];?></<?php echo $x['estilo'];?>>
						</td>
					<?php } ?>
					 
				</tr>
			</table>
		</li>
	<?php  } //endforeach ?>
	<ul>

	
<?php } //endif ?>

<script type="text/javascript">
  // When the document is ready set up our sortable with it's inherant function(s)
  $(document).ready(function() {
    $("#test-list").sortable({
      handle : '.handle',
      update : function () {
		var order = $('#test-list').sortable('serialize');
		$("#info").load("<?php echo URL;?>/account/aviso_disertantes.html.php?producto_id=<?php echo $producto_id;?>&"+order);
      }
    });
});
</script>
