<h3>Archivos para Descargar</h3>
<?php if (!empty($Archivos)) { ?>
	<table width='100%' >
		<tr bgcolor='#D3DFF1'>
			<td style="color:#000; font-weight:bold; font-size:12px; width:40px;padding:5px;text-align:center;">Archivo</td>
			<td style="color:#000; font-weight:bold; font-size:12px;padding:5px;">Título | Descripción</td>
		</tr>


	<?php foreach($Archivos as $x){ ?>

		<?php  $color = iif ($color=='#FFF', '#E3EAF5', '#FFF'); ?>

		<tr bgcolor='<?php echo $color;?>'>

			<td style="color:#000000; font-weight:bold; font-size:12px; width:100px; text-align:center;" valign='middle'>
				<?php 
					$z     = explode('.',$x['archivo']);
					$extension = end($z);
					$icono = obtiene_icono($extension);
				?>
				<a href='<?php echo URL;?>/download.php?id=<?php echo $x['id'];?>' title='Descargar'>
				<img src='<?php echo $icono;?>' style='height:50px; width:50px;padding:10px;' title="<?php $x['descripcion'];?>" /></a>
			</td>
			<td style="color:#000000; font-weight:bold; font-size:12px;" valign='middle'>
				<?php echo $x['titulo'];?><small><br><?php echo $x['descripcion'];?></small>
			</td>

		</tr>
	<?php  } //endforeach ?>
	
	</table>
<?php } //endif ?>
