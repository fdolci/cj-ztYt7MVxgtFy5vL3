<h1><?php echo $tabs_name['disertantes'];?></h1>
<?php if (!empty($Disertantes)) { ?>
	<table style='width:550px;margin-left:75px;' >

	<?php foreach($Disertantes as $x){ ?>

		<?php  $color = iif ($color=='#FFF', '#F2F2F2', '#FFF'); ?>
		<?php if(!empty($x['estilo'])){ $color='#FFF';} ?>		

		<tr bgcolor='<?php echo $color;?>' style='border-bottom:1px solid #CCC;'>
			
			<?php if(empty($x['estilo'])){?>
				<td style='vertical-align:top'>
					<?php $foto_perfil = iif(!empty($x['archivo']) , VER_ARCHIVOS.'/'.$x['archivo'] , URL.'/img/sin_foto_perfil.jpg' );?>
					<img src='<?php echo $foto_perfil;?>' class='autoridades_imagen_perfil' title='<?php $x['nombre'];?>' />
					
				</td>
				<td style='vertical-align:top;width:450px;'>
					<div class='autoridades_nombre'>
						<?php echo trim($x['nombre']);?> 
						<?php
							$z = explode('.',$x['pais_origen']);
							$j = explode('_',$z[0]);
							$nombre_pais = '';
							foreach($j as $y){
								$nombre_pais.=ucwords($y).' ';
							}
							$nombre_pais = trim($nombre_pais);
						?>
						<span style='float:right;'>
							<small>(<?php echo $nombre_pais;?>)</small>
							<img src='<?php echo URL.'/img/flags/'.$x['pais_origen'];?>' alt='<?php echo $nombre_pais;?>' 
							style='width:20px;height:20px;margin-right:10px;margin-top:5px;'>
						</span>
					</div>
					<div class='autoridades_descripcion' ><?php echo nl2br(trim($x['descripcion']));?></div>
				</td>
			<?php } else { ?>
				<td colspan='2'><<?php echo $x['estilo'];?> class='autoridades'><?php echo $x['nombre'];?></<?php echo $x['estilo'];?>>
				</td>
			<?php } ?>
		</tr>
	<?php  } //endforeach ?>
	
	</table>

<?php } //endif ?>
